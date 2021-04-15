<!DOCTYPE html>
<html> 
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no, viewport-fit=cover">
        <meta name="description" content="">
        <meta name="author" content="Collab Team">

        <link href="/root/collab.css?<?php echo(rand(0,9999999)); ?>" type="text/css" rel="stylesheet" />
        <script type="module" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule="" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

        <script src="/root/jquery.min.js"></script>

    </head>
    <body ontouchstart="">
      <div class="collab-alert">
          <div class="modal-loading">
            <div class="collab-spinner active"></div>
          </div>
          <div class="modal-content"></div>
      </div>
      <div class="collab-modal">
          <div class="modal-loading">
            <div class="collab-spinner active"></div>
          </div>
          <div class="modal-content"></div>
      </div>
      <div class="collab-modal-overlay"></div>
      <div class="collab-alert-overlay"></div>
      <div class="collab-noti"></div>

        <?php
        include ($_SERVER['DOCUMENT_ROOT'].'/php/function.php');
        $uri = $_SERVER['REQUEST_URI']; ?>

      <div class="ajax-all-page">

        <?php //echo '<script>alert("aaaaaaaa")</script>';
        if (file_exists( __DIR__ . '/main' . $uri . '.php' )) {
            require_once __DIR__ . '/main' . $uri . '.php';
        } else if($uri == "/") {
            if (file_exists( __DIR__ . '/main/dashboard.php' )) {
                require_once __DIR__ . '/main/dashboard.php';
            }
        } else { ?>
            <script>alert('404');</script>
        <?php }
        ?>
      </div>
      <script src="/root/collab.js?<?php echo(rand(0,99999999));?>"></script>

    </body>
</html>