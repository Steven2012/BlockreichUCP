<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $pagetitle." - ".SITE_NAME ?></title>
        <meta name="description" content="">
        <link rel="stylesheet" href="<?php echo base_url("styles/css/main.css"); ?>">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
        <style media="screen" type="text/css">/*<![CDATA[*/@import '<?php echo base_url("styles/fonts/minecraft/stylesheet.css"); ?>';/*]]>*/</style>
    </head>

    <body class="loginpage">
        <div class="container" style="background:none">
            <img src="<?php echo base_url("styles/images/blockreich-logo.png"); ?>" title="Blockreich UCP">
            <div class="login-left" id="login-left">
                <h2>Verwalte deinen Account!</h2>
                <h2 style="color:#eee">Grundst&uuml;cke <br>Kontostand <br>u.v.m.</h2>
                <br><br>
                <form action="" method="post">
                    <div class="loginbox">
                        <div class="info">Durch den Umzug wurden alle Benutzerdaten gel&ouml;scht. Jeder muss sich Ingame ein neues Passwort anlegen (siehe unten)!</div><br>
                        <?php if(isset($error) && $error == true) { ?>

                        <div class="warning">Die Logindaten waren nicht korrekt. Bitte versuche es erneut.</div><br>
                        <?php } ?>

                        <!-- <label for="username">Benutzername:</label> -->
                        <input type="text" name="username" value="" placeholder="Benutzername"><br><br>
                        <!-- <label for="password">Passwort:</label> -->
                        <input type="password" name="password" value="" placeholder="Passwort"><br><br>
                        <a id="pwforgetbtn" class="pwreset" style="cursor:pointer">Passwort vergessen?</a>
                        <input class="sbtn" type="submit" name="submit" value="Anmelden">
                    </div>
                </form>
                <br><br>
                <!-- Verlinkung auf FAQ/Wiki-Seite die das Setzen des UCP-Passworts beschreibt -->
                <h3>Noch kein UCP-Account? <a id="newaccbtn" style="cursor:pointer">Jetzt erstellen!</a></h3>
            </div>
            <div class="login-right" id="login-right">
                <img src="<?php echo base_url("styles/images/ucp-macbook.png"); ?>">
            </div>
            <span style="clear:both"></span>

            <div id="newaccdiv">
                <h2>Noch kein UCP-Account?</h2><br><br>
                Kein Problem! Du musst dir lediglich Ingame ein Passwort setzen, dann kannst du dich mit deinem Minecraft-Benutzernamen und diesem Passwort im UCP anmelden.
                <br><br>
                <h3>In 3 Schritten zum UCP-Account:</h3><br>
                <b>1. Starte Minecraft und joine auf den Server (server.blockreich.net)</b><br>
                <b>2. Gebe in den Chat den Befehl <code>/brt passwort</code> ein</b><br>
                <b>3. Du wirst nun aufgefordert dein gew&uuml;nschtes Passwort in den Chat einzugeben. Gebe also nun das gew&uuml;nschte Passwort ein und dr&uuml;cke Enter.</b>
                <br><br>
                <b>Das war es auch schon! Du kannst dich nun mit deinem Minecraft-Benutzernamen und dem eben gew&auml;hlten Passwort im UCP einloggen. Viel Spa&szlig;!</b>
                <br><br>
                <h3><a id="back2login" style="cursor:pointer">Zur&uuml;ck zum Loginformular</a></h3>
            </div>
        </div>
        <script type="text/javascript">
            $("#newaccbtn").click(function() {
                setTimeout(function(){
                    $("#newaccdiv").fadeIn(500);
                }, 500);
                $("#login-left").fadeOut(500);
                $("#login-right").fadeOut(500);
            });
            $("#pwforgetbtn").click(function() {
                setTimeout(function(){
                    $("#newaccdiv").fadeIn(500);
                }, 500);
                $("#login-left").fadeOut(500);
                $("#login-right").fadeOut(500);
            });
            $("#back2login").click(function() {
                setTimeout(function(){
                    $("#login-left").fadeIn(500);
                    $("#login-right").fadeIn(500);
                }, 500);
                $("#newaccdiv").fadeOut(500);
            });
        </script>

        <a href="#" id="slideshow_button"><div>Slideshow starten</div></a>

    <div id="slideshow-box">
        <span class="sTitle">Blockreich<br>Slideshow</span><br>
        <ul class="sPics">
            <li><a href="#" onclick="$.vegas('jump', 0)"><img src="<?php echo base_url("styles/js/vegas/images/pagebg01.jpg"); ?>" width="120px" height="100px"></a></li>
            <li><a href="#" onclick="$.vegas('jump', 1)"><img src="<?php echo base_url("styles/js/vegas/images/pagebg02.jpg"); ?>" width="120px" height="100px"></a></li>
            <li><a href="#" onclick="$.vegas('jump', 2)"><img src="<?php echo base_url("styles/js/vegas/images/pagebg03.jpg"); ?>" width="120px" height="100px"></a></li>
            <li><a href="#" onclick="$.vegas('jump', 3)"><img src="<?php echo base_url("styles/js/vegas/images/pagebg04.jpg"); ?>" width="120px" height="100px"></a></li>
            <li><a href="#" onclick="$.vegas('jump', 4)"><img src="<?php echo base_url("styles/js/vegas/images/pagebg05.jpg"); ?>" width="120px" height="100px"></a></li>
            <li><a href="#" onclick="$.vegas('jump', 5)"><img src="<?php echo base_url("styles/js/vegas/images/pagebg06.jpg"); ?>" width="120px" height="100px"></a></li>
        </ul>
    </div>

    <script type="text/javascript" src="<?php echo base_url("styles/js/vegas/jquery.vegas.js"); ?>"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var slideActive = null;
            $("#slideshow_button").click(function() {
                if(slideActive) {
                    $.vegas('stop');
                    $.vegas('destroy');
                    $("#slideshow-box").hide();
                    $("#slideshow_button").html("<div>Slideshow starten</div>");
                    $("#page").show();
                    slideActive = false;
                } else {
                    $.vegas({
                        src:'styles/js/vegas/images/pagebg01.jpg'
                    });
                    $.vegas('slideshow', {
                      delay: 7000,
                      backgrounds:[
                        { src:'styles/js/vegas/images/pagebg01.jpg', fade:1000 },
                        { src:'styles/js/vegas/images/pagebg02.jpg', fade:1000 },
                        { src:'styles/js/vegas/images/pagebg03.jpg', fade:1000 },
                        { src:'styles/js/vegas/images/pagebg04.jpg', fade:1000 },
                        { src:'styles/js/vegas/images/pagebg05.jpg', fade:1000 },
                        { src:'styles/js/vegas/images/pagebg06.jpg', fade:1000 }
                      ]
                    })('overlay');
                    /* $.vegas('overlay', {
                        src: none
                    }); */
                    $("#page").hide();
                    $("#slideshow_button").html("<div>Slideshow beenden</div>");
                    $("#slideshow-box").show();
                    slideActive = true;
                }
            });
        });
    </script>
    </body>
</html>
