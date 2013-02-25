<div class="navigation" style="background-color: #000080;">
    <div class="inner">
        <ul>
            <li><b style="color: red;">Administration</b></li>
            <li <?php if($this->uri->segment(2) == "") echo 'class="active"'; ?>>
                <a href="<?php echo site_url('admin/') ?>">&Uuml;bersicht</a>
            </li>
            <li <?php if($this->uri->segment(2) == "userlist") echo 'class="active"'; ?>>
                <a href="<?php echo site_url('admin/userlist'); ?>">Benutzer</a>
            </li>
            <li <?php if($this->uri->segment(2) == "perms") echo 'class="active"'; ?>>
                <a href="<?php echo site_url('admin/perms'); ?>">Rechte</a>
            </li>
            <li <?php if($this->uri->segment(2) == "gamecontrol") echo 'class="active"'; ?>>
                <a href="<?php echo site_url('admin/gamecontrol'); ?>">Spielkontrolle</a>
            </li>
            <li>
                <a href="<?php echo site_url('admin/ticketcategories'); ?>">Ticketkategorien</a>
            </li>
        </ul>
        <ul class="navright">
            <li>Angemeldet als <a href="<?php echo site_url("users/".$this->session->userdata('username')); ?>" title="Profil anzeigen"><?php echo $this->session->userdata('username'); ?></a></li>
            <li><a href="<?php echo site_url(''); ?>">Zur&uuml;ck zum UCP</a></li>
            <li><a href="<?php echo site_url('logout'); ?>">Abmelden</a></li>
        </ul>
    </div>
</div>

<div class="container">