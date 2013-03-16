<div class="headerbanner">
    <img src="<?php echo base_url("styles/images/blockreich-logo.png"); ?>" alt="<?php echo SITE_NAME; ?>">
</div>

<div class="navigation">
    <div class="inner">
        <ul class="navleft">
            <li <?php if($this->uri->segment(1) == "") echo 'class="active"'; ?>>
                <a href="<?php echo site_url('') ?>">&Uuml;bersicht</a>
            </li>
            <li <?php if($this->uri->segment(1) == "profile") echo 'class="active"'; ?>>
                <a href="<?php echo site_url('profile') ?>">Profil</a>
            </li>
            <?php if($this->permissions->checkPerm('rubinbank') != false) { ?>
            <li <?php if($this->uri->segment(1) == "rubinbank") echo 'class="active"'; ?>>
                <a href="<?php echo site_url('rubinbank/statement'); ?>">Rubinbank</a>
            </li>
            <?php } ?>
            <li <?php if($this->uri->segment(1) == "stats") echo 'class="active"'; ?>>
                <a href="<?php echo site_url('stats/ontime'); ?>">Statistiken</a>
            </li>
            <?php if($this->permissions->checkPerm('userlist') != false) { ?>
            <li <?php if($this->uri->segment(1) == "users") echo 'class="active"'; ?>>
                <a href="<?php echo site_url('users'); ?>">Benutzerliste</a>
            </li>
            <?php } ?>
            <?php if($this->permissions->checkPerm('tickets') != false) { ?>
            <li <?php if($this->uri->segment(1) == "tickets") echo 'class="active"'; ?>>
                <a href="<?php echo site_url('tickets'); ?>">Tickets</a>
                <ul>
                    <li><a href="<?php echo site_url('tickets/newticket'); ?>">&bull; Neues Ticket erstellen</a></li>
                    <li><a href="<?php echo site_url('tickets/ticketlist'); ?>">&bull; Eigene Tickets</a></li>
                    <?php if($this->permissions->checkPerm('ticketsupport') != false) { ?><li><a href="<?php echo site_url('tickets/ticketsupport'); ?>" style="font-weight:bold;">&bull; Ticketverwaltung</a></li><?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php if($this->permissions->checkPerm('help') != false) { ?>
            <li <?php if($this->uri->segment(1) == "help") echo 'class="active"'; ?>>
                <a href="<?php echo site_url('help'); ?>">Hilfe</a>
                <ul>
                    <li><a href="<?php echo site_url('help/commands'); ?>">&bull; Befehlsliste</a></li>
                    <li><a href="<?php echo site_url('help/faq'); ?>">&bull; H&auml;ufig gestellte Fragen</a></li>
                </ul>
            </li>
            <?php } ?>
        </ul>
        <ul class="navright">
            <?php /* <li>
                <?php if(fopen("http://server.blockreich.net/map/tiles/faces/32x32/".$this->session->userdata('username').".png", "r")) {
                    ?><img width="16px" height="16px" class="useravatar" src="http://server.blockreich.net/map/tiles/faces/32x32/<?php echo $this->session->userdata('username'); ?>.png">
                <?php } ?>
            </li>  */ ?>
            <li>Du bist angemeldet als <a href="<?php echo site_url("users/".$this->session->userdata('username')); ?>" title="Profil anzeigen"><?php echo $this->session->userdata('username'); ?></a></li>
            <?php if($this->permissions->checkPerm('acp') != false) { ?><li><a href="<?php echo site_url('admin/'); ?>">Zum ACP</a></li><?php } ?>
            <li><a href="<?php echo site_url('logout'); ?>">Abmelden</a></li>
        </ul>
        <div style="clear:both"></div>
    </div>
</div>
<div class="container">
    <div class="main-content">

        <?php if($this->session->userdata('ticketcount') == 1) { ?>
            <div class="info">Du hast eine neue Ticket-Antwort. <a href="<?php echo site_url('tickets/ticketlist'); ?>">Zur Ticketliste</a></div>
            <br>
            <?php
            $this->session->unset_userdata('ticketcount');
        }
        elseif($this->session->userdata('ticketcount') > 1) { ?>
            <div class="info">Du hast <?php echo $this->session->userdata('ticketcount'); ?> neue Ticket-Antworten. <a href="<?php echo site_url('tickets/ticketlist'); ?>">Zur Ticketverwaltung</a></div>
            <br>
            <?php
            $this->session->unset_userdata('ticketcount');
        }
        ?>
              
        <?php if($this->session->userdata('ticketsupcount') == 1) { ?>
            <div class="warning">Ein neues Supportticket seit deinem letzten Besuch. <a href="<?php echo site_url('tickets/ticketsupport'); ?>">Zur Ticketverwaltung</a></div>
            <?php
            $this->session->unset_userdata('ticketsupcount');
        }
        elseif($this->session->userdata('ticketsupcount') > 1) { ?>
            <div class="warning"><?php echo $this->session->userdata('ticketsupcount'); ?> neue Supporttickets seit deinem letzten Besuch. <a href="<?php echo site_url('tickets/ticketsupport'); ?>">Zur Ticketverwaltung</a></div>
            <?php
            $this->session->unset_userdata('ticketsupcount');
        }
        ?>