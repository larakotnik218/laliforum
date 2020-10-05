<?php
  session_start();
  if(isset($_SESSION['id']))
    $id = $_SESSION['id'];
  else
    header("Location: index.php");


?>
<!DOCTYPE html>
<html>
    <head>
    <title></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="img/icon.ico" type="image/gif" sizes="64x64">
        <!-- <script src="https://cdn.ckeditor.com/4.15.0/sta/ckeditor.js"></script> -->
        <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>

        <!-- UIKit -->
        <link rel="stylesheet" href="css/uikit.min.css" />
        <script src="js/uikit.min.js"></script>
        <script src="js/uikit-icons.min.js"></script>

        <link rel="stylesheet" href="style.css">


    </head>
    <body>

        <div class="uk-container uk-container-center uk-margin-top">
            <div class="uk-panel uk-panel-box uk-text-center">
                <!-- title -->
                <h1 class="uk-heading-divider uk-heading-large lobby-text">Forium</h1>
                <br>
								<!-- <a class="uk-button uk-button-default uk-button-large" href='#modal-insert' uk-toggle>Dodaj zapis</a><br> <br> -->
                <!-- <a class="uk-button uk-button-default uk-button-large" href='#modal-spremeni' uk-toggle> Spremeni profil</a><br> -->
                <?php
                 $connection = new mysqli("localhost", "user", "pass", "base_name");
                  $query = "SELECT uporabnisko_ime, email, geslo,slika FROM uporabniki WHERE id=$id";
                  $result = $connection -> query($query);
                  if($result -> num_rows > 0)
                    while($row = $result -> fetch_assoc()){
                        echo "<br>";
                        if(empty($row['geslo']))
                        {
                            echo "<img src='{$row['slika']}' class='uk-border-rounded ' style='width:80px; height:80px; border-radius:50%;'</img>";
                            echo "<br>";
                            echo "<a class='prijava' style='color: black;'>  {$row['uporabnisko_ime']} </a>";
                        }
                        else
                        {
                            echo "<img uk-toggle='target: #modal-slika' type='button' src='{$row['slika']}' class='uk-border-rounded ' style='width:80px; height:80px; border-radius:50%;'</img>";
                            echo "<br>";
                            echo "<a class='prijava' href='#modal-spremeni' uk-toggle style='color: black;'>  {$row['uporabnisko_ime']} </a>";
                        }
                    }
                  $connection -> close();
                ?>

                <br>
                <a href="logout.php" style="color: white;"> <button>ODJAVA </button></a>


             </div>
        </div>
        <br><br><br>


        <!-- search bar -->
        <div class="uk-container uk-container-center uk-margin-top">
            <div class="uk-panel uk-panel-box uk-text-center">
                <nav class="uk-navbar-container" uk-navbar style="border-radius:5px; height:50px;">
                    <div class="uk-navbar-left">
                        <div class="uk-navbar-item" style="min-height:0px;">
                            <form class="uk-search uk-search-navbar">
                                <span uk-search-icon></span>
                                <input onkeyup="searchFunction()" id='searchBar' class="uk-search-input" type="search" placeholder="poišči temo...">
                            </form>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <script>
function searchFunction() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("searchBar");
  filter = input.value.toUpperCase();
  table = document.getElementById("zapisiTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>

        <!-- dodaj zapis -->
        <div class="uk-container uk-container-center uk-margin-top">
            <div class="uk-panel uk-panel-box uk-text-center">
                <a class="uk-button uk-button-default uk-button-large" href='#modal-insert' uk-toggle>Dodaj zapis</a><br>
            </div>
        </div>


        <div class="uk-container uk-container-center uk-margin-top">
            <div class="uk-panel uk-panel-box uk-text-center">
              <table id='zapisiTable' class="uk-table uk-table-hover uk-table-divider">
                <thead>
                  <tr style="text-transform: uppercase;">
                    <td>Naslov</td>
                    <td>Tema</td>
                    <td>Uporabnik</td>
                    <td>Datum</td>
                    <?php if($_SESSION['id'] == 1)
                    {
                      echo "<td>Brisi</td>";
                    }
                    ?>
                  </tr>
                </thead>
                <tfoot>

                  <?php
                    $connection = new mysqli("localhost", "user", "pass", "base_name");
                    $query = "SELECT  z.id,z.naslov, r.ime, u.uporabnisko_ime, z.datum FROM uporabniki u INNER JOIN zapisi z ON u.id=z.uporabnik_id INNER JOIN rubrike r ON r.id=z.rubrika_id ORDER BY z.datum DESC";
                    $result = $connection -> query($query);


                    if($result -> num_rows > 0)

                      while($row = $result -> fetch_assoc()){

                        echo "<tr>";
                        echo "<td> <a class='prijava' href='zapis.php?zapis_id={$row['id']}'>{$row['naslov']}</a></td>";
                        echo "<td>{$row['ime']}</td>";
                        echo "<td>{$row['uporabnisko_ime']}</td>";
                        echo "<td>{$row['datum']}</td>";
                        if($_SESSION['id'] == 1)
                        {
                          ?>
                          <td><a href="brisi.php?id=<?php echo $row['id'];?>" style="color: black;"> <button> izbriši </button></a></td>
                           <?php
                        }
                        echo "</tr>";
                      }
                      $connection -> close();
                ?>
                </tfoot>
              </table>
            </div>
        </div>

        <div id="modal-insert" uk-modal class='uk-modal-container'>
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header" style='background-color: #87CEFA;'>
                <h2 class="uk-modal-title lobby-text">Dodaj zapis</h2>
            </div>
            <div class="uk-modal-body uk-text-center">
                <form action='dodaj.php' method="post">
                    <div class="uk-margin">
                        <div class="uk-inline">
                            <input class="uk-input" type="text" name="naslov" placeholder="Naslov" required>
                        </div>
                    </div>
                    <div class="uk-margin">
                        <div class="uk-inline">
                            <textarea cols='30' class="uk-textarea" name="opis"></textarea>
                        </div>
                    </div>
                    <div class="uk-form-select" data-uk-form-select>
                        <span></span>
                        <select name="rubrika_id">
                          <?php
                            $connection = new mysqli("localhost", "user", "pass", "base_name");
                            $query = "SELECT id, ime FROM rubrike";
                            $result = $connection -> query($query);
                            if($result -> num_rows > 0)
                              while($row = $result -> fetch_assoc()){
                                echo '<option value='.$row['id'].'>'.$row['ime'].'</option>';
                              }
                            $connection -> close();
                          ?>
                        </select>
                    </div>

                    <div class="uk-modal-footer uk-text-center">
                        <button class="uk-button lobby-button" type="submit" id="addform" name="addform">Objavi</button><br><br>
                </form>
                <script type="text/javascript">
                    CKEDITOR.replace('opis');
                </script>
                    </div>
            </div>
            </div>
        </div>


        <div id="modal-slika" uk-modal>
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header" style='background-color: #87CEFA;'>
                <h2 class="uk-modal-title lobby-text">Spremeni sliko</h2>
            </div>
            <div class="uk-modal-body uk-text-center">
                <form enctype="multipart/form-data" action='spremeni_sliko.php' method="post">

                  <div class="uk-margin">
                      <div class="uk-inline">
                        <div class="js-upload" uk-form-custom>
                            <input type="file" name="slika" />
                            <button  class="uk-button uk-button-default" type="button" tabindex="-1">Izberi sliko</button>
                        </div>
                      </div>
                  <div class="uk-modal-footer uk-text-center">
                      <button class="uk-button lobby-button" type="submit" name="slikaform">Spremeni sliko</button>
              </form>
                  </div>
            </div>
            </div>
        </div>

        <!-- spremeni profil -->
        <div id="modal-spremeni" uk-modal>
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header" style='background-color: #87CEFA;'>
                <h2 class="uk-modal-title lobby-text">Moj profil</h2>
            </div>
            <div class="uk-modal-body uk-text-center">
                <form enctype="multipart/form-data" action='spremeni_profil.php' method="post">
                  <?php
                    $connection = new mysqli("localhost", "user", "pass", "base_name");
                    $query = "SELECT uporabnisko_ime, email, geslo,slika FROM uporabniki WHERE id=$id";
                    $result = $connection -> query($query);
                    if($result -> num_rows > 0)
                      while($row = $result -> fetch_assoc()){
                        echo "<img src='{$row['slika']}' alt='profilna slika'  style='width:80px; height:80px; border-radius:50%;'>";
                        echo "<br>";
                        echo "  <div class='uk-margin'>
                                    <div class='uk-inline'>
                                        <span class='uk-form-icon' uk-icon='icon: user'></span>
                                        <input class='uk-input' type='text' name='uporabnisko_ime' value='{$row['uporabnisko_ime']}'>
                                    </div>
                                </div>

                                <div class='uk-margin'>
                                    <div class='uk-inline'>
                                    <span class='uk-form-icon' uk-icon='icon: mail'></span>
                                        <input class='uk-input' type='email' name='email' value='{$row['email']}'>
                                    </div>
                                </div>
                                <div class='uk-margin'>
                                      <div class='uk-inline'>
                                          <span class='uk-form-icon' uk-icon='icon: lock'></span>
                                          <input class='uk-input' type='password' name='pass' placeholder='novo/isto geslo' required>
                                      </div>
                                </div>
                            ";
                      }
                    $connection -> close();
                  ?>

                    <div class="uk-modal-footer uk-text-center">
                        <button class="uk-button lobby-button" type="submit" id="changeform" name="changeform">Spremeni</button><br><br>
                </form>
                    </div>
            </div>
            </div>
        </div>
    </body>
</html>
