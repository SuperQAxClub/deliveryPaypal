<?php 
    if(!isset($_COOKIE['cookieToken']) && !isset($_SESSION['sessionToken'])) {
        header("Location: http://placeholder.collabvn.ga/loginDelivery");
    }
?>
<div class="d-navbar">
    <div class="nav-title">Delivery</div>
    <div class="nav-right">
        <div class="nav-item">
            <a href="/signout">
                <div class="item-icon">
                    <ion-icon name="log-out"></ion-icon>
                </div>
            </a>
        </div>
    </div>
</div>
<div class="d-content">
    <div class="collab-row" id="loadDeliveryOrder">
        <div class="row-25">
            <div class="d-box" id="callModal" data-modal="deliveryDetailEmployee" data-content="<?php echo $row['id']; ?>">
                Mã đơn hàng: <b>123456</b><br/>
                Từ <b>Địa chỉ A</b> đến <b>Địa chỉ B</b><br/>
                Người nhận: <b>Trần Văn A</b><br/>
                Tên hàng: <b>iPhone 12</b><br/>
                Nhân viên giao hàng: <b>Nguyễn Văn D</b><br/>
                Trạng thái: <span class="orange-text">Đang giao hàng</span>
            </div>
        </div>
    </div>
</div>