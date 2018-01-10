<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class beneficiaries_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}
        
    public function record_count() {
        return $this->db->count_all("beneficiaries");
    }

	public function get_beneficiaries($limit = 0, $start = 0) {
		
		$this->db->select("*");
		$this->db->from('beneficiaries');
		$this->db->where('trash = 0');
		$this->db->order_by('lname', 'ASC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();

		return $query->result_array();

	}

	public function get_beneficiary_by_id($id = FALSE)
	{
		if ($id === FALSE) {
			return 0; 
		}
		
		$this->db->select("*");
		$this->db->from('beneficiaries');
		$this->db->where("ben_id = '$id'"); //omit trash = 0 to be able to 'undo' trash one last time
		$query = $this->db->get();		

		return $query->row_array();
	}
	
	
	public function filter_beneficiaries($limit, $start, $filter_param1 = FALSE, $filter_param2 = FALSE, $filter_operand = FALSE)
	{
		if ($filter_param1 === FALSE)
		{
			return 0;
		}
		
		if ($filter_param1 == 'age') {
			switch ($filter_operand) {
				case 'above':
					$conditions = "age > '$filter_param2'";
					break;
				case 'below':
					$conditions = "age < '$filter_param2'";
					break;
				case 'between':
					$conditions = "age between $filter_param2";
					break;
				default:
					break;
			}

			$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(dob, '%Y-%m-%d'))/365)) as age");
			$this->db->from('beneficiaries');
			$this->db->having("$conditions");
			$this->db->where("trash = 0");
			$query = $this->db->get();
			$result_count = $query->num_rows();
			
			$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(dob, '%Y-%m-%d'))/365)) as age");
			$this->db->from('beneficiaries');
			$this->db->having("$conditions");
			$this->db->where("trash = 0");
			$this->db->limit($limit, $start);
			$this->db->order_by('age, lname', 'ASC');
			$query = $this->db->get();		
		}
		else{
			$this->db->select('*');
			$this->db->from('beneficiaries');
			$this->db->where("$filter_param1 = '$filter_param2' and trash = 0");
			$query = $this->db->get();
			$result_count = $query->num_rows();
			
			$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(dob, '%Y-%m-%d'))/365)) as age");
			$this->db->from('beneficiaries');
			$this->db->where("$filter_param1 = '$filter_param2' and trash = 0");
			$this->db->limit($limit, $start);
			$this->db->order_by('lname', 'ASC');
			$query = $this->db->get();		
		}

		$result_array = $query->result_array();
		$result_array['result_count'] = $result_count;

		return $result_array;
		
	}
	
	public function search_beneficiaries($limit, $start, $search_param = FALSE, $s_key = FALSE)
	{
		if ($search_param === FALSE or $s_key === FALSE)
		{
			return 0;
		}
		
		if (in_array('s_name', $s_key) && !in_array('s_address', $s_key)) {
			$where_clause = "lname like '%$search_param%' or fname like '%$search_param%' and trash = 0";
		}
		elseif (!in_array('s_name', $s_key) && in_array('s_address', $s_key)) {
			$where_clause = "address like '%$search_param%' and trash = 0";		
		}
		elseif (in_array('s_name', $s_key) && in_array('s_address', $s_key)) {
			$where_clause = "lname like '%$search_param%' or fname like '%$search_param%' or address like '%$search_param%' and trash = 0";
		}
		else{
			
		}

		$this->db->select('*');
		$this->db->from('beneficiaries');
		$this->db->where($where_clause);
		$query = $this->db->get();
		$result_count = $query->num_rows();
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('beneficiaries');
		$this->db->where($where_clause);
		$this->db->limit($limit, $start);
		$this->db->order_by('lname', 'ASC');
		$query = $this->db->get();		
		
		$result_array = $query->result_array();
		$result_array['result_count'] = $result_count;

		return $result_array;
		/*
		$this->db->select('*');
		$this->db->from('beneficiaries');
		$this->db->where("lname like '%$search_param%' or fname like '%$search_param%' and trash = 0");
		$query = $this->db->get();		

		return $query->result_array();
		*/

	}
	
	
	public function get_recent_beneficiaries($count_limit = 5)
	{
				
		$this->db->select('id, fname, lname');
		$this->db->from('beneficiaries');
		$this->db->where("trash = 0");
		$this->db->order_by('id', 'DESC');
		$this->db->limit($count_limit);
		$query = $this->db->get();		

		return $query->result_array();
	}
	
	public function set_beneficiary() //new voter
	{
		$this->load->helper('url');
		
		$data = array(
				'fname' => $this->input->post('fname'),
				'lname' => $this->input->post('lname'),
				'dob' => $this->input->post('dob'),
				'address' => $this->input->post('address'),
				'barangay' => $this->input->post('barangay'),
				'district' => $this->input->post('district'),
				'sex' => $this->input->post('sex'),
				'code' => $this->input->post('code'),
				'id_no' => $this->input->post('id_no'),
				'id_no_comelec' => $this->input->post('id_no_comelec'),
				'precinct' => $this->input->post('precinct'),
				'mobile_no' => $this->input->post('mobile_no'),
				'email' => $this->input->post('email'),
				'referee' => $this->input->post('referee'),
				//'voters_id' => $this->input->post('voters_id'),
				'status' => $this->input->post('status'),
				'remarks' => $this->input->post('remarks')
		);
		//insert new voter
		$this->db->insert('beneficiaries', $data);
		
		$rvid = $this->db->insert_id();
		
		//add audit trail
		$user = $this->ion_auth->user()->row();
		$data1 = array(
					'project_id' => $rvid,
					'user' => $user->username,
					'activity' => 'created'
		);
		$this->db->insert('audit_trail', $data1);
		
		return;
	}
	
	
	//update individual voter
	public function update_beneficiary() {
		//echo '<pre>'; print_r($_POST); echo '</pre>'; die();
		$this->load->helper('url');
		
		$id = $this->input->post('id');
				
		
		$data = array(
				'fname' => strtoupper($this->input->post('fname')),
				'lname' => strtoupper($this->input->post('lname')),
				'dob' => $this->input->post('dob'),
				'address' => $this->input->post('address'),
				'barangay' => $this->input->post('barangay'),
				'district' => $this->input->post('district'),
				'sex' => $this->input->post('sex'),
				'precinct' => $this->input->post('precinct'),
				'mobile_no' => $this->input->post('mobile_no'),
				'email' => $this->input->post('email'),
				'referee' => $this->input->post('referee'),
				//'voters_id' => $this->input->post('voters_id'),
				'status' => $this->input->post('status'),
				'remarks' => $this->input->post('remarks'),
				'trash' => $this->input->post('trash')
		);
		
		$this->db->where('id', $id);
		$this->db->update('beneficiaries', $data);
		
		//add audit trail
		$altered = $this->input->post('altered'); //hidden field that tracks form edits; see form
		if (strlen($altered) > 0) 
		{
			$user = $this->ion_auth->user()->row();
			$data3 = array(
						'beneficiary_id' => $id,
						'user' => $user->username,
						'activity' => 'modified',
						'mod_details' => $altered
			);
			$this->db->insert('audit_trail', $data3);
		}
		
		return;
	}

	public function show_activities($beneficiary_id) {
		$this->db->select('*');
		$this->db->from('audit_trail');
		$this->db->order_by('timestamp', 'desc');
		$this->db->where("beneficiary_id = '$beneficiary_id' and activity = 'modified'");
		$this->db->limit(5);
		$query = $this->db->get();		
		
		$tracker['modified'] = $query->result_array();	
		
		$this->db->select('*');
		$this->db->from('audit_trail');
		$this->db->where("beneficiary_id = '$beneficiary_id' and activity = 'created'");
		$query = $this->db->get();		
		
		$tracker['created'] = $query->row_array();	
		
		return $tracker;
	}

	
}
