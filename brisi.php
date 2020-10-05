<?php

session_start();

 if($_SESSION['id'] != 1)
 {
   header('Location: ../forum.php');
 }

$id=$_GET['id'];
$connection = new mysqli("localhost", "user", "pass", "base_name");
 //$query = "SELECT id, naslov FROM zapisi";

 $stmt = $connection -> prepare('DELETE FROM komentarji WHERE zapis_id=?');
 $stmt -> bind_param('i', $id);
 $stmt -> execute();

 $stmt = $connection -> prepare('DELETE FROM zapisi WHERE id=?');
 $stmt -> bind_param('i', $id);
 $stmt -> execute();

header ("location: forum.php");








 ?>
