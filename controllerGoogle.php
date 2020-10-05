<?php
    require_once("configGoogle.php");
    session_start();
    if(isset($_SESSION['id']))
        header('Location: forum.php');

    if(isset($_GET['code']))
        $token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
    else
        header('Location: index.php');

    $oAuth = new Google_Service_Oauth2($gClient);
    $userData = $oAuth->userinfo_v2_me->get();

    $username = $userData['givenName'];
    $email = $userData['email'];
    $picture = $userData['picture'];

    function insertUser($username, $email, $picture){
        global $connection;
        $stmt = $connection->prepare("INSERT INTO uporabniki (uporabnisko_ime, email, slika) VALUES (?, ?, ?)");
        if  (
                $stmt &&
                $stmt -> bind_param("sss", $username, $email, $picture) &&
                $stmt -> execute()
            ){
                $_SESSION['id'] = $connection->insert_id;
                header('Location: forum.php');
            }
    }

   $connection = new mysqli("localhost", "user", "pass", "base_name");
    $stmt = $connection->prepare('SELECT id FROM uporabniki WHERE uporabnisko_ime=? and email=?');
    if (
            $stmt &&
            $stmt -> bind_param('ss', $username, $email) &&
            $stmt -> execute() &&
            $stmt -> store_result() &&
            $stmt -> bind_result($id)
        ) {
            if($stmt->fetch()){
                $_SESSION['id'] = $id;
                header('Location: forum.php');
            }
            else{
                echo "Uporabnik se ne obstaja";
                insertUser($username, $email, $picture);
            }
            echo "lol";
        }else echo "Prepare statement failed";
?>
