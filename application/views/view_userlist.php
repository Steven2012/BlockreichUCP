<?php
/*
 * ZULETZT GEÄNDERT: Steven
 * Datum: 02.01.13 - 20:30
 */
?>

<?php $this->load->view('includes/head'); ?>
<?php $this->load->view('includes/header'); ?>

<div class="profile">
    
    <h2 class="page-title">Benutzerliste</h2><br>
    
    <table class="tablesorter" id="usertable">
        <thead>
            <th>Username</th>
            <th>Letzter UCP-Login</th>
            <th>Letzter Ingame-Login</th>
            <th>Kontostand</th>
            <th>Spielzeit</th>
        </thead>
        <tbody>
            <?php foreach($users as $user) { ?>
                <tr>
                    <td>
                        <?php if(fopen("http://server.blockreich.net/map/tiles/faces/32x32/".$user['user'].".png", "r")) {
                            ?><img width="16px" height="16px" class="useravatar" src="http://server.blockreich.net/map/tiles/faces/32x32/<?php echo $user['user']; ?>.png">
                        <?php } ?>
                        <a href="<?php echo site_url('/users/'.$user['user']); ?>" title="Profil von <?php echo $user['user']; ?> anzeigen"><?php echo $user['user']; ?></a>
                    </td>
                    <td>
                        <?php if($user['lastlogin'] == 0) echo "Noch nie";
                        else echo date('d.m.Y H:i', $user['lastlogin']); ?>
                    </td>
                    <td>
                        <?php
                        $lastlog = explode('-', $user['lastlog']);
                        $lastlog = array_reverse($lastlog);
                        echo $lastlog[0].".".$lastlog[1].".".$lastlog[2];
                        ?>
                    </td>
                    <td>
                        <?php
                        if(isset($user['amount']) && $user['publicamount']==1) echo $user['amount'];
                        elseif($user['publicamount']==1) echo "Kein Konto vorhanden";
                        else echo '<span style="color:grey">Privat</span>';
                        ?>
                    </td>
                    <td>
                        <?php
                        if(isset($user['playtime'])) {
                            $h = floor($user['playtime']/1000/60/60);
                            $m = (floor($user['playtime']/1000/60)-($h*60));
                            echo $h."h ".$m."m";
                        }
                        ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    
</div>

<script>    
$(document).ready(function(){ 
    $("#usertable").tablesorter( {widthFixed: true, sortList: [[0,0]]} );
});
</script> 

<?php $this->load->view('includes/footer'); ?>