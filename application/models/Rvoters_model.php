<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class rvoters_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
    public function record_count() {
		$this->db->where('trash = 0');
        return $this->db->count_all_results('rvoters');
    }

	public function get_rvoters($limit = 0, $start = 0) {
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('rvoters');
		$this->db->where('trash = 0');
		$this->db->order_by('lname', 'ASC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();

		return $query->result_array();

	}

	public function get_rvoter_by_id($id = FALSE)
	{
		if ($id === FALSE) {
			return 0;
		}
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('rvoters');
		$this->db->where("id = '$id'"); //omit trash = 0 to be able to 'undo' trash one last time
		$query = $this->db->get();		

		return $query->row_array();
	}
	
	public function get_rvoter_by_comelec_id($id = FALSE, $include_trashed = TRUE) {
		
		if ($id === FALSE) {
			return 0;
		}
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('rvoters');
		if ($include_trashed === TRUE) {
			$this->db->where("id_no_comelec = '$id'"); //omit trash = 0 to be able to 'undo' trash one last time
		}
		else{
			$this->db->where("id_no_comelec = '$id' and trash = 0"); 
		}
		$query = $this->db->get();		

		return $query->row_array();
	}
	
	public function filter_rvoters($limit, $start, $filter_param1 = FALSE, $filter_param2 = FALSE, $filter_operand = FALSE)
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
			$this->db->from('rvoters');
			$this->db->having("$conditions");
			$this->db->where("trash = 0");
			$query = $this->db->get();
			$result_count = $query->num_rows();
			
			$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(dob, '%Y-%m-%d'))/365)) as age");
			$this->db->from('rvoters');
			$this->db->having("$conditions");
			$this->db->where("trash = 0");
			$this->db->limit($limit, $start);
			$this->db->order_by('age, lname', 'ASC');
			$query = $this->db->get();		
		}
		else{
			$this->db->select('*');
			$this->db->from('rvoters');
			$this->db->where("$filter_param1 = '$filter_param2' and trash = 0");
			$query = $this->db->get();
			$result_count = $query->num_rows();
			
			$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(dob, '%Y-%m-%d'))/365)) as age");
			$this->db->from('rvoters');
			$this->db->where("$filter_param1 = '$filter_param2' and trash = 0");
			$this->db->limit($limit, $start);
			$this->db->order_by('lname', 'ASC');
			$query = $this->db->get();		
		}

		$result_array = $query->result_array();
		$result_array['result_count'] = $result_count;

		return $result_array;
		
	}
	
	public function search_rvoters($limit, $start, $where_clause = false) {
		
		//total possible results
		$this->db->select('*');
		$this->db->from('rvoters');

		if ($where_clause === false) {
			$this->db->where('trash = 0');
		}
		else{
			$this->db->where($where_clause);
		}
		$query = $this->db->get();
		$result_count = $query->num_rows();
		
		//results bounded by limits
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('rvoters');
		
		if ($where_clause === false) {
			$this->db->where('trash = 0');
		}
		else{
			$this->db->where($where_clause);
		}
		$this->db->limit($limit, $start);
		$this->db->order_by('lname', 'ASC');
		$query = $this->db->get();		
		
		$result_array = $query->result_array();
		$result_array['result_count'] = $result_count;

		return $result_array;
		
	}
	
	
	public function get_recent_rvoters($count_limit = 5)
	{
				
		$this->db->select('id, fname, lname');
		$this->db->from('rvoters');
		$this->db->where("trash = 0");
		$this->db->order_by('id', 'DESC');
		$this->db->limit($count_limit);
		$query = $this->db->get();		

		return $query->result_array();
	}

	public function find_rvoter_match($fname, $mname, $lname, $dob) {
		
		$this->db->select('*');
		$this->db->from('rvoters');
		$this->db->where("fname = '$fname' and mname = '$mname' and lname = '$lname' and dob = '$dob' and trash = 0");
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get();	

		//$str = $this->db->last_query(); echo $str; 
		return $query->result_array();
		//var_dump(get_object_vars($query)); die();
		
	}
	
	public function set_rvoter($data = false) //new voter
	{
		$this->load->helper('url');
        
        if ($data == false) {
            $data = array(
                'fname' => $this->input->post('fname'),
                'mname' => $this->input->post('mname'),
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
                'status' => $this->input->post('status'),
                'remarks' => $this->input->post('remarks')
            );
        } 
		//insert new voter
		$this->db->insert('rvoters', $data);
		
		$rvid = $this->db->insert_id();
		
		//add audit trail
		$user = $this->ion_auth->user()->row();
		$data1 = array(
					'id_no_comelec' => $this->input->post('id_no_comelec'),
					'user' => $user->username,
					'activity' => 'created'
		);
		$this->db->insert('audit_trail', $data1);
		
		return;
	}
	
	
	//update individual voter
	public function update_rvoter() {
		//echo '<pre>'; print_r($_POST); echo '</pre>'; die();
		$this->load->helper('url');
		
		$id = $this->input->post('id');
				
		
		$data = array(
				'fname' => $this->input->post('fname'),
				'mname' => $this->input->post('mname'),
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
				'status' => $this->input->post('status'),
				'remarks' => $this->input->post('remarks'),
				'trash' => $this->input->post('trash')
		);
		
		$this->db->where('id', $id);
		$this->db->update('rvoters', $data);
		
		//add audit trail
		$altered = $this->input->post('altered'); //hidden field that tracks form edits; see form
		if (strlen($altered) > 0) 
		{
			$user = $this->ion_auth->user()->row();
			$data3 = array(
						'id_no_comelec' => $this->input->post('id_no_comelec'),
						'user' => $user->username,
						'activity' => 'modified',
						'mod_details' => $altered
			);
			$this->db->insert('audit_trail', $data3);
		}
		
		return;
	}

	/*
	//removed and consolidated with other tracker db methods in tracker_model
	public function show_activities($id_no_comelec) {
		$this->db->select('*');
		$this->db->from('audit_trail');
		$this->db->order_by('timestamp', 'desc');
		$this->db->where("id_no_comelec = '$id_no_comelec' and activity = 'modified'");
		$this->db->limit(5);
		$query = $this->db->get();		
		
		$tracker['modified'] = $query->result_array();	
		
		$this->db->select('*');
		$this->db->from('audit_trail');
		$this->db->where("id_no_comelec = '$id_no_comelec' and activity = 'created'");
		$query = $this->db->get();		
		
		$tracker['created'] = $query->row_array();	
		
		return $tracker;
	}
	*/
	
}
