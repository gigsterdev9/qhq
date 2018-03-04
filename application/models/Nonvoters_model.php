<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class nonvoters_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}
        
    public function record_count() {
        return $this->db->count_all("non_voters");
    }

	public function get_nonvoters($limit = 0, $start = 0) {
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('non_voters');
		$this->db->where('trash = 0');
		$this->db->order_by('lname', 'ASC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();

		return $query->result_array();

	}

	public function get_nonvoter_by_id($id = FALSE) {
		if ($id === FALSE)
		{
			return 0;
		}
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('non_voters');
		$this->db->where("nv_id = '$id'"); //omit trash = 0 to be able to 'undo' trash one last time
		$query = $this->db->get();		

		return $query->row_array();
	}
	
	public function filter_nonvoters($limit, $start, $filter_param1 = FALSE, $filter_param2 = FALSE, $filter_operand = FALSE)
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
			$this->db->from('non_voters');
			$this->db->having("$conditions");
			$this->db->where("trash = 0");
			$query = $this->db->get();
			$result_count = $query->num_rows();
			
			$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(dob, '%Y-%m-%d'))/365)) as age");
			$this->db->from('non_voters');
			$this->db->having("$conditions");
			$this->db->where("trash = 0");
			$this->db->limit($limit, $start);
			$this->db->order_by('age, lname', 'ASC');
			$query = $this->db->get();		
		}
		else{
			$this->db->select('*');
			$this->db->from('non_voters');
			$this->db->where("$filter_param1 = '$filter_param2' and trash = 0");
			$query = $this->db->get();
			$result_count = $query->num_rows();
			
			$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(dob, '%Y-%m-%d'))/365)) as age");
			$this->db->from('non_voters');
			$this->db->where("$filter_param1 = '$filter_param2' and trash = 0");
			$this->db->limit($limit, $start);
			$this->db->order_by('lname', 'ASC');
			$query = $this->db->get();		
		}

		$result_array = $query->result_array();
		$result_array['result_count'] = $result_count;

		return $result_array;
		
	}
	
	public function search_nonvoters($limit, $start, $where_clause = false){
		
		//total possible results
		$this->db->select('*');
		$this->db->from('non_voters');

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
		$this->db->from('non_voters');
		
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
	
	
	public function get_recent_nonvoters($count_limit = 5)
	{
				
		$this->db->select('id, fname, lname');
		$this->db->from('non_voters');
		$this->db->where("trash = 0");
		$this->db->order_by('id', 'DESC');
		$this->db->limit($count_limit);
		$query = $this->db->get();		

		return $query->result_array();
	}
	
	public function find_nvoter_match($fname, $mname, $lname, $dob) {
		
		$this->db->select('*');
		$this->db->from('non_voters');
		$this->db->where("fname = '$fname' and mname = '$mname' and lname = '$lname' and dob = '$dob' and trash = 0");
		$this->db->order_by('nv_id', 'DESC');
		$query = $this->db->get();	

		//$str = $this->db->last_query(); echo $str; 
		return $query->result_array();
		
	}

	public function set_nonvoter() //new entry
	{
		$this->load->helper('url');
		
		$data = array(
				'code' => strtoupper($this->input->post('code')),
				'id_no' => strtoupper($this->input->post('id_no')),
				'fname' => $this->input->post('fname'),
				'mname' => $this->input->post('mname'),
				'lname' => $this->input->post('lname'),
				'dob' => $this->input->post('dob'),
				'address' => $this->input->post('address'),
				'barangay' => $this->input->post('barangay'),
				'district' => $this->input->post('district'),
				'sex' => $this->input->post('sex'),
				'mobile_no' => $this->input->post('mobile_no'),
				'email' => $this->input->post('email'),
				'referee' => $this->input->post('referee'),
				'nv_status' => $this->input->post('status'),
				'nv_remarks' => $this->input->post('remarks')
		);
		//insert new entry
		$this->db->insert('non_voters', $data);
		$nvid = $this->db->insert_id();
		
		//add to beneficiaries table
		$data1 = array(
					'nv_id' => $nvid
					);
		$this->db->insert('beneficiaries', $data1);

		//add audit trail
		$user = $this->ion_auth->user()->row();
		$data2 = array(
					'nv_id' => $nvid,
					'user' => $user->username,
					'activity' => 'created'
					);
		$this->db->insert('audit_trail', $data2);
		
		return;
	}
	
	
	//update individual voter
	public function update_nonvoter() {
		//echo '<pre>'; print_r($_POST); echo '</pre>'; die();
		$this->load->helper('url');
		
		$nv_id = $this->input->post('nv_id');
				
		
		$data = array(
				'code' => strtoupper($this->input->post('code')),
				'id_no' => strtoupper($this->input->post('id_no')),
				'fname' => $this->input->post('fname'),
				'mname' => $this->input->post('mname'),
				'lname' => $this->input->post('lname'),
				'dob' => $this->input->post('dob'),
				'address' => $this->input->post('address'),
				'barangay' => $this->input->post('barangay'),
				'district' => $this->input->post('district'),
				'sex' => $this->input->post('sex'),
				'mobile_no' => $this->input->post('mobile_no'),
				'email' => $this->input->post('email'),
				'referee' => $this->input->post('referee'),
				'nv_status' => $this->input->post('status'),
				'nv_remarks' => $this->input->post('remarks'),
				'trash' => $this->input->post('trash')
		);
		
		$this->db->where('nv_id', $nv_id);
		$this->db->update('non_voters', $data);
		
		//add audit trail
		$altered = $this->input->post('altered'); //hidden field that tracks form edits; see form
		if (strlen($altered) > 0) 
		{
			$user = $this->ion_auth->user()->row();
			$data3 = array(
						'nv_id' => $nv_id,
						'user' => $user->username,
						'activity' => 'modified',
						'mod_details' => $altered
			);
			$this->db->insert('audit_trail', $data3);
		}
		
		return;
	}

	// this is the original tracker that is based on the nv_id 
	// second option was to track based on the ben_id, but opted back to nv_id comes first before the ben_id
	public function show_activities($nv_id) {
		$this->db->select('*');
		$this->db->from('audit_trail');
		$this->db->order_by('timestamp', 'desc');
		$this->db->where("nv_id = '$nv_id' and activity = 'modified'");
		$this->db->limit(5);
		$query = $this->db->get();		
		
		$tracker['modified'] = $query->result_array();	
		
		$this->db->select('*');
		$this->db->from('audit_trail');
		$this->db->where("nv_id = '$nv_id' and activity = 'created'");
		$query = $this->db->get();		
		
		$tracker['created'] = $query->row_array();	
		
		return $tracker;
	}
	
	
}
