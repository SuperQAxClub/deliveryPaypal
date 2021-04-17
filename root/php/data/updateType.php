<?php
    include '../function.php';
    global $dbconnect,$currentTime;
    
    $error = array();
    $data = array();

    $updateType = $_POST['updateType'];
    $orderID = $_POST['orderID'];

    $updateStatus = runDbReturn("UPDATE deliveryOrder SET status = ? WHERE id = ?", "si", array($updateType,$orderID),'affected');
    if($updateStatus == 0) {
        $error['reason'] = 'dberror';
    } else {
        $data['success'] = true;
    }
    
    if($error) {
        $data['error'] = $error;
        $data['success'] = false;
    }
    echo json_encode($data);
?>