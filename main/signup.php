<?php 
    if(isset($_COOKIE['cookieToken']) && isset($_SESSION['sessionToken'])) {
        header("Location: http://placeholder.collabvn.ga/");
    }
?>
<title>Đăng ký</title>
<div class="d-login-bg"></div>
<div class="d-login-container">
    <div class="login-box">
        <div class="login-title">Đăng ký</div>
        <form id="signupForm">
            <div class="collab-input">
                <div class="input-container">
                    <div class="input-error-content"></div>
                    <div class="input-icon">
                        <ion-icon name="person"></ion-icon>
                    </div>
                    <div class="input-main">
                        <input type="text" name="fullName" placeholder="Nhập tên đầy đủ của bạn">
                        <label>Tên đầy đủ</label>
                    </div>
                </div>
                <div class="input-container">
                    <div class="input-error-content"></div>
                    <div class="input-icon">
                        <ion-icon name="person"></ion-icon>
                    </div>
                    <div class="input-main">
                        <input type="text" name="userName" placeholder="Nhập tên đăng nhập của bạn">
                        <label>Tên đăng nhập</label>
                    </div>
                </div>
                <div class="input-container">
                    <div class="input-error-content"></div>
                    <div class="input-icon">
                        <ion-icon name="key"></ion-icon>
                    </div>
                    <div class="input-main">
                        <input type="password" name="password" placeholder="Nhập mật khẩu của bạn">
                        <label>Mật khẩu</label>
                    </div>
                </div>
                <div class="input-container">
                    <div class="input-error-content"></div>
                    <div class="input-icon">
                        <ion-icon name="key"></ion-icon>
                    </div>
                    <div class="input-main">
                        <input type="password" name="confirmPassword" placeholder="Nhập lại mật khẩu của bạn">
                        <label>Nhập lại mật khẩu</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="collab-button full-width">Đăng ký</button>

            <div class="login-signup"><a href="/login">Đăng nhập tài khoản</a></div>
        </form>
    </div>
</div>