<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class services_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
    public function get_services() {
			
		$this->db->select('*');
		$this->db->from('services');
		$this->db->where('trash = 0');
		$this->db->order_by('lname', 'ASC');
		$query = $this->db->get();

		return $query->result_array();

	}
	
	
	public function get_service_by_id($id = FALSE)
	{
		if ($id === FALSE)
		{
			return 0;
		}
		
		$this->db->select('*');
		$this->db->from('services');
		$this->db->where("id = '$id'"); //omit trash = 0 to be able to 'undo' trash one last time
		$query = $this->db->get();		

		return $query->row_array();
	}
	
	
	public function filter_services($filter_param1 = FALSE, $filter_param2 = FALSE)
	{
		if ($filter_param1 === FALSE)
		{
			return 0;
		}
		
		$this->db->select('*');
		$this->db->from('services');
		$this->db->where("$filter_param1 = '$filter_param2' and trash = 0");
		$query = $this->db->get();		
		
		return $query->result_array();
		
	}
	
	public function search_services($search_param = FALSE)
	{
		if ($search_param === FALSE)
		{
			return 0;
		}
		
		$this->db->select('*');
		$this->db->from('services');
		$this->db->where("lname like '%$search_param%' or fname like '%$search_param%' and trash = 0");
		$query = $this->db->get();		

		return $query->result_array();
		
	}
	
	
	public function get_recent_services($count_limit = 5)
	{
				
		$this->db->select('id, fname, lname');
		$this->db->from('services');
		$this->db->where("trash = 0");
		$this->db->order_by('id', 'DESC');
		$this->db->limit($count_limit);
		$query = $this->db->get();		

		return $query->result_array();
	}
	
	public function set_service() //new voter
	{
		$this->load->helper('url');
		
		$data = array(
				'fname' => $this->input->post('fname'),
				'lname' => $this->input->post('lname'),
				'dob' => $this->input->post('dob'),
				'address' => $this->input->post('address'),
				'barangay' => $this->input->post('barangay'),
				'sex' => $this->input->post('sex'),
				'precinct' => $this->input->post('precinct'),
				'mobile_no' => $this->input->post('mobile_no'),
				'email' => $this->input->post('email'),
				'referee' => $this->input->post('referee'),
				'voters_id' => $this->input->post('voters_id'),
				'status' => $this->input->post('status'),
				'remarks' => $this->input->post('remarks')
		);
		//insert new voter
		$this->db->insert('services', $data);
		
		$rvid = $this->db->insert_id();
		
		//add audit trail
		$user = $this->ion_auth->user()->row();
		$data1 = array(
					'service_id' => $rvid,
					'user' => $user->username,
					'activity' => 'created'
		);
		$this->db->insert('audit_trail', $data1);
		
		return;
	}
	
	
	//update individual grant
	public function update_service($service_id = NULL) 
	{
		//echo '<pre>'; print_r($_POST); echo '</pre>'; die();
		$this->load->helper('url');
		
		$id = $this->input->post('id');
				
		
		$data = array(
				'fname' => $this->input->post('fname'),
				'lname' => $this->input->post('lname'),
				'dob' => $this->input->post('dob'),
				'address' => $this->input->post('address'),
				'barangay' => $this->input->post('barangay'),
				'sex' => $this->input->post('sex'),
				'precinct' => $this->input->post('precinct'),
				'mobile_no' => $this->input->post('mobile_no'),
				'email' => $this->input->post('email'),
				'referee' => $this->input->post('referee'),
				'voters_id' => $this->input->post('voters_id'),
				'status' => $this->input->post('status'),
				'remarks' => $this->input->post('remarks'),
				'trash' => $this->input->post('trash')
		);
		
		$this->db->where('id', $id);
		$this->db->update('services', $data);
		
		//add audit trail
		$altered = $this->input->post('altered'); //hidden field that tracks form edits; see form
		if (strlen($altered) > 0) 
		{
			$user = $this->ion_auth->user()->row();
			$data3 = array(
						'service_id' => $service_id,
						'user' => $user->username,
						'activity' => 'modified',
						'mod_details' => $altered
			);
			$this->db->insert('audit_trail', $data3);
		}
		
		return;
	}
	
}
