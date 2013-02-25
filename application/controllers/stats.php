<?php 
/*
 * ZULETZT GEÄNDERT: Steven
 * Datum: 31.12.12 - 15:36
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stats extends CI_Controller {

	public function index()
	{		
        $this->load->model('Stats_model');
		$data['pagetitle'] = "Statistiken";
        // $this->load->view('view_stats', $data);
	}
	public function ontime()
	{
	   $this->load->model('Stats_model');
       $data['topall'] = $this->Stats_model->getOntimeStats("all");   
       $data['toptoday'] = $this->Stats_model->getOntimeStats("today");   
       $data['topweek'] = $this->Stats_model->getOntimeStats("week");   
       $data['topmonth'] = $this->Stats_model->getOntimeStats("month");
       $data['pagetitle'] = "Onlinezeit - Statistiken";
       $this->load->view('view_stats_toplist', $data);   
    }
}