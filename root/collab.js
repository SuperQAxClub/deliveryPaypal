//--RESIZE FIX
function fixSize() {
    var getWidth = window.innerWidth;
    var getHeight = window.innerHeight;
    $('.login-center .login-box').css({'height':getHeight+'px'});
    $('.login-center .login-box .box-right').css({'height':'calc('+getHeight+'px - 122px)'});
}
$(window).on('resize', function(){
    fixSize();
})
$(window).on('load',function() {
    var getPath = window.location.pathname;
    var pathArr = getPath.split('/');
    var pathType = pathArr[1];
    if(pathType == '') {
        
    }
})
//Function
//--Notification
function callNoti(type, delay, title, content) {
    if($('.noti-container')[0]) {
        hideNoti(function(){
            showNoti();
        })
    } else {
        showNoti();
    }
    function showNoti() {
        if(type == 'noti-error') {
            notiIcon = '<ion-icon name="close-circle"></ion-icon>';
        } else if (type == 'noti-success') {
            notiIcon = '<ion-icon name="checkmark-circle"></ion-icon>';
        } else if (type == 'noti-loading') {
            notiIcon = '<div class="noti-spinner-container"><div class="collab-spinner active"></div></div>';
        } else {
            notiIcon = '<ion-icon name="alert-circle"></ion-icon>';
        }
        $('.collab-noti').prepend(`
            <div class="noti-container `+type+`">
                <div class="noti-gradient"></div>
                <div class="noti-close"><ion-icon name="close"></ion-icon></div>
                <div class="content-container">
                    <div class="noti-icon">`+notiIcon+`</div>
                    <div class="noti-content">
                        <div class="noti-title">`+title+`</div>
                        `+content+`
                    </div>
                </div>
            </div>
        `);
        setTimeout(function(){
            $('.noti-container').addClass('slide-in');
            if(delay == 0) {
                delay = 100000;
            }
            delayHide = setTimeout(function(){
                $('.noti-container').removeClass('slide-in');
                setTimeout(function(){
                    $('.collab-noti').html('');
                },300)
            },delay)
        },0);
    }
}
function hideNoti(callback) {
    //clearTimeout(delayHide);
    $('.noti-container').removeClass('slide-in');
    setTimeout(function(){
        $('.collab-noti').html('');
        if(callback) {
            callback();
        }
    },300)
}
$(document).on('click','.noti-close',function(){
    hideNoti();
})
function showNotiError(title, content) {
    callNoti('noti-error', 5000, title, content);
}
function showNotiSuccess(title, content) {
    callNoti('noti-success', 5000, title, content);
}
function showNotiLoading(title, content) {
    callNoti('noti-loading', 10000, title, content);
}
function permNoti() {
    callNoti('noti-error', 5000, 'Lỗi máy chủ', 'Bạn không có quyền truy cập mục này');
}
function errorNoti() {
    callNoti('noti-error', 10000, 'Lỗi máy chủ', 'Máy chủ đã gặp lỗi, vui lòng thử lại sau');
}
function dberrorNoti() {
    callNoti('noti-error', 10000, 'Lỗi cơ sở dữ liệu', 'Cơ sở dữ liệu của máy chủ đã gặp sự cố, vui lòng thử lại sau');
}
//Call modal
function callModal(modalType,dataModal,dataContent,width) {
    formData = new FormData();
    formData.append('dataContent',dataContent);

    $('.collab-'+modalType).addClass('active');
    $('.collab-'+modalType+'-overlay').addClass('active');

    fetch("/php/"+modalType+"/"+dataModal+".php",{
        method: 'POST',
        body: formData
    })
    .then(res => {
        if(res.ok) {
            return res.text();
        } else {
            return Promise.reject(res.status);
        }
    }).then(function(response){
        checkErrorCode(response,function(check){
            if(check == 'error') {
                closeModal(modalType);
            } else {
                setTimeout(function(){
                    if(width > 0) {
                        $('.collab-'+modalType).css({'width' : requestedWidth+'px'});
                    }
                    $('.collab-'+modalType+' .modal-loading').addClass('hide-loading');
                    $('.collab-'+modalType+' .modal-content').html(response);
                    currentHeight = $('.collab-'+modalType+' .modal-content').height();
                    $('.collab-'+modalType).css({'height' : currentHeight+'px'});
                    setTimeout(function(){
                        $('.collab-'+modalType+' .modal-content').addClass('show-content');
                        loadPaypal();
                    },200);
                },400)
                fixSize();
                // $("#datepick").datepicker({
                //     dateFormat: "dd/mm/yy"
                // });
                selectedArray = [];
            }
        })
    }).catch(function(e){
        checkErrorCode(e);
        closeModal(modalType);
    })
}
function closeModal(modalType) {
    $('.collab-'+modalType).removeClass('active');
    $('.collab-'+modalType+'-overlay').removeClass('active');
    setTimeout(function(){
        $('.collab-'+modalType+' .modal-loading').removeClass('hide-loading');
        $('.collab-'+modalType+' .modal-content').removeClass('show-content');
        $('.collab-'+modalType+' .modal-content').html('');
        $('.collab-'+modalType).css({'width':'400px'}); 
        $('.collab-'+modalType).css({'height':'160px'});  
    },400)
}
$(document).on('click','#callAlert',function () { 
    dataAlert = $(this).attr('data-alert');
    dataContent = $(this).attr('data-content');
    callModal('alert',dataAlert,dataContent,0);
})
$(document).on('click','#callModal',function () { 
    dataModal = $(this).attr('data-modal');
    dataContent = $(this).attr('data-content');
    requestedWidth = $(this).attr('data-width');
    callModal('modal',dataModal,dataContent,requestedWidth);
})
$(document).on('click','#closeAlert',function(){
    closeModal('alert');
})
$(document).on('click','#closeModal',function(){
    closeModal('modal');
})

//Check input error
function checkInputError(form, data) {
    for(var e in data.error) {
        if(e == 'empty') {
            $('#'+form+' input').each(function(){
                if ($(this).val()  == "") {
                    setEmptyInputError(this);       
                } 
            });
        } else if(e == 'reason') {
            checkErrorCode(data.error[e]);
        } else {
            setInputError(form,e,checkInputCode(data.error[e]));
        }
    }
}
//Check input codes
function checkInputCode(error) {
    switch(error) {
        case "wrongInfo": 
            return "Thông tin đăng nhập sai";
        case "passwordShort":
            return "Mật khẩu quá ngắn";
        case "confirmPasswordWrong":
            return "Mật khẩu nhập lại không khớp";
        case "fullnameShort":
            return "Tên đầy đủ quá ngắn";
        case "emailShort":
            return "Địa chỉ Email quá ngắn";
        case "emailInvalid":
            return "Địa chỉ Email không hợp lệ";
        case "usernameShort":
            return "Tên người dùng quá ngắn";
        case "emailExist":
            return "Địa chỉ Email đã tồn tại";
        case "usernameExist":
            return "Tên người dùng đã tồn tại";
        case "numInvalid":
            return "Hãy điền số vào mục này";
    }
}
//Check error codes
function checkErrorCode(error,callback) {
    function callbackCheck(response) {
        if(callback) {
            callback(response);
        }
    }
    switch(error) {
        //Server
        case "permission":
            permNoti();
            callbackCheck('error');
            break;
        case "invalid":
            showNotiError("Lỗi dữ liệu","Yêu cầu không hợp lệ");
            callbackCheck('error');
            break;
        case "dberror":
            dberrorNoti();
            callbackCheck('error');
            break;
        case "mailNotExist":
            showNotiError("Lỗi máy chủ","Địa chỉ Email không tồn tại");
            callbackCheck('error');
            break;
        case "loginError":
            showNotiError("Lỗi máy chủ","Đã xảy ra lỗi đăng nhập");
            callbackCheck('error');
            break;
        case "noDelivery":
            showNotiError("Lỗi yêu cầu","Không có nhân viên giao hàng khả dụng");
            callbackCheck('error');
            break;
        //Error codes
        case 403: 
            showNotiError('Lỗi tải dữ liệu','Bạn không có quyền truy cập mục này');
            callbackCheck('error');
            break;
        case 404: 
            showNotiError('Lỗi tải dữ liệu','Không tìm thấy trang bạn yêu cầu');
            callbackCheck('error');
            break;
        case 500: 
            showNotiError('Lỗi tải dữ liệu','Lỗi máy chủ nội bộ');
            callbackCheck('error');
            break;
        case 502: 
            showNotiError('Lỗi tải dữ liệu','Lỗi gateway');
            callbackCheck('error');
            break;
        case 503: 
            showNotiError('Lỗi tải dữ liệu','Dịch vụ không khả dụng');
            callbackCheck('error');
            break;
        case 504: 
            showNotiError('Lỗi tải dữ liệu','Hết thời gian chờ tải');
            callbackCheck('error');
            break;
        default:
            callbackCheck('ok');
    }
}
//FORM ACTION
function getInputVal(form, name) {
    return $('#'+form+' input[name='+name+']').val();
}
function removeInputError(form) {
    $('#'+form+' .input-container').removeClass('input-error');
}
function setEmptyInputError(input) {
    $(input).closest('.input-container').addClass('input-error'); 
    $(input).closest('.input-container').find('.input-error-content').text("Không bỏ trống mục này"); 
}
function setInputError(form, name, message) {
    $('#'+form+' input[name='+name+']').closest('.input-container').addClass('input-error'); 
    $('#'+form+' input[name='+name+']').closest('.input-container').find('.input-error-content').text(message); 
}
function blockInput(form, action) {
    if(action == 'active') {
        $('#'+form+' .input-container').addClass('disabled');
        $('#'+form+' .collab-button').addClass('disabled');
        $('#'+form+' .collab-checkbox-container').addClass('disabled');
    } else {
        $('#'+form+' .input-container').removeClass('disabled');
        $('#'+form+' .collab-button').removeClass('disabled');
        $('#'+form+' .collab-checkbox-container').removeClass('disabled');
    }
}
//FORM SUBMIT
//Signup form
$(document).on('submit','#signupForm',function(e){
    e.preventDefault();
    fullName = getInputVal('signupForm','fullName');
    userName = getInputVal('signupForm','userName');
    password = getInputVal('signupForm','password');
    confirmPassword = getInputVal('signupForm','confirmPassword');

    formData = new FormData();
    formData.append('fullName', fullName);
    formData.append('userName', userName);
    formData.append('password', password);
    formData.append('confirmPassword', confirmPassword);

    blockInput('signupForm','active');
    removeInputError('signupForm');

    setTimeout(function(){
        fetch("/php/data/accountSignup.php",{
            method: 'POST',
            body: formData
        }).then(res => {
            if(res.ok) {
                return res.json();
            } else {
                return Promise.reject(res.status);
            }
        })
        .then(data => {
            if(!data.success) {
                checkInputError('signupForm',data);
                blockInput('signupForm','disable');
            } else {
                showNotiLoading("Đăng ký thành công","Tài khoản của bạn đã được tạo, đang chuyển hướng đến trang đăng nhập");
                setTimeout(function(){
                    window.open("http://placeholder.collabvn.ga/login","_self")
                },2000);
            }
        }).catch(function(e) {
            checkErrorCode(e);
            blockInput('signupForm','disable');
        });
    },1000)
})

//Login form
$(document).on('submit','#loginForm',function(e){
    getFormType = $('.login-form').attr('id');
    e.preventDefault();
    userName = getInputVal('loginForm','userName');
    password = getInputVal('loginForm','password');
    if(getFormType == 'loginForm') {
        remember = $('#loginForm input[name="remember"]').is(':checked');
    } else {
        remember = true;
    }

    formData = new FormData();
    formData.append('userName', userName);
    formData.append('password', password);
    formData.append('remember', remember);

    blockInput('loginForm','active');
    removeInputError('loginForm');

    setTimeout(function(){
        fetch("/php/data/accountLogin.php",{
            method: 'POST',
            body: formData
        }).then(res => {
            if(res.ok) {
                return res.json();
            } else {
                return Promise.reject(res.status);
            }
        })
        .then(data => {
            if(!data.success) {
                checkInputError('loginForm',data);
                blockInput('loginForm','disable');
            } else {
                showNotiLoading("Đăng nhập thành công","Đang chuyển hướng đến trang bảng tin");
                setTimeout(function(){
                    window.open("http://placeholder.collabvn.ga","_self")
                },2000);
            }
        }).catch(function(e) {
            checkErrorCode(e);
            blockInput('loginForm','disable');
        });
    },1000)
})