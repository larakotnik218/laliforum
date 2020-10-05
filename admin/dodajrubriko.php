<?php
session_start();

 if($_SESSION['id'] != 1)
 {
   header('Location: ../forum.php');
 }

  if(isset($_POST['addform'])){
    $connection = new mysqli("localhost", "user", "pass", "base_name");

    function insertRubrika($ime, $opis){
      global $stmt;
      if(
          $stmt &&
          $stmt -> bind_param('ss', $ime, $opis) &&
          $stmt -> execute()
        ){
          header('Location: index.php');
        }else{
          echo "Prepared statement failed";
        }
    }

    $stmt = $connection -> prepare('INSERT INTO rubrike (ime, opis) VALUES (?, ?)');

    $ime = $connection -> real_escape_string($_POST['ime']);
    $opis = $connection -> real_escape_string($_POST['opis']);



    insertRubrika($ime, $opis);
  }else{
    echo "Registration form not set";
  }
?>
