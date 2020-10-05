<?php
  session_start();
  if(isset($_SESSION['id']))
    $id = $_SESSION['id'];
  else
    header("Location: index.php");

$connection = new mysqli("localhost", "user", "pass", "base_name");
  $zapis_id = $_GET['zapis_id'];

  $query = "SELECT z.id,z.naslov, r.ime, u.uporabnisko_ime, z.datum, z.opis FROM uporabniki u INNER JOIN zapisi z ON u.id=z.uporabnik_id INNER JOIN rubrike r ON r.id=z.rubrika_id WHERE z.id={$zapis_id}";
  $result = $connection -> query($query);
  $page_data = [];
  if($result -> num_rows > 0)
    while($row = $result -> fetch_assoc()){
      $page_data = $row;
    }

?>
<!DOCTYPE html>
<html class="forum">
    <head>
    <title></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="img/icon.ico" type="image/gif" sizes="64x64">
        <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>

        <!-- UIKit -->
        <link rel="stylesheet" href="css/uikit.min.css" />
        <script src="js/uikit.min.js"></script>
        <script src="js/uikit-icons.min.js"></script>

				<link rel="stylesheet" href="style2.css">
    </head>
    <body>

        <div class="uk-container uk-container-center uk-margin-top">
            <div class="uk-panel uk-panel-box uk-text-center">
                <!-- title -->
                <h1 class="uk-heading-divider uk-heading-large lobby-text">Forium</h1>
                <br>
                 <div class="zapis">
                <article class="uk-article">
                  <h1 class="uk-article-title"><?php echo $page_data['naslov']; ?></h1>
                  <p class="uk-article-meta" style="color:white;"><?php echo "Napisal uporabnik <strong>{$page_data['uporabnisko_ime']}</strong> dne<strong> {$page_data['datum']}</strong>"?></p>
                  <div class="uk-article-lead"><?php echo str_ireplace(array("\r","\n",'\r','\n'),'',$page_data['opis']);?></div>
                  <hr class="uk-article-divider">
                </article>
              </div>

                <br>
                <!-- KOMENTARJI -->
                <?php
                  $connection = new mysqli("localhost", "user", "pass", "base_name");
                  $query = "SELECT k.vsebina, k.datum, k.zapis_id, k.uporabnik_id, u.id, z.id, u.uporabnisko_ime, u.slika, u.preverjen FROM komentarji k, uporabniki u, zapisi z WHERE k.zapis_id=z.id AND k.uporabnik_id=u.id AND k.zapis_id={$zapis_id}";
                  $result = $connection -> query($query);
                    while($row = $result -> fetch_assoc()){
                      if($result -> num_rows > 0){
                        echo "<article class='uk-comment' style='background-color:white; margin-left:150px; margin-right:150px;'>";
                        echo "<header class='uk-comment-header'>";
                        echo "<br>";
                        echo "<img class='uk-comment-avatar' style='width:80px; height:80px; border-radius:50%;' src='{$row['slika']}' alt=''>";
                        echo "<h4 class='uk-comment-title'>{$row['uporabnisko_ime']}</h4>";
                        if($row['preverjen'] == 1)
                        {
                          echo "<p> <em>Preverjen uporabnik foruma </em> </p>";
                        }
                        echo "<div class='uk-comment-meta' style='color:black;'>{$row['datum']}</div>";
                        echo "</header>";
                        echo "<div class='uk-comment-body'>{$row['vsebina']}</div> <br>";
                        echo "</article>";
                        // echo "<hr class='uk-article-divider'>";
                        echo "<br>";
                      }
                    }
                  $connection -> close();
                 ?>
              <br>

								<a class="uk-button uk-button-default uk-button-large" href='#modal-comment' uk-toggle>Dodaj komentar</a><br>
                <?php
                $connection = new mysqli("localhost", "user", "pass", "base_name");
                  $query = "SELECT uporabnisko_ime FROM uporabniki WHERE id=$id";
                  $result = $connection -> query($query);
                  if($result -> num_rows > 0)
                    while($row = $result -> fetch_assoc()){
                      echo "Prijavljen kot <strong>{$row['uporabnisko_ime']}</strong>";
                    }
                  $connection -> close();
                ?>
                <br>
                <a href="logout.php" style="color:white;">ODJAVA</a>


            </div>
        </div>




        <div id="modal-comment" uk-modal>
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header" style='background-color: #87CEFA;'>
                <h2 class="uk-modal-title lobby-text">Dodaj komentar</h2>
            </div>
            <div class="uk-modal-body uk-text-center">
                <form action='dodaj_komentar.php' method="post">
                    <div class="uk-margin">
                        <div class="uk-inline">
                            <textarea class="uk-input" type="text" name="komentar" placeholder="Napiši komentar"></textarea>
                            <input hidden class="uk-input" type="text" name="zapis_id" placeholder="zapis_id" value="<?php echo $zapis_id;?>" >
                        </div>
                    </div>
                    <div class="uk-modal-footer uk-text-center">
                        <button class="uk-button lobby-button" type="submit" id="commentform" name="commentform">Komentiraj</button><br><br>
                </form>
                    </div>
            </div>
            </div>
        </div>

    </body>
</html>
