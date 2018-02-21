<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class services_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}
		
	public function record_count() {
        return $this->db->count_all("services");
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
					//echo '<pre>'; print_r($r); echo '</pre>'; 
					if ($r != '') {
						
						$x = $this->beneficiaries_model->get_beneficiary_by_id($r['req_ben_id']);
							$r['req_fname'] = $x['fname'];
							$r['req_mname'] = $x['mname'];
							$r['req_lname'] = $x['lname'];
						/*
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
						*/
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

	public function get_n_services($limit = 0, $start = 0) {
		
		$this->db->select('*');
		$this->db->from('beneficiaries');
		$this->db->where("nv_id != '' and trash = 0");
		//$this->db->limit($limit, $start); //we leave the limits to the r_services query as the row count for rvoters prevents this from displaying correctly
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

			if (isset($ns)) {
				
				foreach($ns as $n) {
					//echo '<pre>'; print_r($n); echo '</pre>'; 
					if ($n != '') {
						$x = $this->beneficiaries_model->get_beneficiary_by_id($n['req_ben_id']);
							$n['req_fname'] = $x['fname'];
							$n['req_mname'] = $x['mname'];
							$n['req_lname'] = $x['lname'];
						/*
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
						*/
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

	public function get_services_by_id($ben_id = FALSE) { //retrieve ALL records related to one beneficiary id  //note: there is a closely and similarly named function 

		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(r.dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('services s');
		$this->db->join('beneficiaries b', 'b.ben_id = s.ben_id');
		$this->db->join('rvoters r', 'r.id_no_comelec = b.id_no_comelec');
		$this->db->where("s.ben_id = '$ben_id'");
		$this->db->order_by('r.lname', 'ASC');
		$q = $this->db->get();
				
		$rs = $q->result_array();

		if (isset($rs)) {
			foreach($rs as $r) {
				//echo '<pre>'; print_r($r); echo '</pre>'; 
				if ($r != '') {
					//get requestor details
					$y = $this->beneficiaries_model->get_beneficiary_by_id($r['req_ben_id']);
						$r['req_fname'] = $y['fname'];
						$r['req_mname'] = $y['mname'];
						$r['req_lname'] = $y['lname'];
						$r['req_id'] = $y['id'];
					/*
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
						$r['req_nvid'] = $y['nv_id'];

					}
					else{
						return 0;
					}
					*/
				}
				$r_services[] = $r;
			}

			return $r_services; 
		}
		else{

			return 0;
		}

	}

	public function get_service_by_id($id = FALSE) { //retrieve service details by its own service id //note: there is a closely and similarly named function 
		if ($id === FALSE) {
			return 0; 
		}
		
		$this->db->select('*');
		$this->db->from('services s');
		$this->db->join('beneficiaries b', 'b.ben_id = s.ben_id');
		$this->db->where("service_id = '$id'"); //omit trash = 0 to be able to 'undo' trash one last time
		$query = $this->db->get();		

		$s = $query->row_array();
		
		if (isset($s)) {
			if ($s != '') {
					
					//echo '<pre>'; print_r($s); echo '</pre>';
					//get beneficiary details
					$x = $this->beneficiaries_model->get_beneficiary_by_id($s['ben_id']);
					$s = array_merge($s, $x);

					/*
					if ($s['nv_id'] == '' || $s['nv_id'] == NULL) {
						$x = $this->rvoters_model->get_rvoter_by_comelec_id($s['id_no_comelec']);
						//$s['fname'] = $x['fname'];
						//$s['lname'] = $x['lname'];
						//$s['id'] = $x['id'];
						$s = array_merge($s, $x);
						
					} 
					elseif($s['id_no_comelec'] == '' || $s['id_no_comelec'] == NULL) {
						$x = $this->nonvoters_model->get_nonvoter_by_id($s['nv_id']);
						//$s['fname'] = $x['fname'];
						//$s['lname'] = $x['lname'];
						$s = array_merge($s, $x);
					}
					else{
						return 0;
					}
					*/

					//get requestor details
					$y = $this->beneficiaries_model->get_beneficiary_by_id($s['req_ben_id']);
						$s['req_fname'] = $y['fname'];
						$s['req_mname'] = $y['mname'];
						$s['req_lname'] = $y['lname'];
						$s['req_id'] = $y['id'];
					/*
					if ($s['n_req_id'] == '' || $s['n_req_id'] == NULL) {
						$y = $this->rvoters_model->get_rvoter_by_comelec_id($s['r_req_id']);
						$s['req_fname'] = $y['fname'];
						$s['req_lname'] = $y['lname'];
						$s['req_id'] = $y['id'];
					} 
					elseif($s['r_req_id'] == '' || $s['n_req_id'] == NULL) {
						$y = $this->nonvoters_model->get_nonvoter_by_id($s['n_req_id']);
						$s['req_fname'] = $y['fname'];
						$s['req_lname'] = $y['lname'];
					}
					else{
						return 0;
					}
					*/
			}
			
			return $s; 
		}
		else{

			return 0;
		}

	}

	public function get_r_services_by_comelec_id($comelec_id = FALSE) { //retrieve all records related to one comelec id

		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(r.dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('services s');
		$this->db->join('beneficiaries b', 'b.ben_id = s.ben_id');
		$this->db->join('rvoters r', 'r.id_no_comelec = b.id_no_comelec');
		$this->db->where("b.id_no_comelec = '$comelec_id'");
		$q = $this->db->get();
				
		$rs = $q->result_array();
		
		if (empty($rs)) {
			return 0;
		}

		if (isset($rs)) {
			
			foreach($rs as $r) {
				//echo '<pre>'; print_r($r); echo '</pre>'; die();
				if ($r != '') {
					//$x = $this->beneficiaries_model->get_beneficiary_by_id($r['req_ben_id']);
					//	$r['req_fname'] = $x['fname'];
					//	$r['req_mname'] = $x['mname'];
					//	$r['req_lname'] = $x['lname'];
						
					/*
					if ($r['n_req_id'] == '' || $r['n_req_id'] == NULL) {
						$x = $this->rvoters_model->get_rvoter_by_comelec_id($r['r_req_id']);
						$r['req_fname'] = $x['fname'];
						$r['req_lname'] = $x['lname'];
						$r['req_id'] = $x['id'];
					} 
					elseif($r['r_req_id'] == '' || $r['r_req_id'] == NULL) {
						$y = $this->nonvoters_model->get_nonvoter_by_id($r['n_req_id']);
						$r['req_fname'] = $y['fname'];
						$r['req_lname'] = $y['lname'];
						$r['req_id'] = $y['nv_id'];
					}
					else{
						return 0;
					}
					*/
				}
				$r_services[] = $r;
			}

			return $r_services; 
		}
		else{

			return 0;
		}

	}

	public function get_n_services_by_nvid($nv_id = FALSE) { //retrieve all records related to one nv id
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(n.dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('services s');
		$this->db->join('beneficiaries b', 'b.ben_id = s.ben_id');
		$this->db->join('non_voters n', 'n.nv_id = b.nv_id');
		$this->db->where("b.nv_id = '$nv_id'");
		$q = $this->db->get();
				
		$ns = $q->result_array();
		
		if (empty($ns)) {
			return 0;
		}
		//echo '<pre>'; print_r($ns); echo '</pre>'; die();

		if (isset($ns)) {
			foreach($ns as $n) {
				
				if ($n != '') {
					
					$x = $this->beneficiaries_model->get_beneficiary_by_id($n['req_ben_id']);
							$n['req_fname'] = $x['fname'];
							$n['req_mname'] = $x['mname'];
							$n['req_lname'] = $x['lname'];
					
					/*
					if ($n['n_req_id'] == '' || $n['n_req_id'] == NULL) {
						$x = $this->rvoters_model->get_rvoter_by_comelec_id($n['r_req_id']);
						$n['req_fname'] = $x['fname'];
						$n['req_lname'] = $x['lname'];
						$n['req_id'] = $x['id'];
					} 
					elseif($n['r_req_id'] == '' || $n['r_req_id'] == NULL) {
						$y = $this->nonvoters_model->get_nonvoter_by_id($n['n_req_id']);
						$n['req_fname'] = $y['fname'];
						$n['req_lname'] = $y['lname'];
						$n['req_id'] = $y['nv_id'];
					}
					else{
						return 0;
					}
					*/
				}
				$n_services[] = $n;
			}

			return $n_services; 
		}
		else{

			return 0;
		}

	}

	public function filter_beneficiaries($limit, $start, $filter_param1 = FALSE, $filter_param2 = FALSE, $filter_operand = FALSE) {
		
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
	
	public function search_r_services($limit, $start, $where_clause = FALSE) { 
		if ($where_clause === FALSE) {
			return 0;
		}
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('rvoters r');
		$this->db->join('beneficiaries b', 'r.id_no_comelec = b.id_no_comelec');
		$this->db->where($where_clause);
		$this->db->limit($limit, $start);
		$this->db->order_by('lname', 'ASC');
		$query = $this->db->get();		
		$result1 = $query->result_array();
		
		foreach ($result1 as $r) {
			$ben_id = $r['ben_id'];
			$this->db->select('*');
			$this->db->from('services');
			$this->db->where("ben_id = '$ben_id'");
			$this->db->limit(1);
			$result2 = $this->db->get();
			
			if ($result2->num_rows() == 1) {
				$rs[] = array_merge($r, $result2->row_array());
			}
		}

		if (isset($rs)) {
			
			foreach($rs as $r) {
				
				if ($r != '') {
	
					$x = $this->beneficiaries_model->get_beneficiary_by_id($r['req_ben_id']);
						$r['req_fname'] = $x['fname'];
						$r['req_mname'] = $x['mname'];
						$r['req_lname'] = $x['lname'];
				}
				$r_services[] = $r;
			}
			return $r_services; 
		}
		else{
			return 0;
		}

	}
	
	public function search_n_services($limit, $start, $where_clause = FALSE) { 
		if ($where_clause === FALSE) {
			return 0;
		}
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('non_voters n');
		$this->db->join('beneficiaries b', 'n.nv_id = b.nv_id');
		$this->db->where($where_clause);
		$this->db->limit($limit, $start);
		$this->db->order_by('lname', 'ASC');
		$query = $this->db->get();		
		$result1 = $query->result_array();
		
		foreach ($result1 as $r) {
			$ben_id = $r['ben_id'];
			$this->db->select('*');
			$this->db->from('services');
			$this->db->where("ben_id = '$ben_id'");
			$this->db->limit(1);
			$result2 = $this->db->get();
			
			if ($result2->num_rows() == 1) {
				$ns[] = array_merge($r, $result2->row_array());
			}
		}

		if (isset($ns) > 0) {
			
			foreach($ns as $n) {
				
				if ($n != '') {
					
					$x = $this->beneficiaries_model->get_beneficiary_by_id($n['req_ben_id']);
						$n['req_fname'] = $x['fname'];
						$n['req_mname'] = $x['mname'];
						$n['req_lname'] = $x['lname'];
				}
				$n_services[] = $n;
			}
			return $n_services; 
		}
		else{
			return 0;
		}
	}
	
	public function get_recent_service_availments($count_limit = 5) {
				
		$this->db->select("service_id, fname, lname, s.ben_id, b.id_no_comelec, service_type");
		$this->db->from('services s');
		$this->db->join('beneficiaries b', 's.ben_id = b.ben_id');
		$this->db->join('rvoters r', 'r.id_no_comelec = b.id_no_comelec');
		$this->db->where("b.id_no_comelec != '' and r.trash = 0");
		$this->db->order_by('r.lname', 'ASC');
		$this->db->limit($count_limit, 0);
		$query = $this->db->get();

		$recent_availments['r'] = $query->result_array();

		$this->db->select("service_id, fname, lname, s.ben_id, service_type");
		$this->db->from('services s');
		$this->db->join('beneficiaries b', 's.ben_id = b.ben_id');
		$this->db->join('non_voters n', 'n.nv_id = b.nv_id');
		$this->db->where("b.nv_id != '' and n.trash = 0");
		$this->db->order_by('n.lname', 'ASC');
		$this->db->limit($count_limit, 0);
		$query = $this->db->get();

		$recent_availments['n'] = $query->result_array();

		return $recent_availments;

	}
	
	public function set_service() //new service
	{
		$this->load->helper('url');
		
		$data = array(
				'req_date' => $this->input->post('req_date'),
				'ben_id' => $this->input->post('ben_id'),
				'req_ben_id' => $this->input->post('req_ben_id'),
				'relationship' => $this->input->post('relationship'),
				'service_type' => $this->input->post('service_type'),
				'particulars' => $this->input->post('particulars'),
				'amount' => $this->input->post('amount'),
				's_status' => $this->input->post('s_status'),
				'action_officer' => $this->input->post('action_officer'),
				'recommendation' => $this->input->post('recommendation'),
				's_remarks' => $this->input->post('s_remarks'),
				'trash' => 0
		);
		//insert new voter
		$this->db->insert('services', $data);
		
		$rvid = $this->db->insert_id();
		//add audit trail
		$user = $this->ion_auth->user()->row();
		$data1 = array(
					'ben_id' => $rvid,
					'user' => $user->username,
					'activity' => 'service availment created'
		);
		$this->db->insert('audit_trail', $data1);
		
		return;
	}
	
	
	//update individual voter
	public function update_service() {
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
