<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {
	
    /* function __construct()
     * 
     * Führt eine Prüfung durch ob der Benutzer angemeldet ist und leitet ggf. auf die Loginseite weiter
     * 
     * Wird automatisch beim einbinden dieser Datei ausgeführt, keine weiteren Schritte nötig 
     * Falls keine Loginprüfung durchgeführt werden soll => Siehe weiter unten
     * 
     */
    function __construct() {
        parent::__construct();

        $nocheck = array('login');
         
        if(!in_array($this->uri->segment(1), $nocheck) ) {       
            
            $loggedin = $this->checkIsLoggedIn();

            if(!$loggedin) redirect('login');
            else {
                $query = $this->db->query("SELECT active FROM blockreich_users WHERE user ='".$this->session->userdata('username')."'");
                $useractive = $query->row();
                if($useractive->active == 0) {
                    $this->load->view('view_account_locked');
                    die;
                }
                if($this->uri->segment(1) != 'tickets' && $this->permissions->checkPerm('tickets') == true) {
                    $userdata = $this->getUserData($this->session->userdata('username'));
                    $query = $this->db->query("SELECT id FROM blockreich_ticket_messages WHERE receiver =".$userdata->id." AND unread = 1");
                    $ticketcount = $query->result();
                    if(count($ticketcount) > 0) {
                        $this->session->set_userdata('ticketcount', count($ticketcount));
                    }
                }
                if($this->uri->segment(1) != 'tickets' && $this->permissions->checkPerm('ticketsupport') == true) {
                    if(!$userdata) {
                        $userdata = $this->getUserData($this->session->userdata('username'));    
                    }
                    $query = $this->db->query("SELECT id FROM blockreich_ticket_messages WHERE receiver = 0 AND time >".$userdata->lastactivity);
                    $ticketsupcount = $query->result();
                    if(count($ticketsupcount) > 0) {
                        $this->session->set_userdata('ticketsupcount', count($ticketsupcount));
                    }
                }
                $data = array(
                    'lastactivity' => time()
                );
                $this->db->where('user', $this->session->userdata('username'));
                $this->db->update('blockreich_users', $data); 
            }
        }
    }
	
	/* function checkLogin($username, $password)
	 * 
	 * Benutzer anmelden
	 * 
	 * $username = Benutzername des anzumeldenden Users
	 * $password = Passwort des anzumeldenden Users
	 *
	 */
    public function checkLogin($username, $password) {
        $query = $this->db->query("SELECT * FROM blockreich_users WHERE user ='".$username."'");

        $user = $query->row();

        if ($user == false) return false;

        if ($user->active == 0) {
            return "locked";
        }
        
        if ($user->password == "") {
            return "nopassword";
        }
        $password = $this->hashpw($password, $user->userhash);
		
        if($password != $user->password) return false;

		return $user;
	}
	
	/* function setLastLogin()
	 * 
	 * Trägt letzte Loginzeit und IP in Datenbank ein
	 * 
	 * keine Parameter
	 * 
	 */
	public function setLastLogin() {
        $ip = $this->input->ip_address(); 

        $data = array(
                    'lastlogin' => time(),
                    'lastLogin_IP' => ip2long($ip)                    
                );

        $this->db->where('user', $this->session->userdata('username'));
        $this->db->update('blockreich_users', $data);
        
        /* if($query) return true;
        else return false; */
    }
	
	/* function checkIsLoggedIn()
	 *
	 * Prüfen ob Benutzer bereits eingeloggt ist
	 * 
	 * keine Parameter, es wird geprüft ob die Usersession vorhanden ist
	 *
	 */
	public function checkIsLoggedIn() {
        if($this->session->userdata('logged_in') == false) return false;

        else return true;
    }
    
    /* function getUserData($user)
     * 
     * Holt alle Daten eines Users aus der Datenbank und gibt ein Array mit den Daten zurück
     *
     * $user = Benutzername des Users dessen Daten ausgelesen werden sollen 
     * 
     */
    public function getUserData($username) {
        $query = $this->db->query("SELECT * FROM blockreich_users WHERE user='".$username."'");
        
        $user = $query->row();

        if ($user == false) return false;

        else {
            $query3 = $this->db->query("SELECT account, amount FROM rubinbank_Accounts WHERE user='".$username."'"); 
            $amount = $query3->row();
            if(!$amount) $user->amount = "Kein Konto vorhanden";
            elseif(!isset($amount->account)) $user->amount = "Kein Konto vorhanden";
            else $user->amount = $amount->amount; 
            return $user;
        }        
    }
    
    public function getUserList() {
        $query = $this->db->query("SELECT * FROM blockreich_users");        
        $users = $query->result_array();
        
        if ($users == false) return false;
        
        $query2 = $this->db->query("SELECT playerName, playtime FROM `ontime-players`");
        $ontimes = $query2->result();
        
        $query3 = $this->db->query("SELECT user, account, amount FROM rubinbank_Accounts");
        $amounts = $query3->result();
        
        for($i=0; $i<count($users); $i++) {
            foreach($ontimes as $ontime) {
                if(strtolower($ontime->playerName) == strtolower($users[$i]['user'])) {
                    $users[$i]['playtime'] = $ontime->playtime;
                    break;
                }
            }
        }
        for($i=0; $i<count($users); $i++) {
            foreach($amounts as $amount) {
                if(strtolower($amount->user) == strtolower($users[$i]['user'])) {
                    if($amount->account == 0) $users[$i]['amount'] = "Kein Konto vorhanden";
                    else $users[$i]['amount'] = $amount->amount;
                    break;
                }
            }
        }
        
        return $users;
    }
    
    /* function getOnTime($username)
     *
     * Holt Onlinezeit eines Users aus der Datenbank und gibt ein Array mit den Daten zurück
     *
     * $username = Benutzername
     *
     */
    public function getOnTime($username) {
        $query = $this->db->query("SELECT * FROM `ontime-players` WHERE playerName='".$username."'");
        $ontime = $query->row();
        if ($ontime == false) return false;
        else return $ontime; 
    }
	
	/* Funktion wird erst nach Absprache über Loginsystem genutzt, Dokumentation folgt */
	/* UPDATE 17.02.2013: Funktion wird nun genutzt, Dokumentation folgt */
    private function hashpw($password, $usersalt) { 
       $hashedpw = sha1($usersalt.$password.GLOBALSALT);
	   return $hashedpw;
    }
}