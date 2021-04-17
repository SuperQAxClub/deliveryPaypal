<?php
    include '../function.php';
    global $dbconnect,$currentTime;
    
    $error = array();
    $data = array();

    $fullname = $_POST['fullName'];
    $username = $_POST['userName'];
    $password = $_POST['password'];
    $retype = $_POST['confirmPassword'];

    //Check existing username
    $usernameResult = runDbReturn("SELECT userName FROM user WHERE username = ?","s",array($username),'numRows');
    //Input error
    if(empty($fullname) || empty($username) || empty($password) || empty($retype)) {
        $error['empty'] = "empty";
    } else {
        if(strlen($password) < 8) {
            $error['password'] = "passwordShort";
        } else if($password != $retype) {
            $error['confirmPassword'] = "confirmPasswordWrong";
        }
        if(strlen($fullname) < 3 || $fullname > 50) {
            $error['fullName'] = "fullnameShort";
        }
        if(strlen($username) < 4 || strlen($username) > 20) {
            $error['userName'] = "usernameShort";
        }
        $data['error'] = $error;
    }
    //Exist input
    if(empty($error)) {
        if($usernameResult > 0) {
            $error['userName'] = "usernameExist";
        }
        $data['error'] = $error;
    }

    //Respond
    if(!empty($error)) {
        $data['success'] = false;
        $data['reason'] = $error;
    } else {
        $hashedPassword = password_hash($password,PASSWORD_DEFAULT);
        $userID = createUserID();
        
        $addUser = runDbReturn("INSERT INTO user(userID, fullName, userName, password, type) VALUES(?, ?, ?, ?, ?)","sssss",array($userID, $fullname, $username, $hashedPassword, 'user'),'affected');
        if($addUser < 1) {
            $error['reason'] = "dberror";
            $data['success'] = false;
        } else {
            $data['success'] = true;
        }
    }
    if($error) {
        $data['error'] = $error;
        $data['success'] = false;
    }
    echo json_encode($data);
?>