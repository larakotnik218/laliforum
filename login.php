<?php
  session_start();
  $googlename = $_POST['googlename'];
  $googleemail = $_POST['googleemail'];
  $googleimage = $_POST['googleimage'];


  if(isset($googlename))
  {
      $connection = new mysqli("localhost", "user", "pass", "base_name");
      $stmt = $connection -> prepare('SELECT * FROM uporabniki WHERE email=?');
     // $stmt -> bind_param('s', $googleemail) &&
       // $stmt -> execute();

         if(
        $stmt &&
        $stmt -> bind_param('s', $googleemail) &&
        $stmt -> execute()
      ){
        while ($user = $stmt -> fetch()){
         //$user= $stmt -> fetch();
            $_SESSION['id'] = $user['id'];
            echo $_SESSION['id'];
        }
        echo "napacn login";
      }


    //   if($stmt -> rowCount()== 1)
    //   {
    //         $user= $stmt -> fetch();
    //         $_SESSION['id'] = $user['id'];
    //         echo $_SESSION['id'];
    //     //   header('Location: forum.php');

    //   }

        else{
    $connection = new mysqli("localhost", "user", "pass", "base_name");
      $stmt = $connection -> prepare('INSERT INTO uporabniki (uporabnisko_ime,email,slika)VALUES (?,?,?)');
        $stmt -> bind_param('sss', $googlename,$googleemail,$googleimage) &&
        $stmt -> execute();

      $stmt2 = $connection -> prepare('SELECT * FROM uporabniki WHERE email=?');
    //   $stmt2 -> bind_param('s', $googleemail) &&
    //   $stmt2 -> execute();


       if(
        $stmt &&
        $stmt -> bind_param('s', $googleemail) &&
        $stmt -> execute()
      ){
        while ($user = $stmt -> fetch()){
         //$user= $stmt -> fetch();
            $_SESSION['id'] = $user['id'];
            echo $_SESSION['id'];
        }
        echo "error pri elsu";
      }

    //   $user1 = $stmt2->fetch();

    //   if(isset($user1['id']))
    //   {
    //      $_SESSION['id'] = $user1['id'];
    //      header("Location: forum.php");

    //   }
  }



  }

  if(isset($_SESSION['id']))
    header('Refresh:5 url=forum.php');
  else
    header("Refresh:5 url=index.php");

  if(isset($_POST['logform'])){
      $connection = new mysqli("localhost", "user", "pass", "base_name");
      $stmt = $connection -> prepare('SELECT id FROM uporabniki WHERE uporabnisko_ime=? and geslo=?');

      $username = $connection -> real_escape_string($_POST['user']);
      $password = $connection -> real_escape_string($_POST['pass']);
      $hash = hash('sha256', $password);

      if(
        $stmt &&
        $stmt -> bind_param('ss', $username, $hash) &&
        $stmt -> execute() &&
        $stmt -> store_result() &&
        $stmt -> bind_result($id)
      ){
        while ($stmt -> fetch()){
          $_SESSION['id'] = $id;
          header('Location: forum.php');
        }
        echo "napacn login";
      }
      else echo "error";
    }
    else
      echo "login form not set";

?>
