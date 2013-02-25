<?php
/*
 * ZULETZT GEÄNDERT: Steven
 * Datum: 11.01.13 - 00:46
 */
?>

<?php $this->load->view('includes/head'); ?>
<?php $this->load->view('includes/header'); ?>

<style>
.notifytable td {
    background-color: #800000 !important;
    color: #fff !important;
}

.notifytable td a {
    color: #e3e3e3 !important;
}
</style>

<div class="profile">
    
    <h2 class="page-title">Eigene Tickets</h2><br>
    
    <?php if(isset($ticketsaved)) { ?><div class="info">Das Ticket wurde erfolgreich abgesendet!</div><br><br><?php } ?>
    
    <a href="<?php echo site_url('tickets/newticket'); ?>" class="editbutton"><b>Neues Ticket erstellen</b></a><br><br>
    
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
                <?php 
                $query = $this->db->query("SELECT unread FROM blockreich_ticket_messages WHERE ticketID=".$ticket->ticketID." && unread=1");
                if ($query->num_rows() > 0) $unread = true;
                else $unread = false;
                ?>
                <tr<?php if($unread==true) echo ' class="notifytable"' ?>>
                    <td>
                        <a href="<?php echo site_url('tickets/ticket-'.$ticket->ticketID); ?>" title="Ticket anzeigen">#<?php echo $ticket->ticketID; ?></a>
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
                            $query2 = $this->db->query('SELECT sender, receiver, time FROM blockreich_ticket_messages WHERE ticketID='.$ticket->ticketID.' ORDER BY time DESC LIMIT 0,1');
                            $msg = $query2->row();
                            if($msg->receiver == $user->id) {
                                if($msg->sender == 0) {
                                    $sender->user = "Supportteam";
                                } else {
                                    $query3 = $this->db->query('SELECT user FROM blockreich_users WHERE id='.$msg->sender);
                                    $sender = $query3->result();
                                }
                                echo "von ".$sender->user;
                            } else {
                                if($msg->receiver == 0) {
                                    $receiver->user = "Supportteam";
                                } else { 
                                    $query3 = $this->db->query('SELECT user FROM blockreich_users WHERE id='.$msg->receiver);
                                    $receiver = $query3->result();
                                }
                                echo "an ".$receiver->user;
                            }
                            echo " - ".date('d.m.Y H:i', $msg->time);
                        ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php } // end else ?>

</div>

<script>    
$(document).ready(function(){ 
    $("#usertable").tablesorter( {widthFixed: true, sortList: [[0,0]]} );
});
</script> 

<?php $this->load->view('includes/footer'); ?>