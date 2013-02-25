<?php 
/*
 * ZULETZT GEÄNDERT: Steven
 * Datum: 26.01.13 - 20:54
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('Login_model');
    }
    
    public function index() {
        $data['pagetitle'] = "&Uuml;bersicht";
        $this->load->view('acp/view_start', $data);
    }
    
    public function userlist()
	{
        if($this->permissions->checkPerm('acp') == false) {
            show_error("Du hast keine Berechtigung diese Seite zu sehen.", 403);
        }
        $data['users'] = $this->Login_model->getUserList();
        $data['pagetitle'] = "Benutzerliste";
        $this->load->view('acp/view_userlist', $data);    		
	}
	
	public function edituser($username) {
        if($this->permissions->checkPerm('acp') == false) {
            show_error("Du hast keine Berechtigung diese Seite zu sehen.", 403);
        }
        if($this->input->post()) {
            if($this->input->post('publicmail')) $publicmail = 1; else $publicmail = 0;
            if($this->input->post('mailmessages')) $mailmessages = 1; else $mailmessages = 0;
            if($this->input->post('publicamount')) $publicamount = 1; else $publicamount = 0;
            
            $data = array(
                        'email' => $this->input->post('email'),
                        'forum_username' => $this->input->post('forum_username'),
                        'publicmail' =>  $publicmail,
                        'mailmessages' => $mailmessages,
                        'publicamount' => $publicamount,
                        'group' => $this->input->post('group')
                    );
            $this->db->where('user', $username);
            $result = $this->db->update('blockreich_users', $data);
            if($result) redirect('admin/userlist/');
            else {
                echo "Es ist ein Fehler aufgetreten!";
                die;
            }    
        } else {
            $data['user'] = $this->Login_model->getUserData($username);
            if($data['user'] == false) {
                echo "Der angegebene Benutzer wurde nicht gefunden!";
                die;
            }
    		$data['pagetitle'] = "Profil von ".$username." bearbeiten";
            $this->load->view('acp/view_edituser', $data);
        }
    }
    
    public function lockuser($username) {
        if($this->permissions->checkPerm('acp') == false) {
            show_error("Du hast keine Berechtigung diese Seite zu sehen.", 403);
        }
        $this->db->where('user', $username);
        $result = $this->db->update('blockreich_users', array('active' => 0));
        
        if($result) redirect('admin/userlist/');
        else {
            echo "Es ist ein Fehler aufgetreten!";
            die;
        }
    }
    
    public function unlockuser($username) {
        if($this->permissions->checkPerm('acp') == false) {
            show_error("Du hast keine Berechtigung diese Seite zu sehen.", 403);
        }
        $this->db->where('user', $username);
        $result = $this->db->update('blockreich_users', array('active' => 1));

        if($result) redirect('admin/userlist/');
        else {
            echo "Es ist ein Fehler aufgetreten!";
            die;
        }
    }
    
    public function perms() {
        if($this->permissions->checkPerm('acp') == false) {
            show_error("Du hast keine Berechtigung diese Seite zu sehen.", 403);
        }
        if($this->input->post()) {
            $postdata = $this->input->post();
            $data = array();
            foreach($postdata as $key => $value) {
                if($value == "on") $value = 1;
                else $value = 0;
                $data[$key] = $value;
            }
            $query = $this->db->query("SELECT * FROM blockreich_group_perms");
            $perms = $query->result();
            foreach($perms as $p) {
                if(!array_key_exists($p->grouppermID, $data)) {
                    $data[$p->grouppermID] = 0;
                }
            }            
            foreach($data as $key => $value) {
                $this->db->where('grouppermID', $key);
                $this->db->update('blockreich_group_perms', array('value' => $value));
            }
            redirect('admin/perms/');
        } else {
            $query = $this->db->query("SELECT * FROM blockreich_groups");
            $data['groups'] = $query->result();
            $data['pagetitle'] = "Gruppenrechte";
            $this->load->view('acp/view_perms', $data);    
        }
    }
    
    public function ticketcategories($action = "list", $cat = false) {
        if($this->permissions->checkPerm('acp') == false) {
            show_error("Du hast keine Berechtigung diese Seite zu sehen.", 403);
        }
        if($action == "list") {
            $query = $this->db->query("SELECT * FROM blockreich_ticket_categories");
            $data['categories'] = $query->result();
            $data['pagetitle'] = "Ticketkategorien";
            $this->load->view('acp/view_ticketcategories', $data);
        }
        elseif($action == "edit") {
            if(!$cat) return false;
            if(!is_numeric(trim($cat))) return false;
            
            $this->load->library('form_validation');

    		$this->form_validation->set_rules('name', 'Kategoriename', 'trim|required');
    		$this->form_validation->set_rules('parent', '&Uuml;bergeordnete Kategorie', 'trim|is_numeric|required');
    		$this->form_validation->set_rules('mingroup', 'Mindestens ben&ouml;tigte Benutzergruppe', 'trim|is_numeric|required');
            
            if ($this->form_validation->run() == FALSE) {
                $query = $this->db->query("SELECT * FROM blockreich_ticket_categories WHERE id=".$cat);
                $data['editcat'] = $query->row();
                $query = $this->db->query("SELECT * FROM blockreich_ticket_categories WHERE parent=0");
                $data['categories'] = $query->result();
                $query = $this->db->query("SELECT * FROM blockreich_groups");
                $data['groups'] = $query->result();
                $data['pagetitle'] = "Ticketkategorie bearbeiten";
                $this->load->view('acp/view_ticketcategories_edit', $data);
            }
            else {
                $name = $this->input->post('name');
                $parent = $this->input->post('parent');
                $mingroup = $this->input->post('mingroup');
                $updatedata = array(
                    'name' => $name,
                    'parent' => $parent,
                    'mingroup' => $mingroup
                );
                $this->db->where('id', $cat);
                $this->db->update('blockreich_ticket_categories', $updatedata);
                
                $query = $this->db->query("SELECT * FROM blockreich_ticket_categories WHERE id=".$cat);
                $data['editcat'] = $query->row();
                $query = $this->db->query("SELECT * FROM blockreich_ticket_categories WHERE parent=0");
                $data['categories'] = $query->result();
                $query = $this->db->query("SELECT * FROM blockreich_groups");
                $data['groups'] = $query->result();
                $data['pagetitle'] = "Ticketkategorie bearbeiten";
                $data['savesuccess'] = true; 
                $this->load->view('acp/view_ticketcategories_edit', $data);        
            }
        }
        elseif($action == "delete") {
            if(!$cat) return false;
            if(!is_numeric(trim($cat))) return false;
            
            $this->db->delete('blockreich_ticket_categories', array('id' => $cat));
            
            $query = $this->db->query('SELECT ticketID FROM blockreich_tickets WHERE category='.$cat);
                   
            foreach($query->result() as $ticket) {
                $this->db->delete('blockreich_tickets', array('ticketID' => $ticket->ticketID));
                
                $query = $this->db->query('SELECT id FROM blockreich_ticket_messages WHERE ticketID='.$ticket->ticketID);
                foreach($query->result() as $msg) {
                    $this->db->delete('blockreich_ticket_messages', array('ticketID' => $ticket->ticketID));    
                }
            }
            $query = $this->db->query("SELECT * FROM blockreich_ticket_categories");
            $data['categories'] = $query->result();
            $data['pagetitle'] = "Ticketkategorien";
            $data['deletesuccess'] = true;
            $this->load->view('acp/view_ticketcategories', $data);                  
        }  
    }
    public function gamecontrol() {
        if($this->permissions->checkPerm('acp') == false) {
            show_error("Du hast keine Berechtigung diese Seite zu sehen.", 403);
        }
        $data['pagetitle'] = "Spielkontrolle";
        $this->load->view('acp/view_gamecontrol', $data);    
    }
    public function sendconsolecommand() {
        if($this->permissions->checkPerm('acp') == false) {
            show_error("Du hast keine Berechtigung diese Seite zu sehen.", 403);
        }
        if($this->input->post('action') != 'sendcommand') return false;
        if(!$this->input->post('cmd')) echo "false";       
        $cmd = $this->input->post('cmd');
        $cmd = trim($cmd);
        $cmd = str_replace('%20', ' ', $cmd);

        $this->load->file('application/controllers/Websend.php');
        
        $ws = new Websend("server.blockreich.net");
        $ws->connect("2GVajfoRMu4A2");
        $ws->doCommandAsConsole($cmd);
        $ws->disconnect();
        echo "success";
    }
    public function sendplayercommand() {
        if($this->permissions->checkPerm('acp') == false) {
            show_error("Du hast keine Berechtigung diese Seite zu sehen.", 403);
        }
        if($this->input->post('action') != 'sendcommand') return;
        if(!$this->input->post('cmd')) return;
        if(!$this->input->post('player')) return;
        $cmd = $this->input->post('cmd');
        $cmd = trim($cmd);
        $cmd = str_replace('%20', ' ', $cmd);
        $player = $this->input->post('player');
        $player = trim($player);

        $this->load->file('application/controllers/Websend.php');

        $ws = new Websend("server.blockreich.net");
        $ws->connect("2GVajfoRMu4A2");
        $ws->doCommandAsPlayer($cmd, $player);
        $ws->disconnect();
        echo "success";
    }
}