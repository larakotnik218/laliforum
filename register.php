<?php
  session_start();
  if(isset($_SESSION['id']))
   header('Location: forum.php');
  else
   header("Location: index.php");


  if(isset($_POST['regform'])){
    $connection = new mysqli("localhost", "user", "pass", "base_name");
    function insertUser($username, $email, $password, $target_file){
      global $stmt;
      global $connection;
      if(
          $stmt &&
          $stmt -> bind_param('ssss', $username, $email, $password, $target_file) &&
          $stmt -> execute()
        ){
          if (move_uploaded_file($_FILES["slika"]["tmp_name"], $target_file)) {
              echo "The file ". basename( $_FILES["slika"]["name"]). " has been uploaded.";
              $_SESSION['id'] = $connection->insert_id;
              echo "uporabnik dodan s sliko";
              echo $_SESSION['id'] = $connection->insert_id;
              header('Location: forum.php');


          }else{
            echo "uporabnik nima slike, dodan vseeno";
            $_SESSION['id'] = $connection->insert_id;
            header('Location: forum.php');
          }
        }else{
          echo "Prepared statement failed";
        }
    }

    $stmt = $connection -> prepare('INSERT INTO uporabniki (uporabnisko_ime, email, geslo, slika) VALUES (?, ?, ?, ?)');

    $username = $connection -> real_escape_string($_POST['user']);
    $email = $connection -> real_escape_string($_POST['email']);
    $password  = $connection -> real_escape_string($_POST['pass']);
    $hash = hash("sha256", $password);

    //slika
    $target_dir = "uploads/";
    $file = $_FILES['slika']['name'];
    $ifdefualt = 0;
    if ($file == ""){
      $file = "avatar-default.svg";
      $ifdefualt = 1;
    }
    $target_file = $target_dir . basename($file);

    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// preverite ali je datoteka v resnici slika ali je ponarejena slika

    $check = getimagesize($target_file);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    if ($_FILES["slika"]["size"] > 5000000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }
    // preverite tipe datotek
    if($imageFileType !="jpg"
          && $imageFileType !="png"
          && $imageFileType !="jpeg"
          && $imageFileType !="PNG"
          && $imageFileType !="JPG"
          && $imageFileType !="JPEG"
          && $imageFileType !="svg"
          && $imageFileType !="SVG") {
        echo "Sorry, only JPG, JPEG, PNG files are allowed.";
        $uploadOk = 0;
      }
// preverite, če je $uploadOk postavljena na 0 (zaradi napake)
  if ($uploadOk == 0 && $ifdefualt=0)
      echo "Sorry, your file was not uploaded.";
  else if($ifdefualt == 1)
    insertUser($username, $email, $hash, $target_file);
  else
    insertUser($username, $email, $hash, $target_file);

  }
  else
    echo "Registration form not set";
?>
