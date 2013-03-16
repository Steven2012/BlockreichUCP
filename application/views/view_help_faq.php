<?php $this->load->view('includes/head'); ?>
<?php $this->load->view('includes/header'); ?>

<div class="profile">
    
    <h2 class="page-title">H&auml;ufig gestellte Fragen</h2><br>
    
    <?php if($this->permissions->checkPerm('help_newfaq')) {
        ?><a href="<?php echo site_url('help/faq/new'); ?>"><span class="editbutton" >Eintrag hinzuf&uuml;gen</span></a><br><br><?php
    } ?>
    
    <?php if(!isset($faqs) or $faqs == false) echo "<b>Ups, da hat wohl jemand die FAQs verloren...</b><br><br>";
    else {
        foreach($faqs as $faq): ?>
        <div class="faq">
            <span class="question"><?php echo $faq->question; ?></span>
            <p><?php echo htmlspecialchars_decode($faq->answer); ?></p>
        </div>
        <br><br>
        <?php endforeach;
    } ?>
    
    <?php if($this->permissions->checkPerm('help_newfaq')) {
        ?><a href="<?php echo site_url('help/faq/new'); ?>"><span class="editbutton" >Eintrag hinzuf&uuml;gen</span></a><br><br><?php
    } ?>
</div>

<script>    
$(document).ready(function(){ 
    $("#usertable").tablesorter( {widthFixed: true, sortList: [[0,0]]} );
});
</script> 

<?php $this->load->view('includes/footer'); ?>