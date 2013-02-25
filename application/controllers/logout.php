<?php
/*
 * ZULETZT GEÄNDERT: Steven
 * Datum: 29.12.12 - Abends (genaue Uhrzeit nicht mehr bekannt)
 */
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function index()
	{
	   $this->session->sess_destroy();
       redirect('login');	
	}
}