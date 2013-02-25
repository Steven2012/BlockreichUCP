<?php
/*
 * ZULETZT GEÄNDERT: Steven
 * Datum: 02.01.13 - 20:30
 */
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rubinbank_model extends CI_Model {
	
	/* function getStatement()
	 * 
	 * Gibt Kontoauszug des aktuellen Users von Rubinbank zurück
	 * 
	 * keine Parameter
	 *
	 */
    public function getStatement() {
        // Username aus der Session auslesen
        $username = $this->session->userdata('username');
        
        // Auslesen der Daten aus der Datenbank
        $query = $this->db->query("SELECT * FROM rubinbank_Statements WHERE user='".$username."'");
        
        // Ergebnis wird in einem (mehrdimensionalen) Array gespeichert
        $result = $query->result();
        
        // Abbruch falls es keinen Eintrag in der Datenbank gab
        if ($result == false) return false;
        
        // Ansonsten wird das Array mit den Werten zurückgegeben
        else return $result;
	}
	
}