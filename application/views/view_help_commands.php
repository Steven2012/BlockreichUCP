<?php $this->load->view('includes/head'); ?>
<?php $this->load->view('includes/header'); ?>

<div class="profile">
    
    <h2 class="page-title">Befehlsliste</h2><br>
    
    <?php if($this->permissions->checkPerm('help_newcmd')) {
        ?><a href="<?php echo site_url('help/commands/new'); ?>"><span class="editbutton" >Befehl hinzuf&uuml;gen</span></a><br><br><?php
    } ?>
    
    <?php if(!isset($commands) or $commands == false) echo "<b>Ups, da hat wohl jemand die Kommandos verloren...</b>";
    else { ?>
        <table class="tablesorter" id="usertable">
            <thead>
                <th>Befehl</th>
                <th>Beschreibung</th>
            </thead>
            <tbody>
                <?php foreach($commands as $cmd) { ?>
                    <tr>
                        <td>
                            <?php echo $cmd->command; ?>
                        </td>
                        <td>
                            <?php echo $cmd->desc; ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
    
    <?php if($this->permissions->checkPerm('help_newcmd')) {
        ?><a href="<?php echo site_url('help/commands/new'); ?>"><span class="editbutton" >Befehl hinzuf&uuml;gen</span></a><br><br><?php
    } ?>
</div>

<script>    
$(document).ready(function(){ 
    $("#usertable").tablesorter( {widthFixed: true, sortList: [[0,0]]} );
});
</script> 

<?php $this->load->view('includes/footer'); ?>