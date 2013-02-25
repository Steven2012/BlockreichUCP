<?php 
/*
 * ZULETZT GEÄNDERT: Steven
 * Datum: 02.01.13 - 20:30
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('Login_model');
    }
    public function index()
	{
        if($this->permissions->checkPerm('userlist') == false) {
            show_error("Du hast keine Berechtigung diese Seite zu sehen.", 403);
        }
        $data['users'] = $this->Login_model->getUserList();
        $data['pagetitle'] = "Benutzerliste";
        $this->load->view('view_userlist', $data);    		
	}
	public function showprofile($username) {
        if($this->permissions->checkPerm('userprofile') == false) {
            show_error("Du hast keine Berechtigung diese Seite zu sehen.", 403);
        }
        $data['user'] = $this->Login_model->getUserData($username);
        if($data['user'] == false) {
            echo "Der angegebene Benutzer wurde nicht gefunden!";
            die;
        }
        $data['ontime'] = $this->Login_model->getOnTime($username);
		$data['pagetitle'] = "Profil von ".$username;
        $this->load->view('view_profile_single', $data);
    }
}