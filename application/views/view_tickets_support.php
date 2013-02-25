<?php
/*
 * ZULETZT GEÄNDERT: Steven
 * Datum: 26.01.13 - 20:54
 */
?>

<?php $this->load->view('includes/head'); ?>
<?php $this->load->view('includes/header'); ?>

<div class="profile">
    
    <h2 class="page-title">Ticketsupport</h2><br>
    
    <?php if(isset($ticketsaved)) { ?><div class="info">Das Ticket wurde erfolgreich abgesendet!</div><br><br><?php } ?>
    
    <?php if((!$tickets) or (!is_array($tickets))) {
        echo "<b>Keine Tickets vorhanden</b>";
    } else {
    ?>
    <table class="tablesorter" id="usertable">
        <thead>
            <th>Ticket-ID</th>
            <th>Titel</th>
            <th>Kategorie</th>
            <th>Status</th>
            <th>Bearbeiter</th>
            <th>Letzte Nachricht</th>
        </thead>
        <tbody>
            <?php foreach($tickets as $ticket) { ?>
                    <tr<?php if($ticket->state == 1) echo ' class="state1"'; ?>>
                        <td>
                            <a href="<?php echo site_url('tickets/ticketsupport/ticket-'.$ticket->ticketID); ?>" title="Ticket anzeigen">#<?php echo $ticket->ticketID; ?></a>
                        </td>
                        <td>
                            <?php echo $ticket->title; ?>
                        </td>
                        <td>
                            <?php
                                $query = $this->db->query('SELECT name, parent FROM blockreich_ticket_categories WHERE id='.$ticket->category);
                                $result = $query->row();
                                if($result->parent != 0) {
                                    $parentquery = $this->db->query('SELECT name FROM blockreich_ticket_categories WHERE id='.$result->parent);
                                    $parent = $parentquery->row();
                                    echo $parent->name." > ".$result->name; 
                                }  else {
                                    echo $result->name;
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                $query4 = $this->db->query('SELECT name FROM blockreich_ticket_states WHERE id='.$ticket->state);
                                $result4 = $query4->row();
                                echo $result4->name;
                            ?>
                        </td>
                        <td>
                            <?php
                                if($ticket->assignedTo) {
                                    $query5 = $this->db->query('SELECT name FROM blockreich_users WHERE id='.$ticket->assignedTo);
                                    $result5 = $query5->row();
                                    echo $result5->name;
                                }
                                else {
                                    echo "(noch) keiner";
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                $query2 = $this->db->query('SELECT sender, receiver, time, supporter FROM blockreich_ticket_messages WHERE ticketID='.$ticket->ticketID.' ORDER BY time DESC LIMIT 0,1');
                                $msg = $query2->row();
                                if($msg->receiver == 0) {
                                    $query3 = $this->db->query('SELECT id, user FROM blockreich_users WHERE id='.$msg->sender);
                                    $sender = $query3->row();
                                    echo "von ".$sender->user;
                                } else {
                                    $query3 = $this->db->query('SELECT id, user FROM blockreich_users WHERE id='.$msg->supporter);
                                    $sender = $query3->row();
                                    echo "von Supportteam (".$sender->user.")";
                                }
                                echo " - ".date('d.m.Y H:i', $msg->time);
                            ?>
                        </td>
                    </tr>
                <?php } ?>
        </tbody>
    </table>
    <?php } ?>
    
</div>

<script>    
$(document).ready(function(){ 
    $("#usertable").tablesorter( {widthFixed: true, sortList: [[3,1]]} );
});
</script> 

<?php $this->load->view('includes/footer'); ?>