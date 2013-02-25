<?php $this->load->view('includes/head'); ?>
<?php $this->load->view('includes/header'); ?>

<div class="profile">
    <h2 class="page-title">Neues Ticket erstellen</h2>
    
    <?php if(validation_errors()) echo '<div class="warning">'.validation_errors().'</div><br>'; ?>

    <?php echo form_open('tickets/newticket'); ?>
        <label for="title" style="width: 170px;">Titel:</label>
        <input type="text" name="title" style="width:420px" value="<?php echo set_value('title'); ?>"><br><br>
        
        <label for="category" style="width: 170px;">W&auml;hle eine Kategorie aus:</label>
        <select name="category">
            <?php
                foreach ($categories as $cat)
            	{
                    echo '<option value="'.$cat->id.'" name="'.$cat->id.'"';
                    if(set_value('category') == $cat->name) echo ' selected';
                    echo '>'.$cat->name.'</option>';
                    $query = $this->db->query("SELECT * FROM blockreich_ticket_categories WHERE parent=".$cat->id." && mingroup<=".$user->group);
                    $result = $query->result();
                    if($result) {
                        foreach($result as $cat) {
                            echo '<option value="'.$cat->id.'" name="'.$cat->id.'"';
                            if(set_value('category') == $cat->name) echo ' selected';
                            echo '>-- '.$cat->name.'</option>';
                        }
                    }
            	}
            ?>
        </select><br><br>
        
        <label for="message" style="width: 170px;">Nachricht:</label>
        <textarea name="message" cols="52" rows="5" id="contentTA"><?php echo set_value('message'); ?></textarea><br><br>
        <span style="color: #808080; font-size:11px;">
        Es ist nur reiner Text erlaubt. Texte und Bilder k&ouml;nnen bei folgenden Diensten hochgeladen und dann hier verlinkt werden:<br><br>
        Texte: <a href="http://lzy.cc/i">http://lzy.cc/p</a><br>
        Bilder: <a href="http://lzy.cc/i">http://lzy.cc/i</a><br>
        </span><br>
        
        <button type="submit" name="submit" class="editbutton">Absenden</button>
    </form>
</div>

<script type="text/javascript">
    $('#contentTA').elastic();
</script>

<?php $this->load->view('includes/footer'); ?>