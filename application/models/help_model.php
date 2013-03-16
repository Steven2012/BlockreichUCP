<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Help_model extends CI_Model {
	
	public function getCommandList() {
        $query = $this->db->query("SELECT * FROM blockreich_commands");
        $result = $query->result();
        return $result;        
    }
    public function saveCmd($data) {
        $this->db->insert('blockreich_commands', $data);
        if ($this->db->affected_rows() == '1') return true;
        return false;
    }
    public function getFAQ() {
        $query = $this->db->query("SELECT * FROM blockreich_help_faq");
        $result = $query->result();
        return $result;
    }
    public function saveFAQ($data) {
        $this->db->insert('blockreich_help_faq', $data);
        if ($this->db->affected_rows() == '1') return true;
        return false;
    }
}
		
		

	