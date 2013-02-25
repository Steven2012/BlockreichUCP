<?php $this->load->view('acp/includes/head'); ?>
<?php $this->load->view('acp/includes/header'); ?>

<div class="profile">
    
    <h2 class="page-title">Spielkontrolle</h2><br>
    
    <h3>Serverkommando senden:</h3>
    <div id="cmdMsg"></div>
    <label for="cmdfield">Kommando eingeben:</label>
    <input id="cmdfield" type="text" name="cmd">
    <a href="#"><span class="editbutton" id="cmdsubmit">Ausf&uuml;hren</span></a>
    <br><br>
    <h3>Kommando als Spieler senden:</h3>
    <div id="cmdpMsg"></div>
    <label for="cmdpfield">Kommando eingeben:</label>
    <input id="cmdpfield" type="text" name="cmdp">
    <label for="playerfield">Spieler (muss online sein!):</label>
    <input id="playerfield" type="text" name="player">
    <a href="#"><span class="editbutton" id="cmdpsubmit">Ausf&uuml;hren</span></a>    

</div>

<script>
    // send console command to server
    $(function(){
        var submit = $("#cmdsubmit");
        var cmd = $("#cmdfield");
        $("#cmdsubmit").click(function() {
            $.post('<?php echo site_url("admin/sendconsolecommand/"); ?>', {
                action: 'sendcommand',
                cmd: $(cmd).val()
            }, function(data) {
                $("#cmdMsg").hide();
                if(data == 'success') {
                    $("#cmdMsg").addClass("success");
                    $("#cmdMsg").html("Kommando wurde erfolgreich ausgef&uuml;hrt!");
                    $("#cmdMsg").show();
                }
                else {
                    $("#cmdMsg").addClass("error");
                    $("#cmdMsg").html("Es ist ein Fehler augetreten!");
                    $("#cmdMsg").show();
                }
            });
        });
    })
    // send player command to server
    $(function(){
        var submit = $("#cmdpsubmit");
        var cmdp = $("#cmdpfield");
        var player = $("#playerfield");
        $("#cmdpsubmit").click(function() {
            $.post('<?php echo site_url("admin/sendplayercommand/"); ?>', {
                action: 'sendcommand',
                cmd: $(cmdp).val(),
                player: $(player).val()
            }, function(data) {
                $("#cmdpMsg").hide();
                if(data == 'success') {
                    $("#cmdpMsg").removeClass("error");
                    $("#cmdpMsg").addClass("success");
                    $("#cmdpMsg").html("Kommando wurde erfolgreich ausgef&uuml;hrt!");
                    $("#cmdpMsg").show();
                }
                else {
                    $("#cmdpMsg").removeClass("success");
                    $("#cmdpMsg").addClass("error");
                    $("#cmdpMsg").html("Es ist ein Fehler augetreten!");
                    $("#cmdpMsg").show();
                }
            });
        });
    })
</script>

<?php $this->load->view('acp/includes/footer'); ?>