<?php
/*
 * ZULETZT GEÄNDERT: Steven
 * Datum: 02.01.13 - 20:30
 */
?>

<?php $this->load->view('includes/head'); ?>
<?php $this->load->view('includes/header'); ?>

<div class="profile">
    
    <h2 class="page-title">Tickets</h2><br>
    
    <a href="<?php echo site_url('tickets/newticket'); ?>"><h3>Neues Ticket erstellen</h3></a><br>
    <a href="<?php echo site_url('tickets/ticketlist'); ?>"><h3>Eigene Tickets</h3></a><br>
    <?php if($this->permissions->checkPerm('ticketsupport') != false) { ?><a href="<?php echo site_url('tickets/ticketsupport'); ?>"><h3>Ticketverwaltung</h3></a><?php } ?>

</div>

<script>    
$(document).ready(function(){ 
    $("#usertable").tablesorter( {widthFixed: true, sortList: [[0,0]]} );
});
</script> 

<?php $this->load->view('includes/footer'); ?>