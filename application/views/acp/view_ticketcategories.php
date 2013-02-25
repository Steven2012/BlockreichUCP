<?php
/*
 * ZULETZT GEÄNDERT: Steven
 * Datum: 26.01.13 - 20:54
 */
?>

<?php $this->load->view('acp/includes/head'); ?>
<?php $this->load->view('acp/includes/header'); ?>

<div class="profile">
    
    <h2 class="page-title">Ticketkategorien bearbeiten</h2><br>
    
    <?php if(isset($deletesuccess) && $deletesuccess == true) { ?>
        <div class="success">Kategorie und alle dazugeh&ouml;rigen Tickets erfolgreich gel&ouml;scht!</div>
    <?php } ?>
    
    <div class="warning" style="color:red">Achtung: Beim L&ouml;schen einer Ticketkategorie werden auch alle Tickets in dieser Kategorie gel&ouml;scht! Bitte verschiebe vor dem L&ouml;schen der Kategorie die Tickets in eine andere Kategorie!</div>
    <div class="warning">Das &Auml;ndern der Berechtigungen f&uuml;r eine Kategorie hat keine Auswirkung auf bereits existierende Tickets, Benutzer mit entsprechenden Tickets k&ouml;nnen diese weiterhin verwenden.</div>
    
    <table class="tablesorter" id="cattable">
        <thead>
            <th>Name</th>
            <th>&Uuml;bergeordnete Kategorie</th>
            <th>Berechtigung</th>
            <th>Aktionen</th>
        </thead>
        <tbody>
            <?php foreach($categories as $c) { ?>
                <?php
                    if($c->parent != 0) {
                        $query = $this->db->query("SELECT name FROM blockreich_ticket_categories WHERE id=".$c->parent);
                        $parent = $query->row();
                    }
                    if($c->mingroup != 0) {
                        $query = $this->db->query("SELECT name FROM blockreich_groups WHERE id=".$c->mingroup);
                        $mingroup = $query->row();
                    }
                ?>
                <tr>
                    <td>
                        <?php echo $c->name; ?>
                    </td>
                    <td>
                        <?php
                        if(isset($parent)) echo $parent->name;
                        else echo "<i>Keine</i>";
                        ?>
                    </td>
                    <td>
                        <?php
                        if(isset($mingroup)) echo 'Ab Gruppe "'.$mingroup->name.'"';
                        else echo "<i>Jeder</i>";
                        ?>
                    </td>
                    <td>
                        <a href="<?php echo site_url('admin/ticketcategories/edit/'.$c->id) ?>"><span class="acp-editbutton">Bearbeiten</span></a>
                        <a href="<?php echo site_url('admin/ticketcategories/delete/'.$c->id) ?>"><span class="acp-lockbutton">L&ouml;schen</span></a>    
                    </td>
                </tr> 
            <?php } ?>
        </tbody>
    </table>   

</div>

<script>
$(document).ready(function(){
    $("#cattable").tablesorter( {widthFixed: true, sortList: [[0,0]]} );
});
</script>

<?php $this->load->view('acp/includes/footer'); ?>