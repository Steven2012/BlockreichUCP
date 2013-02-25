<?php $this->load->view('includes/head'); ?>
<?php $this->load->view('includes/header'); ?>
    
<h2 class="page-title">Statistiken - Onlinezeit</h2>

<br><br>

<div class="left">
    <h3>Topliste Onlinezeit heute:</h3>
    <br>
    <table style="font-family: 'Minecraft Regular';">
        <thead>
            <th>Spieler</th>
            <th>Zeit</th>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach($toptoday as $entry) { ?>
                <?php if($entry->playerName == "ontime-data") continue; ?>
                <tr<?php if($i == 2) echo ' class="second"'; ?>>
                    <td><a href="<?php echo site_url("users/".$entry->playerName); ?>"><?php echo $entry->playerName; ?></a></td>
                    <td>
                        <?php
                            $h = floor($entry->todaytime/1000/60/60);
                            $m = (floor($entry->todaytime/1000/60)-($h*60));
                            echo $h."h ".$m."m";
                        ?>
                    </td>
                </tr>
                <?php
                if($i == 1) $i = 2;
                elseif($i == 2) $i = 1;
            } ?>
        </tbody>
    </table>
    
    <br><br>
    
    <h3>Topliste Onlinezeit diese Woche:</h3>
    <br>
    <table style="font-family: 'Minecraft Regular';">
        <thead>
            <th>Spieler</th>
            <th>Zeit</th>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach($topweek as $entry) { ?>
                <?php if($entry->playerName == "ontime-data") continue; ?>
                <tr<?php if($i == 2) echo ' class="second"'; ?>>
                    <td><a href="<?php echo site_url("users/".$entry->playerName); ?>"><?php echo $entry->playerName; ?></a></td>
                    <td>
                        <?php
                            $h = floor($entry->weektime/1000/60/60);
                            $m = (floor($entry->weektime/1000/60)-($h*60));
                            echo $h."h ".$m."m";
                        ?>
                    </td>
                </tr>
                <?php
                if($i == 1) $i = 2;
                elseif($i == 2) $i = 1;
            } ?>
        </tbody>
    </table>
</div>

<div class="right">
    <h3>Topliste Onlinezeit diesen Monat:</h3>
    <br>
    <table style="font-family: 'Minecraft Regular';">
        <thead>
            <th>Spieler</th>
            <th>Zeit</th>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach($topmonth as $entry) { ?>
                <?php if($entry->playerName == "ontime-data") continue; ?>
                <tr<?php if($i == 2) echo ' class="second"'; ?>>
                    <td><a href="<?php echo site_url("users/".$entry->playerName); ?>"><?php echo $entry->playerName; ?></a></td>
                    <td>
                        <?php
                            $h = floor($entry->monthtime/1000/60/60);
                            $m = (floor($entry->monthtime/1000/60)-($h*60));
                            echo $h."h ".$m."m";
                        ?>
                    </td>
                </tr>
                <?php
                if($i == 1) $i = 2;
                elseif($i == 2) $i = 1;
            } ?>
        </tbody>
    </table>
    
    <br><br>
    
    <h3>Topliste Onlinezeit gesamt:</h3>
    <br>
    <table style="font-family: 'Minecraft Regular';">
        <thead>
            <th>Spieler</th>
            <th>Zeit</th>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach($topall as $entry) { ?>
                <?php if($entry->playerName == "ontime-data") continue; ?>
                <tr<?php if($i == 2) echo ' class="second"'; ?>>
                    <td><a href="<?php echo site_url("users/".$entry->playerName); ?>"><?php echo $entry->playerName; ?></a></td>
                    <td>
                        <?php 
                            $h = floor($entry->playtime/1000/60/60);
                            $m = (floor($entry->playtime/1000/60)-($h*60));
                            echo $h."h ".$m."m";
                        ?>
                    </td>
                </tr>
                <?php
                if($i == 1) $i = 2;
                elseif($i == 2) $i = 1;
            } ?>
        </tbody>
    </table>
</div>
<span style="clear:both;"></span>
<?php $this->load->view('includes/footer'); ?>