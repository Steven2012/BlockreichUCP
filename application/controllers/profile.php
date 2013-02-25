<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function index()
	{		
        $this->load->model('Login_model');
        $data['user'] = $this->Login_model->getUserData($this->session->userdata('username'));
        $data['ontime'] = $this->Login_model->getOnTime($this->session->userdata('username'));
		$data['pagetitle'] = "Profil bearbeiten";
        $this->load->view('view_profile', $data);
	}
	
	public function editEmail()
	{
        if($this->session->userdata('username') == false) {
            echo "error";
            die;
        }
        $email = $this->input->post('email');
        if (!preg_match( '/^([a-z0-9]+([-_\.]?[a-z0-9])+)@[a-z0-9הצü]+([-_\.]?[a-z0-9הצü])+\.[a-z]{2,4}$/i', $email)) {
            echo "unvalid email";
            die;
        }

        $data = array('email' => $email);

        $this->db->where('user', $this->session->userdata('username'));
        $this->db->update('blockreich_users', $data);
        
        echo "success";
    }
    public function editForumUsername()
	{
        if($this->session->userdata('username') == false) {
            echo "error";
            die;
        }
        
        $username = $this->input->post('username');

        $data = array('forum_username' => $username);

        $this->db->where('user', $this->session->userdata('username'));
        $this->db->update('blockreich_users', $data);

        echo "success";
    }
    
    public function editPublicmail()
    {
        if($this->session->userdata('username') == false) {
            echo "error";
            die;
        }
        
        $publicmail = $this->input->post('publicmail');

        if($publicmail == "on") $publicmail = 1;
        elseif($publicmail == "off") $publicmail = 0;
        else {
            echo "error";
            die;
        }
        
        /*if($publicmail != 0 and $publicmail != 1) {
            echo "error";
            die;
        }*/

        $data = array('publicmail' => $publicmail);

        $this->db->where('user', $this->session->userdata('username'));
        $this->db->update('blockreich_users', $data);

        echo "success";    
    }
    
    public function editMailmessages()
    {
        if($this->session->userdata('username') == false) {
            echo "error";
            die;
        }

        $mailmessages = $this->input->post('mailmessages');

        if($mailmessages == "on") $mailmessages = 1;
        elseif($mailmessages == "off") $mailmessages = 0;
        else {
            echo "error";
            die;
        }

        $data = array('mailmessages' => $mailmessages);

        $this->db->where('user', $this->session->userdata('username'));
        $this->db->update('blockreich_users', $data);

        echo "success";
    }
    
    public function editPublicamount()
    {
        if($this->session->userdata('username') == false) {
            echo "error";
            die;
        }

        $publicamount = $this->input->post('publicamount');

        if($publicamount == "on") $publicamount = 1;
        elseif($publicamount == "off") $publicamount = 0;
        else {
            echo "error";
            die;
        }

        $data = array('publicamount' => $publicamount);

        $this->db->where('user', $this->session->userdata('username'));
        $this->db->update('blockreich_users', $data);

        echo "success";
    }
}