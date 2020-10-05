<?php
	 session_start();

    if($_SESSION['id'] != 1)
    {
      header('Location: ../forum.php');
    }
?>

<!DOCTYPE html>
<html>
    <head>
    <title></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../img/icon.ico" type="image/gif" sizes="64x64">
        <!-- UIKit -->
        <link rel="stylesheet" href="../css/uikit.min.css" />
        <script src="../js/uikit.min.js"></script>
        <script src="../js/uikit-icons.min.js"></script>
          <link rel="stylesheet" href="../style.css"/>


    </head>
    <body>

        <div class="uk-container uk-container-center uk-margin-top">
            <div class="uk-panel uk-panel-box uk-text-center">
                <!-- title -->
                <h1 class="uk-heading-divider uk-heading-large lobby-text">Forium</h1>
                <br>
								<a class="uk-button uk-button-default uk-button-large" href='#modal-insert' uk-toggle>Dodaj rubriko</a><br> <br>
                <a class="uk-button uk-button-default uk-button-large" href='#modal-brisi' uk-toggle>Izbriši zapis</a><br><br>
								  <a class="uk-button uk-button-default uk-button-large" href='#modal-potrdi' uk-toggle>Potrdi uporabnika</a><br>


            </div>
        </div>




        <div id="modal-insert" uk-modal>
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header" style='background-color: #87CEFA;'>
                <h2 class="uk-modal-title lobby-text">Dodaj rubriko</h2>
            </div>
            <div class="uk-modal-body uk-text-center">
                <form action='dodajrubriko.php' method="post">
                    <div class="uk-margin">
                        <div class="uk-inline">
                            <input class="uk-input" type="text" name="ime" placeholder="Ime" required>
                        </div>
                    </div>
                    <div class="uk-margin">
                        <div class="uk-inline">
                            <textarea class="uk-input" type="text" name="opis" placeholder="opis"></textarea>
                        </div>
                    </div>
                    <div class="uk-form-select" data-uk-form-select>
                        <span></span>

                    </div>

                    <div class="uk-modal-footer uk-text-center">
                        <button class="uk-button lobby-button" type="submit" id="addform" name="addform">Dodaj</button><br><br>
                </form>
                    </div>
            </div>
            </div>
        </div>


        <div id="modal-brisi" uk-modal>
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header" style='background-color: #87CEFA;'>
                <h2 class="uk-modal-title lobby-text">izbriši zapis</h2>
            </div>
            <div class="uk-modal-body uk-text-center">
                <form action='izbrisi_zapis.php' method="post">

                  <div class="uk-form-select" data-uk-form-select>
                      <span></span>
                      <select name="zapis_id">
                        <?php
                        $connection = new mysqli("localhost", "user", "pass", "base_name");
                          $query = "SELECT id, naslov FROM zapisi";
                          $result = $connection -> query($query);
                          if($result -> num_rows > 0)
                            while($row = $result -> fetch_assoc()){
                              echo '<option value='.$row['id'].'>'.$row['naslov'].'</option>';
                            }
                          $connection -> close();
                        ?>
                      </select>
                  </div>


                    <div class="uk-modal-footer uk-text-center">
                        <button class="uk-button lobby-button" type="submit" id="addform" name="addform">Izbriši</button><br><br>
                </form>
                    </div>
            </div>
            </div>
        </div>


				<div id="modal-potrdi" uk-modal>
						<div class="uk-modal-dialog">
								<button class="uk-modal-close-default" type="button" uk-close></button>
						<div class="uk-modal-header" style='background-color: #87CEFA;'>
								<h2 class="uk-modal-title lobby-text">potrdi uporabnika</h2>
						</div>
						<div class="uk-modal-body uk-text-center">
								<form action='potrdi.php' method="post">

									<div class="uk-form-select" data-uk-form-select>
											<span></span>
											<select name="uporabnik">
												<?php
									$connection = new mysqli("localhost", "user", "pass", "base_name");
													$query = "SELECT id, uporabnisko_ime FROM uporabniki";
													$result = $connection -> query($query);
													if($result -> num_rows > 0)
														while($row = $result -> fetch_assoc()){
															echo '<option value='.$row['id'].'>'.$row['uporabnisko_ime'].'</option>';
														}
													$connection -> close();
												?>
											</select>
									</div>


										<div class="uk-modal-footer uk-text-center">
												<button class="uk-button lobby-button" type="submit" id="potrdiform" name="potrdiform">Potrdi</button><br><br>
								</form>
										</div>
						</div>
						</div>
				</div>



    </body>
</html>
