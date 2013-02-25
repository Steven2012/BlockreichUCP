<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ticket_model extends CI_Model {
	
	/* function getStatement()
	 * 
	 * Holt Username und E-Mail aus der Datenbank
	 * 
	 * keine Parameter
	 *
	 */
    public function getUser() {
	
	// Username aus der Session auslesen
    $username = $this->session->userdata('username');
	}
	public function getUserData($username) {
        // Auslesen der Zeile des Users aus der Datenbank
        $query = $this->db->query("SELECT * FROM blockreich_users WHERE user='".$username."'");
        
        // Zeile wird in einem Array gespeichert
        $user = $query->row();
        
        // Abbruch falls es keinen Eintrag in der Datenbank gab
        if ($user == false) return false;
        
        // Ansonsten $user zurückgeben
        else return $user;        
    }
}
		
		

	