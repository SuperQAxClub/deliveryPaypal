<div class="modal-header">
    <div class="header-title">Yêu cầu giao hàng</div>
    <div class="header-close" id="closeModal"><ion-icon name="close"></ion-icon></div>
</div>
<div class="modal-body">
    <form id="addOrder">
        <div class="collab-input" style="margin-top: -20px">
            <div class="input-container">
                <div class="input-error-content"></div>
                <div class="input-icon">
                    <ion-icon name="log-out"></ion-icon>
                </div>
                <div class="input-main">
                    <input type="text" name="sendAddress" placeholder=" ">
                    <label>Địa chỉ người gửi</label>
                </div>
            </div>
            <div class="input-container">
                <div class="input-error-content"></div>
                <div class="input-icon">
                    <ion-icon name="log-in"></ion-icon>
                </div>
                <div class="input-main">
                    <input type="text" name="receiveAddress" placeholder=" ">
                    <label>Địa chỉ người nhận</label>
                </div>
            </div>
            <div class="input-container">
                <div class="input-error-content"></div>
                <div class="input-icon">
                    <ion-icon name="person"></ion-icon>
                </div>
                <div class="input-main">
                    <input type="text" name="receiveName" placeholder=" ">
                    <label>Tên người nhận</label>
                </div>
            </div>
            <div class="input-container">
                <div class="input-error-content"></div>
                <div class="input-icon">
                    <ion-icon name="cube"></ion-icon>
                </div>
                <div class="input-main">
                    <input type="text" name="sendProduct" placeholder=" ">
                    <label>Tên hàng gửi</label>
                </div>
            </div>
            <div class="input-container">
                <div class="input-error-content"></div>
                <div class="input-icon">
                    <ion-icon name="file-tray-full"></ion-icon>
                </div>
                <div class="input-main">
                    <input type="text" name="sendNumber" placeholder=" ">
                    <label>Số lượng</label>
                </div>
            </div>
        </div>
    </form>
    <!-- <button id="addorder">f</button> -->
    <div class="collab-row">
        <div class="row-40">
            <div class="paypal-title">Thanh toán</div>
            <div class="paypal-cash">10 USD</div>
        </div>
        <div class="row-60">
            paypal
        </div>
    </div>
</div>