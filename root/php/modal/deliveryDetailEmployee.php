<?php
    include '../function.php';
    global $dbconnect;

    $orderID = $_POST['dataContent'];

    $getStatus = runDbReturn("SELECT status FROM deliveryOrder WHERE id = ?","i",array($orderID),'return');
    $row = $getStatus->fetch_assoc();
    $status = $row['status'];
?>
<div class="modal-header">
    <div class="header-title">Cập nhật đơn hàng</div>
    <div class="header-close" id="closeModal"><ion-icon name="close"></ion-icon></div>
</div>
<div class="modal-body" data-order="<?php echo $orderID;?>">
    <?php 
        if($status == 'waiting') { ?>
            <button class="collab-button full-width update-status orange-color" id="delivering">Đang vận chuyển</button>
        <?php } else if ($status == 'delivering') { ?>
            <button class="collab-button full-width update-status green-color" id="done">Hoàn thành</button>
        <?php } else { ?>
            <button class="collab-button full-width disabled">Đã hoàn thành</button>
        <?php 
        }
    ?>
</div>