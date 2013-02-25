<?php
/*
 * ZULETZT GEÄNDERT: Steven
 * Datum: 04.01.13 - 00:48
 */
?>

<?php $this->load->view('acp/includes/head'); ?>
<?php $this->load->view('acp/includes/header'); ?>

<div class="profile">
    
    <h2 class="page-title">Gruppenrechte bearbeiten</h2><br>
    
    <form action="" method="post">
        <?php foreach($groups as $group) {
            ?><div style="width:480px; float:left; margin-bottom:20px;"><?php
            echo "<h3>".$group->name."</h3><br><br>";
            $query = $this->db->query("SELECT * FROM blockreich_group_perms WHERE groupID = ".$group->id);
            $perms = $query->result();
            foreach($perms as $p) {
                $query2 = $this->db->query("SELECT * FROM blockreich_permissions WHERE id = ".$p->permID);
                $perm = $query2->row();
                ?>
                <div class="perm">
                    <label for="<?php echo strtolower($p->grouppermID); ?>">
                        <?php echo $perm->displayName; ?><br>
                        <span><?php echo $perm->displayDesc; ?></span>
                    </label>
                    <input type="checkbox" name="<?php echo strtolower($p->grouppermID); ?>" <?php if($p->value==1) echo ' checked="checked"'; ?>>
                </div>
                <?php
            } 
            ?></div>
        <?php } ?>
        <div style="clear:both; float:none;"></div>
        <hr><br>
        <input type="submit" value="Speichern" class="editbutton">
    </form>
   

</div>

<?php $this->load->view('acp/includes/footer'); ?>