<?php
/*
 * ZULETZT GEÄNDERT: Steven
 * Datum: 26.01.13 - 20:54
 */
?>

<?php $this->load->view('acp/includes/head'); ?>
<?php $this->load->view('acp/includes/header'); ?>

<div class="profile">
    
    <h2 class="page-title">Profil von <?php echo $user->user; ?> bearbeiten</h2><br>
    
    <div class="userheader">
        <?php if(fopen("http://server.blockreich.net/mc/map/tiles/faces/32x32/".$user->user.".png", "r")) {
            ?><img width="16px" height="16px" class="useravatar" src="http://server.blockreich.net/mc/map/tiles/faces/32x32/<?php echo $user->user; ?>.png">
        <?php } ?>
        <?php echo $user->user; ?>
    </div>
    <br><br>
    
    <form action="" method="post" name="editform">
        <label for="email">Email-Adresse:</label>
        <input type="text" name="email" value="<?php echo $user->email; ?>">
        <br><br>
        <label for="forum_username">Forum-Benutzername:</label>
        <input type="text" name="forum_username" value="<?php echo $user->forum_username; ?>">
        <br><br>
        <label for="publicmail">Email-Adresse &ouml;ffentlich anzeigen?</label>
        <input type="checkbox" name="publicmail" <?php if($user->publicmail==1) echo ' checked="checked"'; ?>>
        <br><br>
        <label for="mailmessages">Benachrichtigungen per Mail erhalten?</label>
        <input type="checkbox" name="mailmessages" <?php if($user->mailmessages==1) echo ' checked="checked"'; ?>>
        <br><br>
        <label for="publicamount">Kontostand &ouml;ffentlich anzeigen?</label>
        <input type="checkbox" name="publicamount" <?php if($user->publicamount==1) echo ' checked="checked"'; ?>>
        <br><br>
        <label for="group">Gruppe (Gruppennummer angeben):</label>
        <input type="text" name="group" value="<?php echo $user->group; ?>">
        <br><br>
        <input type="submit" name="submit" value="Speichern" class="editbutton">
    </form>
   

</div>

<?php $this->load->view('acp/includes/footer'); ?>