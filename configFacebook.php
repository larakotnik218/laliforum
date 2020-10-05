<?php
    require_once('facebook-api/src/Facebook/autoload.php');
    //require_once('controllerFacebook.php');
    session_start();
	if(isset($_SESSION['id']))
		header('Location: forum.php');

	$facebook = new \Facebook\Facebook([
        'app_id'      => ' ',
        'app_secret'     => ' ',
        'default_graph_version'  => 'v8.0'
    ]);
    $facebook_helper = $facebook->getRedirectLoginHelper();
    $facebook_permissions = ['email']; // Optional permissions
    $facebook_login_url = $facebook_helper->getLoginUrl('https://forium.iamlali.com/controllerFacebook.php', $facebook_permissions);








?>
