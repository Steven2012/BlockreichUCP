<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Start extends CI_Controller {

	public function index()
	{		
        $this->load->model('Login_model');
        $data['user'] = $this->Login_model->getUserData($this->session->userdata('username'));
		$data['pagetitle'] = "Startseite";
        $this->load->view('view_start', $data);
	}
}