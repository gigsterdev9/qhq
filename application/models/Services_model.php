<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class services_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}
        
    public function record_count() {
        return $this->db->count_all("services");
    }

	public function get_n_services($limit = 0, $start = 0) {
		
		$this->db->select('*');
		$this->db->from('beneficiaries');
		$this->db->where("nv_id != '' and trash = 0");
		//$this->db->limit($limit, $start);
		$query1 = $this->db->get();
		$result1 = $query1->result_array();

		//echo '<pre>'; print_r($result1); echo '</pre>'; die();
		if (is_array($result1)) {
			foreach ($result1 as $r1) {
				
				$ben_id = $r1['ben_id'];
				
				$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(n.dob, '%Y-%m-%d'))/365)) as age");
				$this->db->from('services s');
				$this->db->join('beneficiaries b', 'b.ben_id = s.ben_id');
				$this->db->join('non_voters n', 'n.nv_id = b.nv_id');
				$this->db->where("s.ben_id = '$ben_id'");
				$this->db->order_by('n.lname', 'ASC');
				$q = $this->db->get();
				
				$ns[] = $q->row_array(); 
			}

			//echo '<pre>'; print_r($n_services); echo '</pre>'; die();
			if (isset($ns)) {
				
				foreach($ns as $n) {
					//echo '<pre>'; print_r($n); echo '</pre>'; 
					if ($n != '') {
						if ($n['n_req_id'] == '' || $n['n_req_id'] == NULL) {
							$x = $this->rvoters_model->get_rvoter_by_comelec_id($n['r_req_id']);
							$n['req_fname'] = $x['fname'];
							$n['req_lname'] = $x['lname'];
							$n['req_id'] = $x['id'];
						} 
						elseif($n['r_req_id'] == '' || $n['n_req_id'] == NULL) {
							$y = $this->nonvoters_model->get_nonvoter_by_id($n['n_req_id']);
							$n['req_fname'] = $y['fname'];
							$n['req_lname'] = $y['lname'];
						}
						else{
							return 0;
						}
					}
					$n_services[] = $n;
				}
				
				//return $ns; 
				return $n_services; 
			}
			return 0;
		}
		else {
			return 0;
		}

	}

	public function get_r_services($limit = 0, $start = 0) {
		
		$this->db->select('*');
		$this->db->from('beneficiaries');
		$this->db->where("id_no_comelec != '' and trash = 0");
		$this->db->limit($limit, $start);
		$query1 = $this->db->get();
		$result1 = $query1->result_array();

		if (is_array($result1)) {
			foreach ($result1 as $r1) {
				
				$ben_id = $r1['ben_id'];
				
				$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(r.dob, '%Y-%m-%d'))/365)) as age");
				$this->db->from('services s');
				$this->db->join('beneficiaries b', 'b.ben_id = s.ben_id');
				$this->db->join('rvoters r', 'r.id_no_comelec = b.id_no_comelec');
				$this->db->where("s.ben_id = '$ben_id'");
				$this->db->order_by('r.lname', 'ASC');
				$q = $this->db->get();
				
				$rs[] = $q->row_array();
			}

			if (isset($rs)) {
				foreach($rs as $r) {
					//echo '<pre>'; print_r($n); echo '</pre>'; 
					if ($r != '') {
						if ($r['n_req_id'] == '' || $r['n_req_id'] == NULL) {
							$x = $this->rvoters_model->get_rvoter_by_comelec_id($r['r_req_id']);
							$r['req_fname'] = $x['fname'];
							$r['req_lname'] = $x['lname'];
							$r['req_id'] = $x['id'];
						} 
						elseif($r['r_req_id'] == '' || $r['n_req_id'] == NULL) {
							$y = $this->nonvoters_model->get_nonvoter_by_id($r['n_req_id']);
							$r['req_fname'] = $y['fname'];
							$r['req_lname'] = $y['lname'];
						}
						else{
							return 0;
						}
					}
					$r_services[] = $r;
				}

				return $r_services; 
			}
			return 0;
		}
		else {
			return 0;
		}

	}


	public function get_service_by_id($id = FALSE)
	{
		if ($id === FALSE) {
			return 0; 
		}
		
		$this->db->select("*");
		$this->db->from('services');
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
