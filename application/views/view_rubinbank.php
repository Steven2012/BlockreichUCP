<?php $this->load->view('includes/head'); ?>
<?php $this->load->view('includes/header'); ?>
    
<h2 class="page-title">Rubinbank Kontoauszug</h2>

<!-- Wenn keine Daten vorhanden... -->
<?php if($statement == false) { ?>
    <b>Es sind keine Daten vorhanden</b>
    
<!-- Ansonsten... -->
<?php } else {
    ?>
    <h3>Kontostand:</h3><br>
    <?php echo $bankamount; ?>
    <br><hr><br>

    <table>
        <thead>
            <th>Benutzer</th>
            <th>Aktion</th>
            <th>2. Benutzer</th>
            <th>Menge</th>
            <th>Neuer Kontostand</th>
            <th>Datum</th>
        </thead>
        <tbody>
            <?php
            // Für jede Zeile aus der DB wird eine Zeile in der Tabelle erstellt
            foreach($statement as $sm) { ?>
                <tr>
                    <!-- Die Werte haben den gleichen Namen wie die Spalten in der Datenbank -->
                    <td><?php echo $sm->user; ?></td>
                    <td><?php
                    switch($sm->Action) {
                        case "IN": echo "Einzahlung"; break;
                        case "OUT": echo "Auszahlung"; break;
                        case "TRANSFER_IN": echo "Eingehende &Uuml;berweisung"; break;
                        case "TRANSFER_OUT": echo "Ausgehende &Uuml;berweisung"; break;
                        default: echo $sm->action;
                    }
                    ?></td>
                    <td><?php echo $sm->user2; ?></td>
                    <td><?php echo $sm->ActionAmount; ?></td>
                    <td><?php echo $sm->newAmount; ?></td>
                    <td>
                        <?php
                            $date = explode('-', $sm->Date);
                            $date = array_reverse($date);
                            echo $date[0].'.'.$date[1].'.'.$date[2];
                        ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>

<?php $this->load->view('includes/footer'); ?>