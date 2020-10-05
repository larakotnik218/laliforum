<?php
    require_once "google-api/vendor/autoload.php";
    $gClient = new Google_Client();
    $gClient->setClientId(" ");
    $gClient->setClientSecret(" ");
    $gClient->setApplicationName(" ");
    $gClient->setRedirectUri("https://forium.iamlali.com/controllerGoogle.php");
    $gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");

    $google_login = $gClient->createAuthUrl();
?>
