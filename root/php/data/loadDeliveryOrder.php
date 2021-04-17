<?php
    include '../function.php';
    global $dbconnect,$currentTime;

    $userID = getUserID();

    function translateStatus($status) {
        if($status == 'waiting') {
            return 'Đang chờ lấy hàng';
        } else if($status == 'delivering') {
            return 'Đang vận chuyển';
        } else {
            return 'Hoàn thành';
        }
    }
    
    $getOrder = runDbReturn("SELECT * FROM deliveryOrder o, deliveryPerson p WHERE o.id = p.orderID AND p.userID = ?","s",array($userID),'return');
    while($row = $getOrder->fetch_assoc()) {
        $orderID = $row['id'];
        $getDeliveryName = runDbReturn("SELECT u.fullName FROM user u, deliveryPerson d WHERE u.userID = d.userID AND orderID = ?","i",array($orderID),'return');
        $rowName = $getDeliveryName->fetch_assoc();
        $deliveryName = $rowName['fullName'];
    ?>
        <div class="row-25">
            <div class="d-box" id="callModal" data-modal="deliveryDetailEmployee" data-content="<?php echo $row['id']; ?>">
                Mã đơn hàng: <b><?php echo $row['id']; ?></b><br/>
                Từ <b><?php echo $row['sendAddress']; ?></b> đến <b><?php echo $row['receiveAddress']; ?></b><br/>
                Người nhận: <b><?php echo $row['receiveName']; ?></b><br/>
                Tên hàng: <b><?php echo $row['sendProduct']; ?></b><br/>
                Nhân viên giao hàng: <b><?php echo $deliveryName; ?></b><br/>
                Trạng thái: <span class="orange-text"><?php echo translateStatus($row['status']); ?></span>
            </div>
        </div>
    <?php }
?>