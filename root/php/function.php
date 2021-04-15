<?php
    session_start();

    //Basic
    $title = "Collab";
    $home = "https://collabvn.ga";
    $rootpath = $_SERVER['DOCUMENT_ROOT'];
    $navbar = $rootpath.'/include/navbar.php';

    //Client info
    $userip = $_SERVER['REMOTE_ADDR'];
    $useragent = str_replace('"','',$_SERVER['HTTP_USER_AGENT']);
    $currentTime = time();

    //Database
    $host = "localhost";
    $dbusername = "javademo";
    $dbpass = "demopass";
    $dbname = "delivery";

    @$dbconnect = new mysqli($host, $dbusername, $dbpass, $dbname);
    if ($dbconnect->connect_error) {
        echo "dberror";
    }

    //Load
    function loadNavbar($type) {
        global $navbar, $projectNavbar;
        if($type == 'dashboard') {
            include $navbar;
        } else if ($type == 'project') {
            include $projectNavbar;
        } else {
            echo 'Navbar error';
        }
    }
    
    //Convert UNIX time to Date time
    function convertUnix($unixtime) {
        $datetime = new DateTime("@$unixtime");
        $datetime_format = $datetime->format('Y-m-d H:i:s');
        $timezone_from = "UTC";
        $timezone_to = "Asia/Bangkok";
        $display_date = new DateTime($datetime_format, new DateTimeZone($timezone_from));
        $display_date->setTimeZone(new DateTimeZone($timezone_to));
        return $display_date->format('d/m/Y - H:i:s');
    }
    function convertUnixNoSec($unixtime) {
        $datetime = new DateTime("@$unixtime");
        $datetime_format = $datetime->format('Y-m-d H:i');
        $timezone_from = "UTC";
        $timezone_to = "Asia/Bangkok";
        $display_date = new DateTime($datetime_format, new DateTimeZone($timezone_from));
        $display_date->setTimeZone(new DateTimeZone($timezone_to));
        return $display_date->format('d/m/Y, H:i');
    }
    function convertUnixDate($unixtime) {
        $datetime = new DateTime("@$unixtime");
        $datetime_format = $datetime->format('Y-m-d H:i');
        $timezone_from = "UTC";
        $timezone_to = "Asia/Bangkok";
        $display_date = new DateTime($datetime_format, new DateTimeZone($timezone_from));
        $display_date->setTimeZone(new DateTimeZone($timezone_to));
        return $display_date->format('d/m/Y');
    }
    function convertUnixTime($unixtime) {
        $datetime = new DateTime("@$unixtime");
        $datetime_format = $datetime->format('Y-m-d H:i');
        $timezone_from = "UTC";
        $timezone_to = "Asia/Bangkok";
        $display_date = new DateTime($datetime_format, new DateTimeZone($timezone_from));
        $display_date->setTimeZone(new DateTimeZone($timezone_to));
        return $display_date->format('H:i');
    }
    //Random string
    function randomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    //Get userID from session
    function getUserID() {
        if(@$_COOKIE['cookieToken']) {
            $sesToken = $_COOKIE['cookieToken'];
        } else {
            $sesToken = @$_SESSION['sessionToken'];
        }
        $checkSesResult = runDbReturn("SELECT userID FROM userSessions WHERE sessionID = ?","s",array($sesToken),'return');
        $rowCheckSes = $checkSesResult->fetch_assoc();
        return $rowCheckSes['userID'];
    }

    //SQL Query and return result
    function runDbReturn($queryCode,$type,$arrays,$return) {
        global $dbconnect;
        $query = $dbconnect->prepare($queryCode);
        $query->bind_param($type,...$arrays);
        if($query->execute()) {
            $result = $query->get_result();
            if($return == 'affected') {
                return $query->affected_rows;
            } else if ($return == 'return') {
                return $result;
            } else if ($return == 'numRows') {
                return $query->num_rows;
            }
        } else {
            return $dbconnect->error;
        }
        $dbconnect->close();
    }

    //Create session token
    function createSessionToken() {
        global $dbconnect;
        $i = 0;
        while ($i == 0) {
            $sesToken = 'ses'.randomString(97);
            $sesTokenQuery = $dbconnect->prepare("SELECT sessionID FROM userSessions WHERE sessionID = ?");
            $sesTokenQuery->bind_param("s",$sesToken);
            $sesTokenQuery->execute();
            $sesTokenResult = $sesTokenQuery->get_result();
            if($sesTokenResult->num_rows == 0) {
                $i == 1;
                return $sesToken;
            }
        }
    }
    //Create user ID
    function createUserID() {
        global $dbconnect;
        $i = 0;
        while ($i == 0) {
            $userID = 'user'.randomString(6);
            $userIDResult = runDbReturn("SELECT userID FROM user WHERE userID = ?","s",array($userID),'numRows');
            if($userIDResult == 0) {
                $i == 1;
                return $userID;
            }
        }
    }
    //XSS prevent
    function filterhtml($text) {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }

    //Compress image
    function compressImage($source, $destination, $quality) { 
        // Get image info 
        $imgInfo = getimagesize($source); 
        $mime = $imgInfo['mime']; 
        
        // Create a new image from file 
        switch($mime){ 
            case 'image/jpeg': 
                $image = imagecreatefromjpeg($source); 
                break; 
            case 'image/png': 
                $image = imagecreatefrompng($source); 
                break;
            default: 
                $image = imagecreatefromjpeg($source); 
        } 
        
        // Save image 
        imagejpeg($image, $destination, $quality); 
        
        // Return compressed image 
        return $destination; 
    }

    //Encode content
    function encodeFetch($content) {
        return base64_encode(json_encode($content));
    }

    //Decode content
    function decodeFetch($content) {
        return json_decode(base64_decode($content), true);
    }
?>