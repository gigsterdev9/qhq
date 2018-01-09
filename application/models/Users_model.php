<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class users_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
   	public function get_users()
	{
		$this->db->select('*');
		$this->db->from('users as a');
		$this->db->join('users_groups as b', 'a.id = b.user_id');
		$this->db->join('groups as c', 'c.id = b.group_id');
		$this->db->order_by('a.username', 'ASC');
		$query = $this->db->get();		

		return $query->result_array();
	}
	
	
	public function get_user_by_id($id = FALSE)
	{
		if ($id === FALSE)
		{
			return 0;
		}
		
		$this->db->select('*');
		$this->db->from('users as a');
		$this->db->join('users_groups as b', 'a.id = b.user_id');
		$this->db->join('groups as c', 'c.id = b.group_id');
		$this->db->where("a.id = '$id'"); //omit trash = 0 to be able to 'undo' trash one last time
		$query = $this->db->get();		

		return $query->row_array();
	}
	
	public function update_users()
	{
	
	}
	
	
	public function search_users($search_param = FALSE)
	{
		if ($search_param === FALSE)
		{
			return 0;
		}
		
		$this->db->select('*');
		$this->db->from('projects as a');
		$this->db->join('proponents as b', 'b.proponent_id = a.proponent_id');
		$this->db->join('sgp5_sites as c', 'c.location_id = a.location_id');
		$this->db->where("project_title like '%$search_param%' and trash = 0");
		$query = $this->db->get();		

		return $query->result_array();
		
	}
	
}
