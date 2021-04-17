<?php
    include '../function.php';
    global $dbconnect,$currentTime,$userip,$useragent;
    
    $error = array();
    $data = array();
    $wrongMsg = 'wrongInfo';

    $userName = $_POST['userName'];
    $password = $_POST['password'];
    if(@$_POST['remember'] == "true") {
        $remember = 1;
    } else {
        $remember = 0;
    }

    //Check account
    $userResult = runDbReturn("SELECT userID, userName, password FROM user WHERE userName = ? AND type = 'delivery'","s",array($userName),"return");
    $rowUser = $userResult->fetch_assoc();

    //Input error
    if(empty($userName) || empty($password)) {
        $error['empty'] = 'empty';
    } else if($userResult->num_rows < 1) {
        $error['userName'] = $wrongMsg;
        $error['password'] = $wrongMsg;
    } else if($userResult->num_rows == 1 && !password_verify($password, $rowUser['password'])) {
        $error['userName'] = $wrongMsg;
        $error['password'] = $wrongMsg;
    } else {
        $userID = $rowUser['userID'];

        $sesToken = createSessionToken();
        if($remember == 1) {
            $expire = time()+(15 * 24 * 60 * 60);
        } else {
            $expire = 0;
        }

        $addSession = runDbReturn("INSERT INTO userSessions(sessionID, userID, ipAddress, userAgent, expire, remember) VALUES (?, ?, ?, ?, ?, ?)","ssssii",array($sesToken, $userID, $userip, $useragent, $expire, $remember),'affected');

        if($addSession < 1) {
            $error['reason'] = 'loginError';
            $data['success'] = false;
        } else {
            $data['success'] = true; 
            if($remember == 0) {
                $_SESSION['sessionToken'] = $sesToken;
            } else {
                setcookie("cookieToken",$sesToken,$expire,"/","collabvn.ga");
            }
        }
    }
    $data['error'] = $error;

    echo json_encode($data);
?>