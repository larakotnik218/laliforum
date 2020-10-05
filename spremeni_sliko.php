<?php
  session_start();
 if(isset($_SESSION['id']))
  header('Location: forum.php');
  else
  header("Location: index.php");

  if(isset($_POST['slikaform'])){
  $connection = new mysqli("localhost", "user", "pass", "base_name");

      function update_slika($target_file){
        global $stmt;
        if( $stmt &&
            $stmt -> bind_param('s', $target_file) &&
            $stmt -> execute()
          )
          if (move_uploaded_file($_FILES["slika"]["tmp_name"], $target_file)) {
              echo "The file ". basename( $_FILES["slika"]["name"]). " has been uploaded.";
              header('Location: forum.php');
          }else
            echo "Sorry, there was an error uploading your file.";
          header('Location: forum.php');
        }



    $id = $_SESSION['id'];
    $stmt = $connection -> prepare('UPDATE uporabniki SET slika=? WHERE id='.$id);
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
    update_slika($target_file);
  else
    update_slika( $target_file);

  }
  else
    echo "form not set";
?>
