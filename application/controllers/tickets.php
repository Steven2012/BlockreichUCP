<?php 
/*
 * ZULETZT GEÄNDERT: Steven
 * Datum: 10.01.13 - 17:13
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tickets extends CI_Controller {

	public function __construct() {
        parent::__construct();
        if($this->permissions->checkPerm('tickets') == false) {
            show_error("Du hast keine Berechtigung diese Seite zu sehen.", 403);
        }
        $this->load->model('Login_model');
    }
    public function index()
	{
        $data['pagetitle'] = "Tickets";
        $this->load->view('view_tickets', $data);    		
	}
	public function newticket()
	{
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('title', 'Titel', 'trim|strip_tags|required|max_length[255]');
		$this->form_validation->set_rules('category', 'Kategorie', 'trim|required');
		$this->form_validation->set_rules('message', 'Nachricht', 'nl2br|trim|strip_tags|required');
        
        $user = $this->Login_model->getUserData($this->session->userdata('username'));
        
        if ($this->form_validation->run() == FALSE) {
            $data['pagetitle'] = "Neues Ticket erstellen";
            $data['additional_head_contents'] = '
                <script src="'.base_url("styles/js/jquery.elastic.source.js").'" type="text/javascript"></script>
            ';

            $data['user'] = $user;
            $query = $this->db->query("SELECT * FROM blockreich_ticket_categories WHERE parent=0 && mingroup<=".$user->group);
            $data['categories'] = $query->result();
            $this->load->view('view_tickets_form', $data);
        } else {
            $uniqueID = false;
            while($uniqueID == false) {
                $ticketID = intval(date('Ymd').rand(1000, 9999));
                $query = $this->db->query("SELECT ticketID FROM blockreich_tickets WHERE ticketID=".$ticketID);
                if($query->result()) $uniqueID = false;
                else $uniqueID = true;
            }
            $qdata = array(
               'ticketID' => $ticketID,
               'userID' => $user->id,
               'category' => $this->input->post('category'),
               'title' => $this->input->post('title'),
               'state' => 1
            );           
            $this->db->insert('blockreich_tickets', $qdata);
            $qdata2 = array(
               'ticketID' => $ticketID,
               'sender' => $user->id,
               'time' => time(),
               'message' => $this->input->post('message'),
               'unread' => 0
            );
            $this->db->insert('blockreich_ticket_messages', $qdata2);
            
            $data['pagetitle'] = "Tickets";
            $data['ticketsaved'] = true;
            $data['additional_head_contents'] = false;
            
            $user = $this->Login_model->getUserData($this->session->userdata('username'));
            $data['user'] = $user;
            $query = $this->db->query('SELECT * FROM blockreich_tickets WHERE userID='.$user->id);
            $data['tickets'] = $query->result();
            
            $this->load->view('view_tickets_list', $data);
        }
    }
    
    public function replyticket($ticketID)
    {
        $this->load->library('form_validation');

		$this->form_validation->set_rules('message', 'Nachricht', 'nl2br|trim|strip_tags|required');

        $user = $this->Login_model->getUserData($this->session->userdata('username'));

        if ($this->form_validation->run() == FALSE) {
            if($this->validation_errors()) redirect('tickets/ticket-'.$ticketID.'#reply');
            redirect('tickets/ticket-'.$ticketID);
        } else {
            $qdata = array(
               'state' => 1
            );
            $this->db->where('ticketID', $ticketID);
            $this->db->update('blockreich_tickets', $qdata);
            $qdata2 = array(
               'ticketID' => $ticketID,
               'sender' => $user->id,
               'time' => time(),

               'message' => $this->input->post('message'),
               'unread' => 0
            );
            $this->db->insert('blockreich_ticket_messages', $qdata2);

            $data['pagetitle'] = "Ticket #".$ticketID;
            $data['additional_head_contents'] = '
                <script src="'.base_url("styles/js/jquery.elastic.source.js").'" type="text/javascript"></script>
            ';
            
            $data['msgsaved'] = true;
            
            $query = $this->db->query('SELECT * FROM blockreich_tickets WHERE ticketID='.$ticketID);
            $data['ticket'] = $query->row();
    
            $query2 = $this->db->query('SELECT * FROM blockreich_ticket_messages WHERE ticketID='.$ticketID.' ORDER BY time ASC');
            $data['messages'] = $query2->result();
        
            $this->load->view('view_tickets_single', $data);
        }    
    }
    
    public function ticketlist()
    {
        $data['pagetitle'] = "Eigene Tickets";
        
        $user = $this->Login_model->getUserData($this->session->userdata('username'));
        $data['user'] = $user;
        $query = $this->db->query('SELECT * FROM blockreich_tickets WHERE userID='.$user->id);
        $data['tickets'] = $query->result();
        $this->load->view('view_tickets_list', $data);    
    }
    
    public function showticket($ticketID)
    {
        if(!$ticketID) redirect(site_url('tickets/ticketlist'));
        
        $query = $this->db->query('SELECT * FROM blockreich_tickets WHERE ticketID='.$ticketID);
        $data['ticket'] = $query->row();
        
        $query2 = $this->db->query('SELECT * FROM blockreich_ticket_messages WHERE ticketID='.$ticketID.' ORDER BY time ASC');
        $data['messages'] = $query2->result();
        foreach($data['messages'] as $msg) {
            if($msg->unread == 1) {
                $qudata = array('unread' => 0);
                $this->db->where('id', $msg->id);
                $this->db->update('blockreich_ticket_messages', $qudata);    
            }
        }
        
        $data['pagetitle'] = "Ticket #".$ticketID;
        $data['additional_head_contents'] = '
            <script src="'.base_url("styles/js/jquery.elastic.source.js").'" type="text/javascript"></script>
        ';
        
        $this->load->view('view_tickets_single', $data); 
    }
    
    public function ticketsupport()
    {
        if($this->permissions->checkPerm('ticketsupport') == false) {
            show_error("Du hast keine Berechtigung diese Seite zu sehen.", 403);
        }
        $query = $this->db->query('SELECT * FROM blockreich_tickets ORDER BY state ASC');
        $data['tickets'] = $query->result();
        
        $data['pagetitle'] = "Ticketverwaltung";
        $this->load->view('view_tickets_support', $data); 
    }
    public function support_showticket($ticketID)
    {
        if(!$ticketID) redirect(site_url('tickets/ticketsupport'));

        $query = $this->db->query('SELECT * FROM blockreich_tickets WHERE ticketID='.$ticketID);
        $data['ticket'] = $query->row();

        $query2 = $this->db->query('SELECT * FROM blockreich_ticket_messages WHERE ticketID='.$ticketID.' ORDER BY time ASC');
        $data['messages'] = $query2->result();
        
        $query3 = $this->db->query('SELECT * FROM blockreich_ticket_states');
        $data['states'] = $query3->result();

        $data['pagetitle'] = "Ticketsupport #".$ticketID;
        $data['additional_head_contents'] = '
            <script src="'.base_url("styles/js/jquery.elastic.source.js").'" type="text/javascript"></script>
        ';

        $this->load->view('view_tickets_support_single', $data);
    }
    public function support_replyticket($ticketID)
    {
        $this->load->library('form_validation');

		$this->form_validation->set_rules('message', 'Nachricht', 'nl2br|trim|strip_tags|required');

        if ($this->form_validation->run() == FALSE) {
            if($this->validation_errors()) redirect('tickets/ticketsupport/ticket-'.$ticketID.'#reply');
            redirect('tickets/ticketsupport/ticket-'.$ticketID);
        } else {
            $qdata = array(
               'state' => $this->input->post('state')
            );
            $this->db->where('ticketID', $ticketID);
            $this->db->update('blockreich_tickets', $qdata);
            
            $query = $this->db->query('SELECT userID FROM blockreich_tickets WHERE ticketID='.$ticketID);
            $user = $query->row();
            
            $sender = $this->Login_model->getUserData($this->session->userdata('username'));
            
            $qdata2 = array(
               'ticketID' => $ticketID,
               'sender' => 0,
               'receiver' => $user->userID,
               'time' => time(),
               'message' => $this->input->post('message'),
               'supporter' => $sender->id
            );
            $this->db->insert('blockreich_ticket_messages', $qdata2);

            $data['pagetitle'] = "Ticketsupport #".$ticketID;
            $data['additional_head_contents'] = '
                <script src="'.base_url("styles/js/jquery.elastic.source.js").'" type="text/javascript"></script>
            ';

            $data['msgsaved'] = true;
            
            $query = $this->db->query('SELECT * FROM blockreich_users WHERE id = '.$user->userID);
            $userdata = $query->row();
            
            $query = $this->db->query('SELECT * FROM blockreich_tickets WHERE ticketID='.$ticketID);
            $data['ticket'] = $query->row();
            
            if($userdata->mailmessages == 1) {
                $this->load->library('email');

                $this->email->from('noreply@blockreich.net', 'Blockreich Supportteam');
                $this->email->to($userdata->email);
                
                $this->email->subject('Neue Antwort zu Ticket #'.$ticketID);
                $this->email->message('
                Hallo '.$userdata->user.'!
                
                Du hast eine Antwort auf das Supporticket #'.$ticketID.' mit dem Titel "'.$data['ticket']->title.'" erhalten. Gehe jetzt auf 
                http://dev.blockreich.net/ 
                um die Nachricht anzusehen und darauf zu antworten.
                
                Das Blockreich Supportteams
                ');
                
                $this->email->send();
                
                // Auskommentieren um Maildebugging zu aktivieren
                // echo $this->email->print_debugger();
            }

            $query2 = $this->db->query('SELECT * FROM blockreich_ticket_messages WHERE ticketID='.$ticketID.' ORDER BY time ASC');
            $data['messages'] = $query2->result();
            
            $query3 = $this->db->query('SELECT * FROM blockreich_ticket_states');
            $data['states'] = $query3->result();

            $this->load->view('view_tickets_support_single', $data);
        }                                  
    }
}