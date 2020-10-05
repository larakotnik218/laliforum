<?php
    require_once('configGoogle.php');
    require_once('configFacebook.php');
	session_start();
	if(isset($_SESSION['id']))
		header('Location: forum.php');
		
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Forium</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="img/icon.ico" type="image/gif" sizes="64x64">
        <script src="https://apis.google.com/js/platform.js" async defer></script>
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
                <br><br>
                <h3 class='uk-header' style="font-weight: bold; color:white; text-transform: uppercase;":>forum za vse!</h3>
                <p style="font-size:20px; color: white; ">Forum, kjer lahko napišete svoj problem,vprašate za mnenje, razrešite svoje pomisleke in pomagate drugim s tem, da izrazite svoje mnenje ali stališče.</p> <br>
				<a class="uk-button uk-button-default uk-button-large" href='#modal-login' uk-toggle>PRIJAVA</a>
				<br><br>
				<!-- Google login -->
				<button type='button' class='uk-button' style="background-color:red; color: white; "   onclick='window.location="<?php echo $google_login;?>"'>Prijava z Google </button>
				<!-- Facebook login -->
				<button type='button' class='uk-button' style="background-color:#87CEFA; color: white; "  onclick='window.location="<?php echo $facebook_login_url;?>"'>Prijava z Facebook</button>

            </div>
        </div>
        <br>


		<!-- login modal -->
        <div id="modal-login" uk-modal>
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header" style='background-color:#87CEFA;'>
                <h2 class="uk-modal-title lobby-text">Prijava</h2>

            </div>

            <div class="uk-modal-body uk-text-center">
                <form action='login.php' method="post">
                    <!-- username login -->
                    <div class="uk-margin">
                        <div class="uk-inline">
                            <span class="uk-form-icon" uk-icon="icon: user"></span>
                            <input class="uk-input" type="text" name="user" placeholder="uporabniško ime" required>
                        </div>
                    </div>
                    <!-- password login -->
                    <div class="uk-margin">
                        <div class="uk-inline">
                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                            <input class="uk-input" type="password" name="pass" placeholder="geslo" required>
                        </div>
                    </div>

                    <div class="uk-modal-footer uk-text-center">
                        <button class="uk-button lobby-button" type="submit" id="login" name="logform">Prijava</button><br><br><br>
                        <a href="#modal-register" class="uk-button lobby-button" uk-toggle>Registracija</a>
                        

                </form>
                											
                    </div>
            </div>
            </div>
        </div>

				<!-- modal register -->
        <div id="modal-register" uk-modal>
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header" style='background-color: #87CEFA;'>
                <h2 class="uk-modal-title lobby-text">Registracija</h2>
            </div>

            <div class="uk-modal-body uk-text-center">
                <form enctype="multipart/form-data" action="register.php" method="post">
                    <!-- username register -->
                    <div class="uk-margin">
                        <div class="uk-inline">
                            <span class="uk-form-icon" uk-icon="icon: user"></span>
                            <input class="uk-input" type="text" name="user" id="" placeholder="uporabniško ime" required>
                        </div>
                    </div>
                    <!-- email register -->
                    <div class="uk-margin">
                        <div class="uk-inline">
                            <span class="uk-form-icon" uk-icon="icon: mail"></span>
                            <input class="uk-input" type="email" name="email" placeholder="email" required>
                        </div>
                    </div>
                    <!-- password register -->
                    <div class="uk-margin">
                        <div class="uk-inline">
                            <span class="uk-form-icon uk-form-icon" uk-icon="icon: lock"></span>
                            <input class="uk-input" type="password" name="pass" placeholder="geslo" required>
                        </div>
                    </div>

										<div class="uk-margin">
                        <div class="uk-inline">
													<div class="js-upload" uk-form-custom>
													    <input type="file" name="slika" />
													    <button  class="uk-button uk-button-default" type="button" tabindex="-1">Izberi sliko</button>
													</div>
                        </div>
                    <div class="uk-modal-footer uk-text-center">
                        <button class="uk-button lobby-button" type="submit" name="regform">Registracija</button>
                </form>
                    </div>
            </div>
            </div>
        </div>

    </body>
</html>
