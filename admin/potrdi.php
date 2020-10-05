<?php
session_start();

 if($_SESSION['id'] != 1)
 {
   header('Location: ../forum.php');
 }

 if(isset($_POST['potrdiform'])){
     $connection = new mysqli("localhost", "user", "pass", "base_name");
     $uporabnik = $connection -> real_escape_string($_POST['uporabnik']);
     //echo $uporabnik;

     $stmt = $connection -> prepare('UPDATE uporabniki SET preverjen = 1 WHERE id=?');
     $stmt -> bind_param('i', $uporabnik);
     $stmt -> execute();

     header("Location: index.php");
   }
   else
     echo "form not set";



?>
