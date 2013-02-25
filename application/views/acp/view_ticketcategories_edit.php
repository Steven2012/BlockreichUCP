<?php
/*
 * ZULETZT GEÄNDERT: Steven
 * Datum: 26.01.13 - 20:54
 */
?>

<?php $this->load->view('acp/includes/head'); ?>
<?php $this->load->view('acp/includes/header'); ?>

<div class="profile">
    
    <h2 class="page-title">Ticketkategorie "<?php echo $editcat->name; ?>" bearbeiten</h2><br>
    
    <?php if(isset($savesuccess) && $savesuccess == true) { ?>
        <div class="success">Daten erfolgreich gespeichert! <a href="<?php echo site_url('admin/ticketcategories'); ?>">Zur&uuml;ck zur Kategorien-Liste</a></div>
    <?php } ?>
    
    <div class="warning">Das &Auml;ndern der Berechtigungen f&uuml;r eine Kategorie hat keine Auswirkung auf bereits existierende Tickets, Benutzer mit entsprechenden Tickets k&ouml;nnen diese weiterhin verwenden.</div>
    
    <form action="" method="post" name="editform">
        <label>Name der Kategorie:</label>
        <input type="text" name="name" value="<?php echo $editcat->name; ?>">
        <br><br>
        <label>&Uuml;bergeordnete Kategorie:</label>
        <select name="parent">
            <option value="0"<?php if($editcat->parent == 0) echo ' selected="selected"'; ?>>Keine</option>
            <?php foreach($categories as $c) { ?>
                <option value="<?php echo $c->id; ?>"<?php if($editcat->parent == $c->id) echo  ' selected="selected"'; ?>><?php echo $c->name; ?></option>
            <?php } ?>
        </select>
        <br><br>
        <label>Mindestens ben&ouml;tigte Benutzergruppe zur Verwendung:</label>
        <select name="mingroup">
            <option value="0"<?php if($editcat->mingroup == 0) echo ' selected="selected"'; ?>>Jeder</option>
            <?php foreach($groups as $g) { ?>
                <option value="<?php echo $g->id; ?>"<?php if($editcat->mingroup == $g->id) echo  ' selected="selected"'; ?>><?php echo $g->name; ?></option>
            <?php } ?>
        </select>
        <br><br>
        <input type="submit" name="submit" value="Speichern" class="editbutton">
    </form>   

</div>

<script>
$(document).ready(function(){
    $("#cattable").tablesorter( {widthFixed: true, sortList: [[0,0]]} );
});
</script>

<?php $this->load->view('acp/includes/footer'); ?>