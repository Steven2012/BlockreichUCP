<?php
/*
 * ZULETZT GEÄNDERT: Steven
 * Datum: 30.12.12 - Mittags (genaue Uhrzeit nicht mehr bekannt)
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * BEVOR DU ANFÄNGST MEINEN CODE ZU STUDIEREN: BITTE ZUERST DEN THREAD IM FORUM IM DEV-BEREICH DURCHLESEN!
 * 
 * Benutze bei der Entwicklung IMMER den CodeIgniter UserGuide: http://ellislab.com/codeigniter/user-guide/
 * Schau IMMER, wirklich bei ALLEM was du machst, ob es dort bereits eine Funktion für gibt und BENUTZE DIESE, dort wurden viele Sicherheitsfunktionen eingebaut die man durch eigenmächtiges programmieren wieder kaputt machen würde.
 * Es gibt für fast alles wichtige eine Funktion, für die Formularerstellung, POST & GET, Sessions, Datenbankverbindung, Emails senden, uvw.
 * Eine Liste aller Funktionen gibt es wenn man im UserGuide oben auf "Table of Contents" klickt
 * 
 * Den UserGuide gibt es nur in englisch, aber damit sollte jeder zurechtkommen ;)
 */


class Login extends CI_Controller {

	public function index()
	{
        // Model "Login_model" aus dem Ordner "models" laden
        $this->load->model('Login_model');
        // Seitentitel definieren (für den title-Tag im Header)
		$data['pagetitle'] = "Anmelden";
        /*
         * Zur Startseite weiterleiten wenn der Benutzer bereits eingeloggt ist
         * 
         * Hier wird die Funktion checkIsLoggedIn() aus dem Model "Login_model" ausgeführt 
         * Wenn also z.B. aus dem Model "Beispiel_model" die Funktion halloWelt() ausgeführt werden soll lautet der Code:
         * --> $this->Beispiel_model->halloWelt();
         * 
         * ACHTUNG: Bei den Models muss der Anfangsbuchstabe IMMER groß sein, nur der Dateiname muss kleingeschrieben sein! 
         * 
         */
		if($this->Login_model->checkIsLoggedIn()) {
			redirect('');	
		}
		
		// Prüfen, ob kein Benutzername oder kein Passwort eingegeben wurde
        elseif($this->input->post('username') == false or $this->input->post('password') == false) {
			
            /* 
             * Loginformular laden
             * 
             * Mit dem zweiten Parameter kann man ein Array mit Daten, in diesem Fall $data, an den View übergeben. Die Inzizies des Arrays können dann im View als Variable verwendet werden.
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
		// Ansonsten, also wenn das Feld Benutzername UND das Feld Passwort ausgefüllt wurden
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
             * trim() ist eine PHP-Funktion zum entfernen von unnötigen Leerzeichen, wer es nicht kennt kann es ja googlen ;) 
             */           
            $username = trim($this->input->post('username'));
            
            // Das selbe wie oben mit dem Passwort
			$password = $this->input->post('password');
			
			// Es wird die Funktion checkLogin() aus dem Login_model mit zwei Parametern ausgeführt
			$login = $this->Login_model->checkLogin($username, $password);
			
			// Wenn der Rückgabewert false ist...
			if($login == false) {
                // $data['error'] wird wieder für das view verwendet, im Login-view wird eine Fehlermeldung angezeigt wenn $error true ist
                $data['error'] = true;
                
                // View "view_login" laden
                $this->load->view('view_login', $data);
            }
            // Wenn die Funktion den Wert "locked" zurückgegeben hat... (siehe "model/login_model.php", dort ist die ganze Funktion erklärt)
            elseif($login == "locked") {
                // Mittlerweile dürftest du wissen was hier gemacht wird ;)
                $this->load->view('view_account_locked');
            }
            // Wenn die Funktion den Wert "nopassword" zurückgegeben hat...
            elseif($login == "nopassword") {
                // ...
                $this->load->view('view_no_password');
            }
            // Ansonsten (es gab keine Fehler)
			else {
                $query = $this->db->query('SELECT user FROM blockreich_users WHERE user="'.$username.'"');
                $result = $query->row();
                // Session mit Daten füllen, im UserGuide sind Sessions in CodeIgniter genau erklärt
                $this->session->set_userdata('logged_in', true);
                $this->session->set_userdata('username', $result->user);
                $this->Login_model->setLastLogin();
                
                // Zur Hauptseite weiterleiten, der Loginvorgang war ja erfolgeich ;)
                redirect('');
            }
		}
	}
}