<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class services_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}
		
	public function record_count() {
		
		$this->db->select('*');
		$this->db->from('services');
		$this->db->where("trash = 0");
        return $this->db->count_all_results();
    }

	public function get_r_services($limit = 0, $start = 0, $where_clause=FALSE) {
		
		$this->db->select('*');
		$this->db->from('services');
		if ($where_clause == FALSE) {
			$this->db->where("trash = 0");
		}
		else{
			$this->db->where("$where_clause and trash = 0");
		}
		$this->db->limit($limit, $start);
		$this->db->order_by('req_date', 'DESC');
		$query1 = $this->db->get();
		$result1 = $query1->result_array();

		if (is_array($result1)) {
			foreach ($result1 as $r1) {
				
				$ben_id = $r1['ben_id'];
				$req_ben_id = $r1['req_ben_id'];
				
				$ben = $this->beneficiaries_model->get_beneficiary_by_id($r1['ben_id']);
				$req = $this->beneficiaries_model->get_beneficiary_by_id($r1['req_ben_id']);
				
				if (isset($ben['id_no_comelec']) and ($ben['id_no_comelec'] != '')) {
					$r1['id_no_comelec'] = $ben['id_no_comelec'];
					$r1['fname'] = $ben['fname'];
					$r1['lname'] = $ben['lname'];
					$r1['mname'] = $ben['mname'];
					$r1['req_fname'] = $req['fname'];
					$r1['req_lname'] = $req['lname'];
					$r1['req_mname'] = $req['mname'];
					
					$r_services[] = $r1;
				}
				else{
					//do nothing
				}

			}
			
			if (!empty($r_services)) {
				return $r_services;
			}
			else{
				return 0;
			}

		}
		else {

			return 0;

		}
		
	}

	public function get_n_services($limit = 0, $start = 0, $where_clause=FALSE) {
		
		$this->db->select('*');
		$this->db->from('services');
		if ($where_clause == FALSE) {
			$this->db->where("trash = 0");
		}
		else{
			$this->db->where("$where_clause and trash = 0");
		}
		$this->db->limit($limit, $start);
		$this->db->order_by('req_date', 'DESC');
		$query1 = $this->db->get();
		$result1 = $query1->result_array();

		if (is_array($result1)) {
			foreach ($result1 as $r1) {
				
				$ben_id = $r1['ben_id'];
				$req_ben_id = $r1['req_ben_id'];
				
				$ben = $this->beneficiaries_model->get_beneficiary_by_id($r1['ben_id']);
				$req = $this->beneficiaries_model->get_beneficiary_by_id($r1['req_ben_id']);
				
				if (isset($ben['nv_id']) and ($ben['nv_id'] != '')) {
					$r1['nv_id'] = $ben['nv_id'];
					$r1['fname'] = $ben['fname'];
					$r1['lname'] = $ben['lname'];
					$r1['mname'] = $ben['mname'];
					$r1['req_fname'] = $req['fname'];
					$r1['req_lname'] = $req['lname'];
					$r1['req_mname'] = $req['mname'];
					
					$n_services[] = $r1;
				}
				else{
					//do nothing
				}
			}

			if (!empty($n_services)) {
				return $n_services;
			}
			else{
				return 0;
			}
		}
		else {
			return 0;
		}

	}

	public function get_services_by_id($ben_id = FALSE) { //retrieve ALL records related to one beneficiary id  //note: there is a closely and similarly named function 

		
		$this->db->select("*");
		$this->db->from('services s');
		$this->db->join('beneficiaries b', 'b.ben_id = s.ben_id');
		$this->db->where("s.ben_id = '$ben_id' and s.trash = '0'");
		$this->db->order_by('s.req_date', 'DESC');
		$q = $this->db->get();
				
		$rs = $q->result_array();

		//echo '<pre>'; print_r($rs); echo '</pre>'; 
		if (isset($rs)) {
			foreach($rs as $r) {
				
				if ($r != '') {
					//get requestor details
					$y = $this->beneficiaries_model->get_beneficiary_by_id($r['req_ben_id']);
						$r['req_fname'] = $y['fname'];
						$r['req_mname'] = $y['mname'];
						$r['req_lname'] = $y['lname'];
						//$r['req_id'] = $y['id'];
				}
				$r_services[] = $r;
			}
			if (!empty($r_services)) {
				return $r_services; 
			}
			else{

				return 0;
			}
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
		$this->db->where("s.service_id = '$id' and s.trash = '0'"); //omit trash = 0 to be able to 'undo' trash one last time?
		$query = $this->db->get();		

		$s = $query->row_array();
		
		if (isset($s)) {
			if ($s != '') {
					
					//get beneficiary details
					$x = $this->beneficiaries_model->get_beneficiary_by_id($s['ben_id']);
					$s = array_merge($s, $x);
					
					//get requestor details
					$y = $this->beneficiaries_model->get_beneficiary_by_id($s['req_ben_id']);
						$s['req_fname'] = $y['fname'];
						$s['req_mname'] = $y['mname'];
						$s['req_lname'] = $y['lname'];
					
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
		$this->db->where("b.id_no_comelec = '$comelec_id' and s.trash ='0'");
		$q = $this->db->get();
				
		$rs = $q->result_array();
		
		if (empty($rs)) {
			return 0;
		}

		if (isset($rs)) {
			
			foreach($rs as $r) {
				//echo '<pre>'; print_r($r); echo '</pre>'; die();
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

	public function get_n_services_by_nvid($nv_id = FALSE) { //retrieve all records related to one nv id
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(n.dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('services s');
		$this->db->join('beneficiaries b', 'b.ben_id = s.ben_id');
		$this->db->join('non_voters n', 'n.nv_id = b.nv_id');
		$this->db->where("b.nv_id = '$nv_id' and s.trash = '0'");
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
					
				}
				$n_services[] = $n;
			}

			return $n_services; 
		}
		else{

			return 0;
		}

	}

	public function filter_r_services($filter_param1 = FALSE, $filter_param2 = FALSE, $limit = 0, $start = 0) {
		
		if ($filter_param1 === FALSE) {
			return 0;
		}
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(rvoters.dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('services');
		$this->db->join('beneficiaries', 'beneficiaries.ben_id = services.ben_id');
		$this->db->join('rvoters', 'beneficiaries.id_no_comelec = rvoters.id_no_comelec');
		//$this->db->where("$filter_param1 = '$filter_param2' and beneficiaries.trash = 0");
		$this->db->limit($limit, $start);
		$query = $this->db->get();		
		$result1 =  $query->result_array();
		
		//echo $this->db->last_query(); die();

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

	public function filter_n_services($filter_param1 = FALSE, $filter_param2 = FALSE, $limit = 0, $start = 0) {
		
		if ($filter_param1 === FALSE) {
			return 0;
		}
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(non_voters.dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('services');
		$this->db->join('beneficiaries', 'beneficiaries.ben_id = services.ben_id');
		$this->db->join('non_voters', 'beneficiaries.nv_id = non_voters.nv_id');
		$this->db->where("$filter_param1 = '$filter_param2' and beneficiaries.trash = 0");
		$this->db->limit($limit, $start);
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
	
	public function search_r_services($limit, $start, $where_clause = FALSE) { 
		if ($where_clause === FALSE) {
			return 0;
		}
		//die($where_clause);
		
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
	
	public function set_service($data = NULL) { //new service
		$this->load->helper('url');
		
		if ($data == NULL) {
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
		}
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
	
	//check for dupes
	public function dupe_check($req_date = NULL, $ben_id = NULL, $service_type = NULL, $particulars = NULL, $amount = NULL) {
		
		if ($req_date == NULL || $ben_id == NULL || $service_type == NULL) {
			return 0;
		}

		$this->db->select("service_id");
		$this->db->from('services');
		$this->db->where("ben_id = '$ben_id' and req_date = '$req_date' and service_type = '$service_type' and particulars = '$particulars' and amount = '$amount' and trash = '0'");
		$query = $this->db->get();
		//echo $this->db->last_query();

		return $query->row_array();

	}
	
	//update service details
	public function update_service() {
		//echo '<pre>'; print_r($_POST); echo '</pre>'; die();
		$this->load->helper('url');
		
		$service_id = $this->input->post('service_id');
		$ben_id = $this->input->post('ben_id');		
		
		$data = array(
				'req_date'=> $this->input->post('req_date'),
				'ben_id' => $ben_id,
				'req_ben_id' => $this->input->post('req_ben_id'),
				'relationship' => $this->input->post('relationship'),
				'service_type' => $this->input->post('service_type'),
				'particulars' => $this->input->post('particulars'),
				'amount' => $this->input->post('amount'),
				's_status' => $this->input->post('s_status'),
				'action_officer' => $this->input->post('action_officer'),
				'recommendation' => $this->input->post('recommendation'),
				's_remarks' => $this->input->post('s_remarks'),
				//'trash' => $this->input->post('trash')
		);
		
		$this->db->where('service_id', $service_id);
		$this->db->update('services', $data);
		
		//add audit trail
		$altered = $this->input->post('altered'); //hidden field that tracks form edits; see form
		if (strlen($altered) > 0) 
		{
			$user = $this->ion_auth->user()->row();
			$data3 = array(
						'ben_id' => $ben_id,
						'service_id' => $service_id,
						'user' => $user->username,
						'activity' => 'modified',
						'mod_details' => $altered
			);
			$this->db->insert('audit_trail', $data3);
		}
		
		return;
	}

	public function trash_service($s_id = FALSE, $b_id = FALSE) {

		if ($s_id === FALSE || $b_id === FALSE) {
			return 0;
		}

		$data = array(
				'trash' => 1
			);
		
		$this->db->where('service_id', $s_id);
		$this->db->update('services', $data);

		//add audit trail
		$user = $this->ion_auth->user()->row();
		$data = array(
					'service_id' => $s_id,
					'ben_id' =>$b_id,
					'user' => $user->username,
					'activity' => 'modified',
					'mod_details' => 'trashed service record with ID '.$s_id
				);
		$this->db->insert('audit_trail', $data);
		
		return;
	}

	//use in dashboard charts
	public function get_by_servtype($type = false) {

		$this->db->select('*');
		$this->db->from('services');
		if ($type == false) {
			$this->db->where('1');
		}
		else{
			$this->db->where("service_type = '$type'");
		}
		$query = $this->db->get();

		return $query->result_array(); 

	}

	public function total_services_amount($year = null) {

		$this->db->select('sum(amount) as total');
		$this->db->from('services');
		if ($year == false) {
			$this->db->where('trash = 0');
		}
		else{
			$this->db->where("year(req_date) = '$year'");
		}
		$query = $this->db->get();
		//$last_query = $this->db->last_query();
		//die($last_query);

		return $query->row_array(); 

	}


	/*
	//removed and consolidated with other tracker db methods in tracker_model
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
	*/
	
}
