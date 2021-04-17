<?php
    include '../function.php';
    global $dbconnect,$currentTime;
    
    $error = array();
    $data = array();

    $userID = getUserID();
    $sendAddress = $_POST['sendAddress'];
    $receiveAddress = $_POST['receiveAddress'];
    $receiveName = $_POST['receiveName'];
    $sendProduct = $_POST['sendProduct'];
    $sendNumber = $_POST['sendNumber'];

    if(empty($sendAddress) || empty($receiveAddress) || empty($receiveName) || empty($sendProduct) || empty($sendNumber)) {
        $error['empty'] = "empty";
    } else if (!is_numeric($sendNumber)) {
        $error['sendNumber'] == 'numInvalid';
    } else {
        $addOrder = runDbReturn("INSERT INTO deliveryOrder (userID, sendAddress, receiveAddress, receiveName, sendProduct, sendNumber,status) VALUES (?,?,?,?,?,?,?)","sssssis",array($userID,$sendAddress,$receiveAddress,$receiveName,$sendProduct,$sendNumber,'waiting'),'affected');
        if($addOrder == 0) {
            $error['reason'] = 'dberror';
        } else {
            $orderID = $dbconnect->insert_id;
            $getAvailableDeliveryID = runDbReturn("SELECT userID FROM user WHERE type = ? AND userID NOT IN (SELECT userID FROM deliveryPerson) LIMIT 1","s",array('delivery'),'return');
            if($getAvailableDeliveryID->num_rows == 0) {
                $error['reason'] = 'noDelivery';
            } else {
                $row = $getAvailableDeliveryID->fetch_assoc();
                $deliveryID = $row['userID'];
                $addDeliveryPerson = runDbReturn("INSERT INTO deliveryPerson(userID, orderID) VALUES(?,?)","ss",array($deliveryID,$orderID),'affected');
                if($addDeliveryPerson == 0) {
                    $error['reason'] = 'dberror';
                } else {
                    $data['success'] = true;
                }
            }
        }
    }

    if($error) {
        $data['error'] = $error;
        $data['success'] = false;
    }
    echo json_encode($data);
?>