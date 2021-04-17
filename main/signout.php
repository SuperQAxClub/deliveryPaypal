<?php
    setcookie("cookieToken","",0,"/","collabvn.ga");
    session_destroy();
    header("Location: http://placeholder.collabvn.ga/login")
?>