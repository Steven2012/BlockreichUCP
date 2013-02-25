<?php
/*
 * ZULETZT GEÄNDERT: Steven
 * Datum: 02.01.13 - 20:30
 */
?>

<?php $this->load->view('includes/head'); ?>
<?php $this->load->view('includes/header'); ?>

<div class="profile">
    
    <h2 class="page-title">Profil von <?php echo $user->user; ?></h2><br>
    
    <div class="userheader">
        <?php if(fopen("http://server.blockreich.net/map/tiles/faces/32x32/".$user->user.".png", "r")) {
            ?><img width="16px" height="16px" class="useravatar" src="http://server.blockreich.net/map/tiles/faces/32x32/<?php echo $user->user; ?>.png">
        <?php } ?>
        <?php echo $user->user; ?>
    </div>
    <br><br>
    
    <div class="left">
        <h3>Pers&ouml;nliche Daten:</h3><br>
        <b class="index">Email-Adresse:</b>
        <?php
        if(!$user->email) echo '<span style="color:grey">Nicht angegeben</span>';
        elseif($user->publicmail==1) echo $user->email;
        else echo '<span style="color:grey">Privat</span>';
        ?>
        <br><br>
        
        <b class="index">Forum-Benutzername:</b>
        <?php echo $user->forum_username; ?>
        <br><br>
        
        <b class="index">Kontostand</b>
        <?php
        if($user->publicmail==1) echo $user->amount;
        else echo '<span style="color:grey">Privat</span>';
        ?>
    </div>
    
    <div class="right">    
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
    </div>
    
    <span style="clear:both"></span>        

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
    /*$("#emailsubmit").click(function() {
        $("#emailsubmit").hide();
        $("#emailcancel").hide();
        $("#emailedit").show();
        $("#emailfield").attr("disabled", "disabled");
    });*/
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
    
    $(function(){
        var submit = $("#emailsubmit");
        var email = $("#emailfield");
        $("#emailsubmit").click(function() {
            $.post('<?php echo site_url("start/editEmail"); ?>', {
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
    $(function(){
        var submit = $("#usernamesubmit");
        var username = $("#usernamefield");
        $("#usernamesubmit").click(function() {
            $.post('<?php echo site_url("start/editForumUsername"); ?>', {
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
</script>

<?php $this->load->view('includes/footer'); ?>