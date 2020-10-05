<?php
  session_start();
  if(!isset($_SESSION['id']))
    header("Location: index.php");

  if(isset($_POST['commentform'])){
   $connection = new mysqli("localhost", "user", "pass", "base_name");

    function insertComment($vsebina, $zapis_id, $uporabnik_id){
      global $stmt;
      if(
          $stmt &&
          $stmt -> bind_param('sdd', $vsebina, $zapis_id, $uporabnik_id) &&
          $stmt -> execute()
        ){
          header("Location: zapis.php?zapis_id={$zapis_id}");
        }else{
          echo "Prepared statement failed";
        }
    }


    $stmt = $connection -> prepare('INSERT INTO komentarji (vsebina, zapis_id, uporabnik_id) VALUES (?, ?, ?)');
    $vsebina = $connection -> real_escape_string($_POST['komentar']);
    $zapis_id  = $connection -> real_escape_string($_POST['zapis_id']);
    $uporabnik_id  = $_SESSION['id'];

    echo $vsebina;
    echo $zapis_id;
    echo $uporabnik_id;
    insertComment($vsebina, $zapis_id, $uporabnik_id);
  }else{
    echo "form not set";
  }
?>
