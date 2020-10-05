<?php

  session_start();
  if(!isset($_SESSION['id']))
    header("Location: index.php");


      if(isset($_POST['changeform'])){
        $connection = new mysqli("localhost", "user", "pass", "base_name");

        function updateUporabnisko($ui, $email, $hash){
          global $stmt;
          if( $stmt &&
              $stmt -> bind_param('sss', $ui, $email, $hash) &&
              $stmt -> execute()
            )
              header('Location: forum.php');
          else
              echo "prepare statement failed";
        }


        $ui= $connection -> real_escape_string($_POST['uporabnisko_ime']);
        $email= $connection -> real_escape_string($_POST['email']);
        $pass= $connection -> real_escape_string($_POST['pass']);
        $hash = hash("sha256", $pass);

        $id  = $_SESSION['id'];
        $stmt = $connection -> prepare("UPDATE uporabniki SET uporabnisko_ime=?, email=?, geslo = ? WHERE id=$id");

        updateUporabnisko($ui, $email, $hash);
      }else{
        echo " form not set";
      }
    ?>
