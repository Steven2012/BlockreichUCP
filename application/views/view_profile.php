<?php $this->load->view('includes/head'); ?>
<?php $this->load->view('includes/header'); ?>
    
<h2 class="page-title">&Uuml;bersicht</h2>

<b>Willkommen im RubinBank WebInterface!</b>
<br><br>

<div class="profile">

    <b>Hallo <?php echo $user->user; ?>!</b>
    <br><br>
    
    Dein letzter Login:
    <?php
    if($user->lastlogin == 0) echo "Noch nie";
    else echo date('d.m.Y H:i', $user->lastlogin)." Uhr";
    ?>
    <br><br><br>
    
    <h3>Dein Profil</h3><br>
    
    <div class="userheader">
        <?php if(fopen("http://server.blockreich.net/map/tiles/faces/32x32/".$user->user.".png", "r")) {
            ?><img width="16px" height="16px" class="useravatar" src="http://server.blockreich.net/map/tiles/faces/32x32/<?php echo $user->user; ?>.png">
        <?php } ?>
        <?php echo $user->user; ?>
    </div>
    <br><br>
    
    <h3>Pers&ouml;nliche Daten:</h3><br>
    <div id="emailMsg"></div>
    <label for="email">Email-Adresse:</label>
    <input type="email" name="email" value="<?php echo $user->email; ?>" id="emailfield" disabled="disabled">
    <a href="#" id="emailedit"><span class="editbutton">Bearbeiten</span></a>
    <a href="#" id="emailsubmit"><span class="editbutton">Speichern</span></a>
    <a href="#" id="emailcancel"><span class="editbutton">Abbrechen</span></a>
    <br><br>
    
    <div id="usernameMsg"></div>
    <label for="forum_username">Forum-Benutzername:</label>
    <input type="text" name="forum_username" value="<?php echo $user->forum_username; ?>" id="usernamefield" disabled="disabled">
    <a href="#" id="usernameedit"><span class="editbutton">Bearbeiten</span></a>
    <a href="#" id="usernamesubmit"><span class="editbutton">Speichern</span></a>
    <a href="#" id="usernamecancel"><span class="editbutton">Abbrechen</span></a>
    <br><br><br>
    
    <div id="publicmailMsg"></div>
    <label style="width: 230px;" for="publicmail">Email-Adresse &ouml;ffentlich anzeigen?</label>
    <input type="checkbox" name="publicmail" <?php if($user->publicmail==1) echo ' checked="checked"'; ?> id="publicmailfield">
    <a href="#" id="publicmailsubmit"><span class="editbutton">Speichern</span></a>
    <br><br><br>
    
    <div id="messagesMsg"></div>
    <label style="width: 230px;" for="mailmessages">Benachrichtigungen per Mail erhalten?</label>
    <input type="checkbox" name="mailmessages" <?php if($user->mailmessages==1) echo ' checked="checked"'; ?> id="messagesfield">
    <a href="#" id="messagessubmit"><span class="editbutton">Speichern</span></a>
    <br><br><br>
    
    <div id="publicamountMsg"></div>
    <label style="width: 230px;" for="amount">Kontostand &ouml;ffentlich anzeigen?</label>
    <input type="checkbox" name="publicamount" <?php if($user->publicamount==1) echo ' checked="checked"'; ?> id="publicamountfield">
    <a href="#" id="publicamountsubmit"><span class="editbutton">Speichern</span></a>

    <br><br><br><br>
      
    <h3>Spielzeit auf Server:</h3><br>
    
    <?php if($ontime == false) { echo "<b>Keine Daten zur Spielzeit vorhanden.</b>"; } else { ?>
        <ul class="useronlinetable">
            <li>
                <span>Tag: </span><br />
                <?php
                    $h = floor($ontime->todaytime/1000/60/60);
                    $m = (floor($ontime->todaytime/1000/60)-($h*60));
                    echo $h."h ".$m."m";
                ?>
            </li>
            <li>
                <span>Woche: </span><br />
                <?php
                    $h = floor($ontime->weektime/1000/60/60);
                    $m = (floor($ontime->weektime/1000/60)-($h*60));
                    echo $h."h ".$m."m";
                ?>
            </li>
            <li>
                <span>Monat: </span><br />
                <?php
                    $h = floor($ontime->monthtime/1000/60/60);
                    $m = (floor($ontime->monthtime/1000/60)-($h*60));
                    echo $h."h ".$m."m";
                ?>
            </li>
            <li>
                <span>Gesamt: </span><br />
                <?php
                    $h = floor($ontime->playtime/1000/60/60);
                    $m = (floor($ontime->playtime/1000/60)-($h*60));
                    echo $h."h ".$m."m";
                ?>
            </li>
        </ul>
    <?php } ?>
    <br><br><br>
    
    <h3>Kontostand:</h3><br>
    <b><?php echo $user->amount; ?> Smaragde</b><br><br>
    <a href="<?php echo site_url('rubinbank/statement'); ?>"><b style="color: #fff;">Zum Kontoauszug</b></a>
</div>

<script>
$(document).ready(function() {
    $("#emailsubmit").hide();
    $("#emailcancel").hide();
    $("#usernamesubmit").hide();
    $("#usernamecancel").hide();
});
$("#emailedit").click(function() {
    $("#emailfield").removeAttr("disabled");
    $("#emailedit").hide();
    $("#emailsubmit").show();
    $("#emailcancel").show();
});
$("#emailcancel").click(function() {
    $("#emailsubmit").hide();
    $("#emailcancel").hide();
    $("#emailedit").show();
    $("#emailfield").attr("disabled", "disabled");
});
$("#usernameedit").click(function() {
    $("#usernamefield").removeAttr("disabled");
    $("#usernameedit").hide();
    $("#usernamesubmit").show();
    $("#usernamecancel").show();
});
$("#usernamecancel").click(function() {
    $("#usernamesubmit").hide();
    $("#usernamecancel").hide();
    $("#usernameedit").show();
    $("#usernamefield").attr("disabled", "disabled");
});

/* EMAIL BEARBEITEN */
$(function(){
    var submit = $("#emailsubmit");
    var email = $("#emailfield");
    $("#emailsubmit").click(function() {
        $.post('<?php echo site_url("profile/editEmail"); ?>', {
            action: 'validate_email',
            email: $(email).val()
        }, function(data) {
            $("#emailMsg").hide();
            $(email).removeClass("errorborder");
            $("#emailMsg").removeClass("error");
            $("#emailMsg").removeClass("success");
            if(data == 'unvalid email') {
                $(email).addClass("errorborder");
                $("#emailMsg").addClass("error");
                $("#emailMsg").html("Die eingegebene Email-Adresse ist ung&uuml;ltig!");
                $("#emailMsg").fadeIn();
            }
            else if(data == 'success') {
                $("#emailMsg").addClass("success");
                $("#emailMsg").html("Die Email-Adresse wurde erfolgreich ge&auml;ndert!")
                $("#emailMsg").fadeIn();

                $("#emailsubmit").hide();
                $("#emailcancel").hide();
                $("#emailedit").show();
                $("#emailfield").attr("disabled", "disabled");
            }
            else {
                $("#emailMsg").addClass("error");
                $("#emailMsg").html("Es ist ein Fehler augetreten (Fehlercode 0x100)! Bitte melde dies an einen Administrator.");
                $("#emailMsg").fadeIn();
            }
        });
    });
})

/* FORUM-USERNAME BEARBEITEN */
$(function(){
    var submit = $("#usernamesubmit");
    var username = $("#usernamefield");
    $("#usernamesubmit").click(function() {
        $.post('<?php echo site_url("profile/editForumUsername"); ?>', {
            action: 'validate_username',
            username: $(username).val()
        }, function(data) {
            $("#usernameMsg").hide();
            $(username).removeClass("errorborder");
            $("#usernameMsg").removeClass("error");
            $("#usernameMsg").removeClass("success");
            if(data == 'unvalid username') {
                $(username).addClass("errorborder");
                $("#usernameMsg").addClass("error");
                $("#emailMsg").html("Der eingegebene Forum-Benutzername ist ung&uuml;ltig!");
                $("#emailMsg").show();
            }
            else if(data == 'success') {
                $("#usernameMsg").addClass("success");
                $("#usernameMsg").html("Der Forum-Benutzername wurde erfolgreich ge&auml;ndert!")
                $("#usernameMsg").show();

                $("#usernamesubmit").hide();
                $("#usernamecancel").hide();
                $("#usernameedit").show();
                $("#usernamefield").attr("disabled", "disabled");
            }
            else {
                $("#usernameMsg").addClass("error");
                $("#usernameMsg").html("Es ist ein Fehler augetreten (Fehlercode 0x200)! Bitte melde dies an einen Administrator.");
                $("#usernameMsg").show();
            }
        });
    });
})

/* MAILADRESSE ÖFFENTLICH JA/NEIN */
$(function(){
    var submit = $("#publicmailsubmit");
    var publicmail = $("#publicmailfield");
    $("#publicmailsubmit").click(function() {
        if( $('#publicmailfield:checked').val() == 'on' ) {
            var publicmail = 'on';
        }
        else {
            var publicmail = 'off';
        }
        $.post('<?php echo site_url("profile/editPublicmail"); ?>', {
            action: 'validate_publicmail',
            publicmail: publicmail
        }, function(data) {
            $("#publicmailMsg").hide();
            $("#publicmailMsg").removeClass("error");
            $("#publicmailMsg").removeClass("success");
            if(data == 'success') {
                $("#publicmailMsg").addClass("success");
                $("#publicmailMsg").html("&Auml;nderung gespeichert!")
                $("#publicmailMsg").show();
            }
            else {
                $("#publicmailMsg").addClass("error");
                $("#publicmailMsg").html("Es ist ein Fehler augetreten (Fehlercode 0x300)! Bitte melde dies an einen Administrator.");
                $("#publicmailMsg").show();
            }
        });
    });
})

/* BENACHRICHTIGUNGEN PER MAIL JA/NEIN */
$(function(){
    var submit = $("#messagessubmit");
    var messages = $("#messagesfield");
    $("#messagessubmit").click(function() {
        if( $('#messagesfield:checked').val() == 'on' ) {
            var messages = 'on';
        }
        else {
            var messages = 'off';
        }
        $.post('<?php echo site_url("profile/editMailmessages"); ?>', {
            action: 'validate_messages',
            mailmessages: messages
        }, function(data) {
            $("#messagesMsg").hide();
            $("#messagesMsg").removeClass("error");
            $("#messagesMsg").removeClass("success");
            if(data == 'success') {
                $("#messagesMsg").addClass("success");
                $("#messagesMsg").html("&Auml;nderung gespeichert!")
                $("#messagesMsg").show();
            }
            else {
                $("#messagesMsg").addClass("error");
                $("#messagesMsg").html("Es ist ein Fehler augetreten (Fehlercode 0x300)! Bitte melde dies an einen Administrator.");
                $("#messagesMsg").show();
            }
        });
    });
})

/* KONTOSTAND ÖFFENTLICH ANZEIGEN */
$(function(){
    var submit = $("#publicamountsubmit");
    var publicamount = $("#publicamountfield");
    $("#publicamountsubmit").click(function() {
        if( $('#publicamountfield:checked').val() == 'on' ) {
            var publicamount = 'on';
        }
        else {
            var publicamount = 'off';
        }
        $.post('<?php echo site_url("profile/editPublicamount"); ?>', {
            action: 'validate_messages',
            publicamount: publicamount
        }, function(data) {
            $("#publicamountMsg").hide();
            $("#publicamountMsg").removeClass("error");
            $("#publicamountMsg").removeClass("success");
            if(data == 'success') {
                $("#publicamountMsg").addClass("success");
                $("#publicamountMsg").html("&Auml;nderung gespeichert!")
                $("#publicamountMsg").show();
            }
            else {
                $("#publicamountMsg").addClass("error");
                $("#publicamountMsg").html("Es ist ein Fehler augetreten (Fehlercode 0x400)! Bitte melde dies an einen Administrator.");
                $("#publicamountMsg").show();
            }
        });
    });
})
</script>

<?php $this->load->view('includes/footer'); ?>