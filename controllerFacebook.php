<?php
    require_once("configFacebook.php");

    $facebook_helper = $facebook->getRedirectLoginHelper();

    if(isset($_GET['code'])){
        $token = $facebook_helper->getAccessToken();
        $facebook->setDefaultAccessToken($token);

        $graph_response = $facebook->get("/me?fields=name,email", $access_token);
        $facebook_user_info = $graph_response->getGraphUser();

        $picture = 'http://graph.facebook.com/'.$facebook_user_info['id'].'/picture';
        $username = $facebook_user_info['name'];
        $email = $facebook_user_info['email'];


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
                echo $username;
                echo "<br>";
                echo $email;
                echo "<br>";
                echo $picture;
                echo "<br>";

            }
        }else echo "Prepare statement failed";

    }



?>
