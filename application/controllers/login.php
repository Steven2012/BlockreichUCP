<?php
/*
 * ZULETZT GE�NDERT: Steven
 * Datum: 30.12.12 - Mittags (genaue Uhrzeit nicht mehr bekannt)
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * BEVOR DU ANF�NGST MEINEN CODE ZU STUDIEREN: BITTE ZUERST DEN THREAD IM FORUM IM DEV-BEREICH DURCHLESEN!
 * 
 * Benutze bei der Entwicklung IMMER den CodeIgniter UserGuide: http://ellislab.com/codeigniter/user-guide/
 * Schau IMMER, wirklich bei ALLEM was du machst, ob es dort bereits eine Funktion f�r gibt und BENUTZE DIESE, dort wurden viele Sicherheitsfunktionen eingebaut die man durch eigenm�chtiges programmieren wieder kaputt machen w�rde.
 * Es gibt f�r fast alles wichtige eine Funktion, f�r die Formularerstellung, POST & GET, Sessions, Datenbankverbindung, Emails senden, uvw.
 * Eine Liste aller Funktionen gibt es wenn man im UserGuide oben auf "Table of Contents" klickt
 * 
 * Den UserGuide gibt es nur in englisch, aber damit sollte jeder zurechtkommen ;)
 */


class Login extends CI_Controller {

	public function index()
	{
        // Model "Login_model" aus dem Ordner "models" laden
        $this->load->model('Login_model');
        // Seitentitel definieren (f�r den title-Tag im Header)
		$data['pagetitle'] = "Anmelden";
        /*
         * Zur Startseite weiterleiten wenn der Benutzer bereits eingeloggt ist
         * 
         * Hier wird die Funktion checkIsLoggedIn() aus dem Model "Login_model" ausgef�hrt 
         * Wenn also z.B. aus dem Model "Beispiel_model" die Funktion halloWelt() ausgef�hrt werden soll lautet der Code:
         * --> $this->Beispiel_model->halloWelt();
         * 
         * ACHTUNG: Bei den Models muss der Anfangsbuchstabe IMMER gro� sein, nur der Dateiname muss kleingeschrieben sein! 
         * 
         */
		if($this->Login_model->checkIsLoggedIn()) {
			redirect('');	
		}
		
		// Pr�fen, ob kein Benutzername oder kein Passwort eingegeben wurde
        elseif($this->input->post('username') == false or $this->input->post('password') == false) {
			
            /* 
             * Loginformular laden
             * 
             * Mit dem zweiten Parameter kann man ein Array mit Daten, in diesem Fall $data, an den View �bergeben. Die Inzizies des Arrays k�nnen dann im View als Variable verwendet werden.
             * 
             * Beispiel:
             * $data['beispiel'] = "Das ist ein Beispiel";
             * $this->load->view('view_beispiel', $data);
             * 
             * Nun kann im View mit der Variable $beispiel der vorhin gespeicherte Text ausgegebn werden:
             * echo $beispiel;
             * --> Ausgabe: "Das ist ein Beispiel"
             * 
             */
            $this->load->view('view_login', $data);	
		}
		// Ansonsten, also wenn das Feld Benutzername UND das Feld Passwort ausgef�llt wurden
		else {
            
            /* Benutzername aus den POST-Daten holen
             * 
             * In CodeIgniter wird nicht $_POST und $_GET verwendet. Stattdessen kann man mit $this->input->post('FELDNAME') einen Wert einlesen:
             * 
             * Beispiel:
             * 
             * POST:
             * normalerweise:  $username = $_POST['username'];
             * in CodeIgniter: $username = $this->input->post('username');
             * 
             * Das selbe geht auch mit GET:
             * normalerweise: $name = $_GET['name'];
             * in CodeIgniter: $name = $this->input->get('name');
             * 
             * Weitere Infos dazu gibt es im UserGuide!
             * 
             * trim() ist eine PHP-Funktion zum entfernen von unn�tigen Leerzeichen, wer es nicht kennt kann es ja googlen ;) 
             */           
            $username = trim($this->input->post('username'));
            
            // Das selbe wie oben mit dem Passwort
			$password = $this->input->post('password');
			
			// Es wird die Funktion checkLogin() aus dem Login_model mit zwei Parametern ausgef�hrt
			$login = $this->Login_model->checkLogin($username, $password);
			
			// Wenn der R�ckgabewert false ist...
			if($login == false) {
                // $data['error'] wird wieder f�r das view verwendet, im Login-view wird eine Fehlermeldung angezeigt wenn $error true ist
                $data['error'] = true;
                
                // View "view_login" laden
                $this->load->view('view_login', $data);
            }
            // Wenn die Funktion den Wert "locked" zur�ckgegeben hat... (siehe "model/login_model.php", dort ist die ganze Funktion erkl�rt)
            elseif($login == "locked") {
                // Mittlerweile d�rftest du wissen was hier gemacht wird ;)
                $this->load->view('view_account_locked');
            }
            // Wenn die Funktion den Wert "nopassword" zur�ckgegeben hat...
            elseif($login == "nopassword") {
                // ...
                $this->load->view('view_no_password');
            }
            // Ansonsten (es gab keine Fehler)
			else {
                $query = $this->db->query('SELECT user FROM blockreich_users WHERE user="'.$username.'"');
                $result = $query->row();
                // Session mit Daten f�llen, im UserGuide sind Sessions in CodeIgniter genau erkl�rt
                $this->session->set_userdata('logged_in', true);
                $this->session->set_userdata('username', $result->user);
                $this->Login_model->setLastLogin();
                
                // Zur Hauptseite weiterleiten, der Loginvorgang war ja erfolgeich ;)
                redirect('');
            }
		}
	}
}