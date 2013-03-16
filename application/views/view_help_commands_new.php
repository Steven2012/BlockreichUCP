<?php $this->load->view('includes/head'); ?>
<?php $this->load->view('includes/header'); ?>

<div class="profile">
    
    <?php if($this->input->get('saved') == true) { ?>
        <div class="success">Befehl wurde erfolgreich eingef&uuml;gt!</div><br>
    <?php } ?>
    
    <h2 class="page-title">Neuen Befehl einf&uuml;gen</h2><br>
    
    <?php if(validation_errors()) echo '<div class="warning">'.validation_errors().'</div><br>'; ?>
    
    <?php echo form_open('help/commands/new'); ?>
        <label for="command">Befehl:</label>
        <input type="text" id="command" name="command" value="<?php echo set_value('command'); ?>">
        <br><br>
        
        <label for="desc">Beschreibung:</label>
        <input type="text" id="desc" name="desc" value="<?php echo set_value('desc'); ?>">
        <br><br>
        
        <button type="submit" name="submit" class="editbutton">Absenden</button>
    </form>
</div>

<script>    
$(document).ready(function(){ 
    $("#usertable").tablesorter( {widthFixed: true, sortList: [[0,0]]} );
});
</script> 

<?php $this->load->view('includes/footer'); ?>