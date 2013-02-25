<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permissions {
    
    /*
     * function checkPerm($perm)
     * 
     * Prüft ob der aktuell eingeloggte User genügend Rechte hat
     * 
     * $perm = ausgeschriebener Name der Permission, z.B. ticket.send
     * 
     */
    public function checkPerm($perm) {
        $CI =& get_instance();
        $CI->load->library('session');
        $CI->load->dbforge();
        
        // Wenn der Parameter fehlt false zurückgeben
        if(empty($perm)) {
            return false;  
        }
       
        // Benutzername aus der Session holen
        $username = $CI->session->userdata('username');
        
        // Gruppe des Users aus DB auslesen
        $query = $CI->db->query("SELECT * FROM blockreich_users WHERE user = '".$username."'");
        $result = $query->row();
        
        if($result) {
            $groupID = $result->group;
            
            // ID der gesuchten Berechtigung aus DB auslesen
            $query = $CI->db->query("SELECT id FROM blockreich_permissions WHERE name = '".$perm."'");
            $result = $query->row();
            if(!$result) {
                return false;
            }
            $permID = $result->id;
            
            // Wert der Gruppenberechtigung aus DB auslesen
            $query = $CI->db->query("SELECT value FROM blockreich_group_perms WHERE permID = '".$permID."' && groupID='".$groupID."'");
            $result = $query->row();
            if(!$result) {
                return false;
            }
            $value = $result->value;
            
            // Wenn der Wert 1 ist hat der User genügend Rechte, true zurückgeben
            if($value == 1) return true;
        }
        return false;    
    }
}