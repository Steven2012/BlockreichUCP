<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Help extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('Login_model');
    }
    public function index()
	{
        if($this->permissions->checkPerm('help') == false) {
            show_error("Du hast keine Berechtigung diese Seite zu sehen.", 403);
        }
        /* $data['pagetitle'] = "Hilfe";
        $this->load->view('view_userlist', $data); */    		
	}
	public function commands() {
        if($this->permissions->checkPerm('help') == false) {
            show_error("Du hast keine Berechtigung diese Seite zu sehen.", 403);
        }
        $this->load->model("Help_model");
        $data['commands'] = $this->Help_model->getCommandList();
		$data['pagetitle'] = "Kommandoliste";
        $this->load->view('view_help_commands', $data);
    }
    public function newcommand() {
        if($this->permissions->checkPerm('help') == false) {
            show_error("Du hast keine Berechtigung diese Seite zu sehen.", 403);
        }
        if($this->permissions->checkPerm('help_newcmd') == false) {
            show_error("Du hast keine Berechtigung diese Seite zu sehen.", 403);
        }
        $this->load->model("Help_model");
        
        $this->load->library('form_validation');

        $this->form_validation->set_rules('command', 'Befehl', 'trim|htmlspecialchars|required|max_length[100]');
		$this->form_validation->set_rules('desc', 'Beschreibung', 'trim|htmlspecialchars|required|max_length[255]');
        
        if ($this->form_validation->run() == FALSE) {
            $data['pagetitle'] = "Neuen Befehl einf&uuml;gen - Kommandoliste";
            $this->load->view('view_help_commands_new', $data);
        } else {
            $data = array(
                'command' => $this->input->post('command'),
                'desc' => $this->input->post('desc')
            );
            $save = $this->Help_model->saveCmd($data);
            if(!$save) die("Es ist ein interner Fehler aufgetreten!");
            redirect('help/commands/new/?saved=true');
        } 
    }
    public function faq() {
        if($this->permissions->checkPerm('help') == false) {
            show_error("Du hast keine Berechtigung diese Seite zu sehen.", 403);
        }
        $this->load->model("Help_model");
        $data['faqs'] = $this->Help_model->getFAQ();
		$data['pagetitle'] = "H&auml;ufig gestellte Fragen";
        $this->load->view('view_help_faq', $data);    
    }
    public function newfaq() {
        if($this->permissions->checkPerm('help') == false) {
            show_error("Du hast keine Berechtigung diese Seite zu sehen.", 403);
        }
        if($this->permissions->checkPerm('help_newfaq') == false) {
            show_error("Du hast keine Berechtigung diese Seite zu sehen.", 403);
        }
        $this->load->model("Help_model");

        $this->load->library('form_validation');

        $this->form_validation->set_rules('question', 'Frage', 'trim|htmlspecialchars|required|max_length[255]');
		$this->form_validation->set_rules('answer', 'Antwort', 'trim|htmlspecialchars|required');

        if ($this->form_validation->run() == FALSE) {
            $data['pagetitle'] = "Neuen Eintrag erstellen - H&auml;ufig gestellte Fragen";
            $this->load->view('view_help_faq_new', $data);
        } else {
            $data = array(
                'question' => $this->input->post('question'),
                'answer' => $this->input->post('answer')
            );
            $save = $this->Help_model->saveFAQ($data);
            if(!$save) die("Es ist ein interner Fehler aufgetreten!");
            redirect('help/faq/new/?saved=true');
        }
    }
}