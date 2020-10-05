<?php
  session_start();
  if(!isset($_SESSION['id']))
    header("Location: index.php");

  if(isset($_POST['addform'])){
    $connection = new mysqli("localhost", "user", "pass", "base_name");

    function insertZapis($naslov, $opis, $rubrika_id, $uporabnik_id){
      global $stmt;
      if(
          $stmt &&
          $stmt -> bind_param('ssdd', $naslov, $opis, $rubrika_id, $uporabnik_id) &&
          $stmt -> execute()
        ){
          header('Location: forum.php');
        }else{
          echo "Prepared statement failed";
        }
    }

    $stmt = $connection -> prepare('INSERT INTO zapisi (naslov, opis, rubrika_id, uporabnik_id) VALUES (?, ?, ?, ?)');

    $naslov = $connection -> real_escape_string($_POST['naslov']);
    $opis = $connection -> real_escape_string($_POST['opis']);
    // $opis = str_ireplace(array("\r","\n",'\r','\n',$opis));
    $rubrika_id  = $connection -> real_escape_string($_POST['rubrika_id']);
    $uporabnik_id  = $_SESSION['id'];

    insertZapis($naslov, $opis, $rubrika_id, $uporabnik_id);
  }else{
    echo "Registration form not set";
  }
?>
