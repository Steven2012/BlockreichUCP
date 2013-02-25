<?php $this->load->view('includes/head'); ?>
<?php $this->load->view('includes/header'); ?>
    
<h2 class="page-title">&Uuml;bersicht</h2>

<div class="profile">

    <b>Hallo <?php echo $user->user; ?>!</b>
    <br><br>
    <h3>Willkommen im neuen UCP von Blockreich!</h3><br>
    <b>Herzlich Willkommen im neuen UCP! Hier hast du die volle Kontrolle &uuml;ber deinen Blockreich-Account und dein virtuelles MC-Leben. Verwalte deine Grundst&uuml;cke (demn&auml;chst), bearbeite dein Profil, sehe die Statistiken ein und erstelle Supporttickets bei Fragen und Problemen.</b><br><br>
    
    Dein letzter Login:
    <?php
    if($user->lastlogin == 0) echo "Noch nie";
    else echo date('d.m.Y H:i', $user->lastlogin)." Uhr";
    ?>
    <br><br><br>

    <h3>Kontostand:</h3><br>
    <b><?php echo $user->amount; ?> Smaragde</b><br><br>
    <a href="<?php echo site_url('rubinbank/statement'); ?>"><b style="color: #fff;">Zum Kontoauszug</b></a>
</div>

<?php $this->load->view('includes/footer'); ?>