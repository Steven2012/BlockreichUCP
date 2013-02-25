<?php
/*
 * ZULETZT GE�NDERT: Steven
 * Datum: 02.01.13 - 20:30
 */
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rubinbank extends CI_Controller {

    public function __construct() {        
        parent::__construct();
        
        $this->load->model('Login_model');
        
        // Pr�fen ob User berechtigt ist die Seite aufzurufen
        if($this->permissions->checkPerm('rubinbank') == false) {
            //$this->load->view('no_permission');
            
            // Vorl�ufige Fehlermeldung, wird durch obigen view ersetzt
            show_error("Du hast keine Berechtigung diese Seite zu sehen.", 403);
        }
    }
    
    public function index()
    {
        echo "Inhalt folgt";
    }
    
    // URL: rubinbank/statement, da rubinbank = Controller, statement = Funktion
	public function statement()
	{		
        // Login_model laden, hierbei wird automatisch die Loginpr�fung durchgef�hrt
        
        $this->load->model('Rubinbank_model');
        
        // Seitentitel f�r title-Tag definieren
		$data['pagetitle'] = "Rubinbank";
		
		// Funktion getStatement() aus dem Rubinbank-Model ausf�hren und R�ckgabewert in Variable speichern
		$data['statement'] = $this->Rubinbank_model->getStatement();
		
		$query = $this->db->query("SELECT account, amount FROM rubinbank_Accounts WHERE user='".$this->session->userdata('username')."'");
        $amount = $query->row();
        if(!$amount) $data['bankamount'] = "Kein Konto vorhanden";
        elseif(!isset($amount->account)) $data['bankamount'] = "Kein Konto vorhanden";
        else $data['bankamount'] = $amount->amount;
		
        // view_rubinbank laden, Daten werden mit $data �bergeben		
        $this->load->view('view_rubinbank', $data);
	}
}