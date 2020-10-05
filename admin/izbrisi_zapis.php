<?php
session_start();

 if($_SESSION['id'] != 1)
 {
   header('Location: ../forum.php');
 }

 if(isset($_POST['addform'])){
    $connection = new mysqli("localhost", "user", "pass", "base_name");
     $idZapis = $connection -> real_escape_string($_POST['zapis_id']);
     echo $idZapis;

     $stmt = $connection -> prepare('DELETE FROM komentarji WHERE zapis_id=?');
     $stmt -> bind_param('i', $idZapis);
     $stmt -> execute();

     $stmt = $connection -> prepare('DELETE FROM zapisi WHERE id=?');
     $stmt -> bind_param('i', $idZapis);
     $stmt -> execute();

     header("Location: index.php");
   }
   else
     echo "login form not set";

  //   $stmt = $mysqli -> prepare('DELETE FROM users WHERE id = ?');

//$userId = 4;

//$stmt -> bind_param('i', $userId);
//$stmt -> execute();

// number of deleted rows
//echo $stmt -> affected_rows;

?>
