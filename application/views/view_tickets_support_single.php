<?php
/*
 * ZULETZT GEÄNDERT: Steven
 * Datum: 12.01.13 - 01:03
 */
?>

<?php $this->load->view('includes/head'); ?>
<?php $this->load->view('includes/header'); ?>

<div class="profile">
    
    <br><a href="<?php echo site_url('tickets/ticketsupport'); ?>" title="Zur&uuml;ck zur Ticketsupport-Liste" style="font-weight: bold;">&lt; Zur&uuml;ck zur Ticketsupport-Liste</a><br>
    <h2 class="page-title">Ticketsupport #<?php echo $ticket->ticketID; ?></h2>
    
    <?php if(isset($msgsaved)) { ?><div class="info">Die Nachricht wurde erfolgreich abgesendet!</div><br><?php } ?>
    
    <h3>Titel: <?php echo $ticket->title; ?></h3>
    <?php
        $query = $this->db->query('SELECT name, parent FROM blockreich_ticket_categories WHERE id='.$ticket->category);
        $result = $query->row();
        if($result->parent != 0) {
            $parentquery = $this->db->query('SELECT name FROM blockreich_ticket_categories WHERE id='.$result->parent);
            $parent = $parentquery->row();
            $category = $parent->name." > ".$result->name;
        }  else {
            $category = $result->name;
        }
        $query2 = $this->db->query('SELECT name FROM blockreich_ticket_states WHERE id='.$ticket->state);
        $result2 = $query2->row();
        if($ticket->assignedTo) {
            $query5 = $this->db->query('SELECT name FROM blockreich_users WHERE id='.$ticket->assignedTo);
            $result5 = $query5->row();
            $assignedTo = $result5->name;
        }
        else {
            $assignedTo = "(noch) keiner";
        }
    ?>
    <i>
        &bull; <b>Kategorie:</b> <?php echo $category; ?><br>
        &bull; <b>Status:</b> <?php echo $result2->name; ?><br>
        &bull; <b>Bearbeiter:</b> <?php echo $assignedTo; ?>
    </i>
    <br><br>
    
    <?php foreach($messages as $msg) {
        unset($sender);
        if($msg->sender > 0) {
            $query = $this->db->query('SELECT id, user FROM blockreich_users WHERE id='.$msg->sender);
            $sender = $query->row();
        }
    ?>
        <div class="messagebox">
            <div class="messagebox-inner">
                <div class="msg-header">
                    <span style="float:left;">
                        <?php 
                        if(isset($sender->user)) {
                            ?>
                            <a href="<?php echo site_url('users/'.$sender->user); ?>"><b><?php echo $sender->user; ?></b></a><br>
                            <?php
                        } 
                        else {
                            if($msg->sender == 0) {
                                $query = $this->db->query('SELECT id, user FROM blockreich_users WHERE id='.$msg->supporter);
                                $supporter = $query->row();
                                echo '<b style="color:#000">Supportteam ('.$supporter->user.')</b>';
                            }
                            else echo 'Unbekannt';    
                        }
                        ?>
                    </span>
                    <span style="float:right">
                        <?php echo date('d.m.Y H:i', $msg->time).' Uhr'; ?>
                    </span>
                    <span style="clear:both"></span>
                </div>
                <div class="msg-content">
                    <?php echo $msg->message; ?>
                </div>
            </div>
        </div>
        <br>
    <?php } ?>
    <br>
    <div id="reply">
        <h3>Ticket beantworten:</h3><br>
        
        <?php if(validation_errors()) echo '<div class="warning">'.validation_errors().'</div><br>'; ?>
        
        <?php echo form_open('tickets/ticketsupport/ticket-'.$ticket->ticketID.'/reply'); ?>
            <label for="state">Status:</label>
            <select id="state" name="state">
                <?php foreach($states as $s) { ?>
                <option value="<?php echo $s->id; ?>"<?php if($s->id==$ticket->state) echo ' selected'; ?>><?php echo $s->name; ?></option>
                <?php } ?>
            </select><br><br>
            
            <label for="message">Nachricht:</label>
            <textarea id="message" name="message" cols="52" rows="5" id="contentTA"><?php echo set_value('message'); ?></textarea><br>
            <span style="color: #808080; font-size:11px;">
            Es ist nur reiner Text erlaubt. Texte und Bilder k&ouml;nnen bei folgenden Diensten hochgeladen und dann hier verlinkt werden:<br><br>
            Texte: <a href="http://lzy.cc/i">http://lzy.cc/p</a><br>
            Bilder: <a href="http://lzy.cc/i">http://lzy.cc/i</a><br>
            </span><br>
            <input type="submit" name="submit" value="Absenden" class="editbutton">
        </form>
    </div>

</div>

<script type="text/javascript">
    $('#contentTA').elastic();
</script>

<?php $this->load->view('includes/footer'); ?>