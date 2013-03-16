<?php $this->load->view('includes/head'); ?>
<?php $this->load->view('includes/header'); ?>

<div class="profile">
    
    <?php if($this->input->get('saved') == true) { ?>
        <div class="success">Eintrag wurde erfolgreich erstellt!</div><br>
    <?php } ?>
    
    <h2 class="page-title">Neuen FAQ-Eintrag erstellen</h2><br>
    
    <?php if(validation_errors()) echo '<div class="warning">'.validation_errors().'</div><br>'; ?>
    
    <?php echo form_open('help/faq/new'); ?>
        <label for="question">Frage:</label>
        <input type="text" id="question" name="question" style="width: 350px" value="<?php echo set_value('question'); ?>">
        <br><br>
        
        <label for="answer">Antwort:</label>
        <textarea id="answer" name="answer" cols="50" rows="5"><?php echo set_value('answer'); ?></textarea>
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