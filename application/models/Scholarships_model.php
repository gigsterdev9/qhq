<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class scholarships_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function record_count() { //count all scholarship records
	   
		//return $this->db->count_all("scholarships");
		$this->db->select('*');
		$this->db->from('scholarships');
		$this->db->where("trash = 0");
        return $this->db->count_all_results();
	}
	
	public function get_n_scholarships($limit = 0, $start = 0) { //list all scholarships for non voters
		
		/*
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(n.dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('scholarships s');
		$this->db->join('beneficiaries b', 's.ben_id = b.ben_id');
		$this->db->join('non_voters n', 'n.nv_id = b.nv_id');
		$this->db->join('schools', 's.school_id = schools.school_id');
		$this->db->where('n.trash = 0');
		$this->db->order_by('n.lname', 'ASC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		$result = $query->result_array();

		return $result;
		*/

		$this->db->select('*');
		$this->db->from('beneficiaries');
		$this->db->where("nv_id != '' and trash = '0'");
		$this->db->limit($limit, $start);
		$query1 = $this->db->get();
		$result1 = $query1->result_array();

		//echo '<pre>'; print_r($result1); echo '</pre>'; die();
		//echo count($result1); die();
		if (is_array($result1)) {
			foreach ($result1 as $r1) {
				
				$ben_id = $r1['ben_id'];
				
				$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(n.dob, '%Y-%m-%d'))/365)) as age");
				$this->db->from('scholarships s');
				$this->db->join('beneficiaries b', 'b.ben_id = s.ben_id');
				$this->db->join('non_voters n', 'n.nv_id = b.nv_id');
				$this->db->join('schools sc', 'sc.school_id = s.school_id');
				$this->db->where("s.ben_id = '$ben_id' and n.trash = 0");
				$this->db->order_by('n.lname', 'ASC');
				$q = $this->db->get();
				$result = $q->row_array();
				
				if (is_array($result)) {
					$n_scholarships[] = $result;
				}
			}
			//echo count($n_scholarships); die();
			if (isset($n_scholarships)) {
				/*
				$ctr = 1;
				foreach ($n_scholarships as $n) {
					if ($ctr != $n['ben_id']) echo '*';
					echo $ctr .") \t". $n['ben_id'] ."\t". $n['scholarship_id'] ."\t". $n['nv_id'] ."<br />";
					$ctr++;
				}
				*/
				return $n_scholarships; 
			}
			else{
				return 0;
			}

		}
		else {
			return 0;
		}


	}

	public function get_r_scholarships($limit = 0, $start = 0) { //list all scholarships for registered voters
		
		$this->db->select('*');
		$this->db->from('beneficiaries');
		$this->db->where("id_no_comelec != '' and trash = '0'");
		$this->db->limit($limit, $start);
		$query1 = $this->db->get();
		$result1 = $query1->result_array();

		if (is_array($result1)) {
			foreach ($result1 as $r1) {
				
				$ben_id = $r1['ben_id'];
				
				$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(r.dob, '%Y-%m-%d'))/365)) as age");
				$this->db->from('scholarships s');
				$this->db->join('beneficiaries b', 'b.ben_id = s.ben_id');
				$this->db->join('rvoters r', 'r.id_no_comelec = b.id_no_comelec');
				$this->db->join('schools sc', 'sc.school_id = s.school_id');
				$this->db->where("s.ben_id = '$ben_id' and r.trash = 0 ");
				$this->db->order_by('r.lname', 'ASC');
				$q = $this->db->get();
				$result = $q->row_array();
				
				if (is_array($result)) {
					$r_scholarships[] = $result;
				}
			}

			if (isset($r_scholarships)) {
				//echo '<pre>'; print_r($r_scholarships); echo '</pre>'; die();
				return $r_scholarships; 
			}
			else{
				return 0;
			}

		}
		else {
			return 0;
		}
	}

	public function get_scholarship_by_id($id = FALSE, $flag = FALSE) { //scholarship details without the joins yet
		if ($id === FALSE) {
			return 0;
		}
		
		$this->db->select('*');
		$this->db->from('scholarships s');
		$this->db->join('beneficiaries b', 's.ben_id = b.ben_id');
		$this->db->where("s.scholarship_id = '$id'"); //omit trash = 0 to be able to 'undo' trash one last time
		$query = $this->db->get();		

		return $query->row_array();
	}

	public function get_r_scholarship_by_id($id = FALSE) { //retrieve record for one registered voter scholarship 
		if ($id === FALSE) {
			return 0;
		}
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(r.dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('scholarships s');
		$this->db->join('beneficiaries b', 's.ben_id = b.ben_id');
		$this->db->join('rvoters r', 'r.id_no_comelec = b.id_no_comelec');
		$this->db->join('schools', 's.school_id = schools.school_id');
		$this->db->where("s.scholarship_id = '$id' and r.trash = 0"); //omit trash = 0 to be able to 'undo' trash one last time
		$query = $this->db->get();

		//echo $this->db->last_query();
		return $query->row_array(); //nv_id column has unique attrib
	}


	public function get_r_scholarships_by_id($id = FALSE) { //retrieve all scholarship records related to one registered voter
		if ($id === FALSE) {
			return 0;
		}
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(r.dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('scholarships s');
		$this->db->join('beneficiaries b', 's.ben_id = b.ben_id');
		$this->db->join('rvoters r', 'r.id_no_comelec = b.id_no_comelec');
		$this->db->join('schools', 's.school_id = schools.school_id');
		$this->db->where("r.id_no_comelec = '$id'"); //omit trash = 0 to be able to 'undo' trash one last time
		$query = $this->db->get();

		//echo $this->db->last_query();
		return $query->result_array(); //nv_id column has unique attrib

	}

	public function get_n_scholarships_by_id($id = FALSE) { //retrieve all scholarship records related to one non voter
		if ($id === FALSE) {
			return 0;
		}
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(n.dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('scholarships s');
		$this->db->join('beneficiaries b', 's.ben_id = b.ben_id');
		$this->db->join('non_voters n', 'n.nv_id = b.nv_id');
		$this->db->join('schools', 's.school_id = schools.school_id');
		$this->db->where("n.nv_id = '$id'"); //omit trash = 0 to be able to 'undo' trash one last time
		$query = $this->db->get();

		//echo $this->db->last_query();
		return $query->result_array(); //nv_id column has unique attrib
	}
	
	public function get_scholarship_by_comid($id = FALSE) { //retrieve record for one registered voter using id_no_comelec
		if ($id === FALSE) {
			return 0;
		}
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(r.dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('scholarships s');
		$this->db->join('beneficiaries b', 's.ben_id = b.ben_id');
		$this->db->join('rvoters r', 'r.id_no_comelec = b.id_no_comelec');
		$this->db->join('schools', 's.school_id = schools.school_id');
		$this->db->where("r.id_no_comelec = '$id'"); //omit trash = 0 to be able to 'undo' trash one last time
		$query = $this->db->get();

		//echo $this->db->last_query();
		return $query->row_array(); //nv_id column has unique attrib
	}
	
	public function get_n_scholarship_by_id($id = FALSE) { //retrieve record for one non voter scholarship 
		if ($id === FALSE) {
			return 0;
		}

		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(n.dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('scholarships s');
		$this->db->join('beneficiaries b', 's.ben_id = b.ben_id');
		$this->db->join('non_voters n', 'n.nv_id = b.nv_id');
		$this->db->join('schools', 's.school_id = schools.school_id');
		$this->db->where("s.scholarship_id = '$id'"); //omit trash = 0 to be able to 'undo' trash one last time
		$query = $this->db->get();

		//echo $this->db->last_query();
		return $query->row_array(); //nv_id column has unique attrib
	}

	public function get_scholarship_by_ben_id($id = FALSE, $flag = FALSE) { //retrieve scholarship record using ben_id
		if ($id === FALSE || $flag === FALSE) {
			return 0;
		}

		$this->db->select('*');
		$this->db->from('beneficiaries');
		$this->db->join('scholarships','scholarships.ben_id = beneficiaries.ben_id');
		if ($flag == 'n') {
			$this->db->join('non_voters','beneficiaries.nv_id = non_voters.nv_id');
		}
		elseif ($flag == 'r') {
			$this->db->join('rvoters', 'beneficiaries.id_no_comelec = rvoters.id_no_comelec');
		}
		else { 
			//nothing
		}
		$this->db->where("beneficiaries.ben_id = '$id'");
		$query = $this->db->get();

		//echo $this->db->last_query();
		return $query->row_array();

	}

	public function get_term_details($id = FALSE) { //retrieve related scholarship term details
		
		if ($id === FALSE)
		{
			return 0;
		}

		$this->db->select('*');
		$this->db->from('scholarships_term_details');
		$this->db->where("scholarship_id = '$id' and trash = 0");
		$query = $this->db->get();

		return $query->result_array();
	} 

	
	public function get_single_term_details($id = FALSE) { //retrieve individual scholarship term details
		
		if ($id === FALSE)
		{
			return 0;
		}

		$this->db->select('*');
		$this->db->from('scholarships_term_details');
		$this->db->where("term_id = '$id' and trash = 0");
		$query = $this->db->get();

		return $query->row_array();
	}

	
	public function get_schools() {

		$this->db->select('*');
		$this->db->from('schools');
		$query = $this->db->get();		

		return $query->result_array();
	
	}

	public function filter_r_scholarships($filter_param1 = FALSE, $filter_param2 = FALSE, $limit = 0, $start = 0) {
		if ($filter_param1 === FALSE)
		{
			return 0;
		}
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(rvoters.dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('scholarships');
		$this->db->join('beneficiaries', 'beneficiaries.ben_id = scholarships.ben_id');
		$this->db->join('rvoters', 'beneficiaries.id_no_comelec = rvoters.id_no_comelec');
		$this->db->join('schools', 'scholarships.school_id = schools.school_id');
		$this->db->where("$filter_param1 = '$filter_param2' and beneficiaries.trash = 0");
		$this->db->limit($limit, $start);
		$query = $this->db->get();		
		
		//return $query;
		return $query->result_array();
		
	}

	public function filter_n_scholarships($filter_param1 = FALSE, $filter_param2 = FALSE, $limit = 0, $start = 0) {
		if ($filter_param1 === FALSE)
		{
			return 0;
		}
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(non_voters.dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('scholarships');
		$this->db->join('beneficiaries', 'beneficiaries.ben_id = scholarships.ben_id');
		$this->db->join('non_voters', 'beneficiaries.nv_id = non_voters.nv_id');
		$this->db->join('schools', 'scholarships.school_id = schools.school_id');
		$this->db->where("$filter_param1 = '$filter_param2' and beneficiaries.trash = 0");
		$this->db->limit($limit, $start);
		$query = $this->db->get();		
		
		//return $query;
		return $query->result_array();
		
	}
	
	public function search_r_scholarships($limit, $start, $where_clause = FALSE) { 
		if ($where_clause === FALSE) {
			return 0;
		}
		$where_clause .= ' and (rvoters.trash = 0 and beneficiaries.trash = 0) ';
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('rvoters');
		$this->db->join('beneficiaries', 'rvoters.id_no_comelec = beneficiaries.id_no_comelec');
		$this->db->where($where_clause);
		$this->db->limit($limit, $start);
		$this->db->order_by('lname', 'ASC');
		$query = $this->db->get();		
		$result1 = $query->result_array();
		
		foreach ($result1 as $r) {
			$ben_id = $r['ben_id'];
			$this->db->select('*');
			$this->db->from('scholarships s');
			$this->db->join('schools', 's.school_id = schools.school_id');
			$this->db->where("ben_id = '$ben_id'");
			$this->db->limit(1);
			$result2 = $this->db->get();
			
			if ($result2->num_rows() == 1) {
				$rs[] = array_merge($r, $result2->row_array());
			}
		}

		if ((isset($rs)) && (count($rs) > 0)) {
			
			return $rs;
		}
		else{
			
			return 0;
		}

	}
	
	public function search_n_scholarships($limit, $start, $where_clause = FALSE) { 
		if ($where_clause === FALSE) {
			return 0;
		}
		$where_clause .= ' and (non_voters.trash = 0 and beneficiaries.trash = 0) ';
		//die($where_clause);

		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('non_voters');
		$this->db->join('beneficiaries', 'non_voters.nv_id = beneficiaries.nv_id');
		$this->db->where($where_clause);
		$this->db->limit($limit, $start);
		$this->db->order_by('lname', 'ASC');
		$query = $this->db->get();		
		$result1 = $query->result_array();
		
		foreach ($result1 as $r) {
			$ben_id = $r['ben_id'];
			$this->db->select('*');
			$this->db->from('scholarships s');
			$this->db->join('schools', 's.school_id = schools.school_id');
			$this->db->where("ben_id = '$ben_id'");
			$this->db->limit(1);
			$result2 = $this->db->get();
			
			if ($result2->num_rows() == 1) {
				$ns[] = array_merge($r, $result2->row_array());
			}
		}

		if ((isset($ns)) && (count($ns) > 0)) {
			/*
			foreach($ns as $n) {
				
				if ($n != '') {
					
					$x = $this->beneficiaries_model->get_beneficiary_by_id($n['req_ben_id']);
						$n['req_fname'] = $x['fname'];
						$n['req_mname'] = $x['mname'];
						$n['req_lname'] = $x['lname'];
				}
				$n_scholarships[] = $n;
			}
			return $n_scholarships; 
			*/
			return $ns;
		}
		else{
			return 0;
		}
	}
	
	
	public function get_recent_scholars($count_limit = 5)
	{
				
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(non_voters.dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('scholarships');
		$this->db->join('beneficiaries', 'scholarships.ben_id = beneficiaries.ben_id');
		$this->db->join('non_voters', 'non_voters.nv_id = beneficiaries.nv_id');
		$this->db->order_by('scholarships.scholarship_id', 'DESC');
		$this->db->limit($count_limit);
		$query = $this->db->get();		

		return $query->result_array();
	}
	
	public function set_scholarship() { //new scholarship
	
		$this->load->helper('url');
		

		if ($this->input->post('optradio') != null) {
			$new_id = explode('|', $this->input->post('optradio'));
			switch ($new_id[0]) {
				case 'id_no_comelec':
					$id_no_comelec = $new_id[1];
					$nv_id = '';
					break;
				case 'nv_id':
					$id_no_comelec = '';
					$nv_id = $new_id[1];
					break;
				default:
					//nothing
					break;
			}
		}
		else{
			$id_no_comelec = $this->input->post('id_no_comelec');
			$nv_id = $this->input->post('nv_id');
		}
		
		$trash = ( $this->input->post('trash') !== null )  ? $this->input->post('trash') : 0 ;
		
		//check if id already exists in beneficiary table 
		$this->db->select('*');
		$this->db->from('beneficiaries');
		$this->db->where("$new_id[0]", "$new_id[1]");
		$query = $this->db->get();

		$result = $query->result_array();
		$id_exists = count($result);
		//echo '<pre>'; print_r($result); echo '</pre>';
		
		if ($id_exists == 0) { //only create record in beneficiary table when 

			//prep data for beneficiary table
			$data = array(
					//'id_no_comelec' => $id_no_comelec,
					//'nv_id' => $nv_id,
					$new_id[0] => $new_id[1],	
					'trash' => $trash
			);

			//insert new beneficiary
			$this->db->insert('beneficiaries', $data);
			//grab newly created ben_id
			$ben_id = $this->db->insert_id();
		
		}
		else{
			$ben_id = $result['ben_id'];
		}

		//prep data for scholarship table
		$data = array(
				'ben_id' => $ben_id,
				'batch' => $this->input->post('batch'),
				'school_id' => $this->input->post('school_id'),
				'course' => $this->input->post('course'),
				'major' => $this->input->post('major'),
				'scholarship_status' => $this->input->post('scholarship_status'),
				'disability' => $this->input->post('disability'),
				'senior_citizen' => $this->input->post('senior_citizen'),
				'parent_support_status' => $this->input->post('parent_support_status'),
				'scholarship_remarks' => $this->input->post('scholarship_remarks')
		);
		//insert new scholarship
		$this->db->insert('scholarships', $data);
		
		$scholarship_id = $this->db->insert_id();
		
		//add audit trail
		$user = $this->ion_auth->user()->row();
		$data = array(
					'scholarship_id' => $scholarship_id,
					'user' => $user->username,
					'activity' => 'created'
		);
		$this->db->insert('audit_trail', $data);
		
		return;
	}
	
	
	//update individual grant
	public function update_scholarship($scholarship_id = NULL) {
		//echo '<pre>'; print_r($_POST); echo '</pre>'; die();
		$this->load->helper('url');
		
		//$id = $this->input->post('scholarship_id');
		
		$data = array(
				'batch' => $this->input->post('batch'),
				'school_id' => $this->input->post('school_id'),
				'course' => $this->input->post('course'),
				'major' => $this->input->post('major'),
				'scholarship_status' => $this->input->post('scholarship_status'),
				'disability' => $this->input->post('disability'),
				'senior_citizen' => $this->input->post('senior_citizen'),
				'parent_support_status' => $this->input->post('parent_support_status'),
				'scholarship_remarks' => $this->input->post('scholarship_remarks')
		);
		
		$this->db->where('scholarship_id', $scholarship_id);
		$this->db->update('scholarships', $data);
		
		//add audit trail
		$altered = $this->input->post('altered'); //hidden field that tracks form edits; see form
		if (strlen($altered) > 0) 
		{
			$user = $this->ion_auth->user()->row();
			$data3 = array(
						'scholarship_id' => $scholarship_id,
						'user' => $user->username,
						'activity' => 'modified',
						'mod_details' => $altered
			);
			$this->db->insert('audit_trail', $data3);
		}
		
		return;
	}


	public function set_scholarship_term() { //new scholarship
	
		$this->load->helper('url');
		
		$trash = ( $this->input->post('trash') !== null )  ? $this->input->post('trash') : 0 ;
		$scholarship_id = $this->input->post('scholarship_id');

		//prep data for scholarship term table
		$data = array(
				'scholarship_id' => $scholarship_id,
				'award_no' => $this->input->post('award_no'),
				'year_level' => $this->input->post('year_level'),
				'school_year' => $this->input->post('school_year'),
				'guardian_combined_income' => $this->input->post('guardian_combined_income'),
				'gwa_1' => $this->input->post('gwa_1'),
				'gwa_2' => $this->input->post('gwa_2'),
				'3_4_gwa' => $this->input->post('3_4_gwa'),
				'grade_points' => $this->input->post('grade_points'),
				'income_points' => $this->input->post('income_points'),
				'rank_points' => $this->input->post('rank_points'),
				'notes' => $this->input->post('notes')
		);

		//insert new term data
		$this->db->insert('scholarships_term_details', $data);
		
		//add audit trail
		$user = $this->ion_auth->user()->row();
		$data = array(
					'scholarship_id' => $scholarship_id,
					'user' => $user->username,
					'activity' => 'created'
		);
		$this->db->insert('audit_trail', $data);
		
		return;
	}

	public function update_scholarship_term() {

		$s_id = $this->input->post('scholarship_id');
		$t_id = $this->input->post('term_id');

		$data = array(
			'scholarship_id' => $s_id,
			'award_no' => $this->input->post('award_no'),
			'year_level' => $this->input->post('year_level'),
			'school_year' => $this->input->post('school_year'),
			'guardian_combined_income' => $this->input->post('guardian_combined_income'),
			'gwa_1' => $this->input->post('gwa_1'),
			'gwa_2' => $this->input->post('gwa_2'),
			'3_4_gwa' => $this->input->post('3_4_gwa'),
			'grade_points' => $this->input->post('grade_points'),
			'income_points' => $this->input->post('income_points'),
			'rank_points' => $this->input->post('rank_points'),
			'notes' => $this->input->post('notes')
			);

		$this->db->where('term_id', $t_id);
		$this->db->update('scholarships_term_details', $data);

		//add audit trail
		$user = $this->ion_auth->user()->row();
		$data = array(
					'scholarship_id' => $s_id,
					'user' => $user->username,
					'activity' => 'modified',
					'mod_details' => 'trashed term record with ID '.$t_id
				);
		$this->db->insert('audit_trail', $data);
		
		return;
	}

	public function trash_term($s_id = FALSE, $t_id = FALSE) {

		if ($t_id === FALSE || $s_id === FALSE) {
			return 0;
		}

		$data = array(
				'trash' => 1
			);
		
		$this->db->where('term_id', $t_id);
		$this->db->update('scholarships_term_details', $data);

		//add audit trail
		$user = $this->ion_auth->user()->row();
		$data = array(
					'scholarship_id' => $s_id,
					'user' => $user->username,
					'activity' => 'modified',
					'mod_details' => 'trashed term record with ID '.$t_id
				);
		$this->db->insert('audit_trail', $data);
		
		return;
	}

	public function get_all_scholarships() { //for extraction to excel
        
        //nonvoters
        $query1 = "select n.fname, n.mname, n.lname, n.id_no, n.dob, n.address, n.barangay, n.sex, 
                    c.school_name, s.course, s.major, s.scholarship_status, s.scholarship_remarks
                    from scholarships as s
                    join schools as c on c.school_id = s.school_id
                    join beneficiaries as b on b.ben_id = s.ben_id
                    join non_voters as n on n.nv_id = b.nv_id
                    where (s.trash = 0 and b.trash = 0 and n.trash = 0) 
                    ";
        $result1 = $this->db->query($query1);

        //registered voters
        $query2 = "select r.fname, r.mname, r.lname, r.id_no_comelec, r.dob, r.address, r.barangay, r.sex, 
                    c.school_name, s.course, s.major, s.scholarship_status, s.scholarship_remarks
                    from scholarships as s
                    join schools as c on c.school_id = s.school_id
                    join beneficiaries as b on b.ben_id = s.ben_id
                    join rvoters as r on r.id_no_comelec = b.id_no_comelec
                    where (s.trash = 0 and b.trash = 0 and r.trash = 0) 
                    ";
        $result2 = $this->db->query($query2);

        return array_merge($result1->result_array(), $result2->result_array());

    }
	
}
