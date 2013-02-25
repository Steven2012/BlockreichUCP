<?php
/*
 * ZULETZT GEÄNDERT: Steven
 * Datum: 31.12.12 - 15:36
 */
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stats_model extends CI_Model {
	
	/* function getOntimeStats()
	 * 
	 * Gibt Topliste der User mit der größten Onlinezeit zurück
	 * 
	 * keine Parameter
	 *
	 */
    public function getOntimeStats($time="all") {
        $values = array("all", "today", "week", "month");
        
        if(!in_array($time, $values)) return false;
        if($time == "all") $time = "play";
        // Username aus der Session auslesen
        $username = $this->session->userdata('username');
        
        // Auslesen der Daten aus der Datenbank
        $query = $this->db->query("SELECT playerName, ".$time."time FROM `ontime-players` ORDER BY ".$time."time DESC LIMIT 0, 5");
        
        // Ergebnis wird in einem (mehrdimensionalen) Array gespeichert
        $result = $query->result();
        
        // Abbruch falls es keinen Eintrag in der Datenbank gab
        if ($result == false) return false;
        
        // Ansonsten wird das Array mit den Werten zurückgegeben
        else return $result;
	}
	
}