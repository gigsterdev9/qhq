<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class scholarships_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
    public function record_count() {
        return $this->db->count_all("scholarships");
	}
	
	public function get_scholarships($limit = 0, $start = 0) {
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(n.dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('scholarships s');
		$this->db->join('beneficiaries b', 's.ben_id = b.ben_id');
		$this->db->join('non_voters n', 'n.nv_id = b.nv_id');
		$this->db->join('schools', 's.school_id = schools.school_id');
		$this->db->where('n.trash = 0');
		$this->db->order_by('n.lname', 'ASC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();

		return $query->result_array();

	}
	
	public function get_n_scholarships($limit = 0, $start = 0) {
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(n.dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('scholarships s');
		$this->db->join('beneficiaries b', 's.ben_id = b.ben_id');
		$this->db->join('non_voters n', 'n.nv_id = b.nv_id');
		$this->db->join('schools', 's.school_id = schools.school_id');
		$this->db->where('n.trash = 0');
		$this->db->order_by('n.lname', 'ASC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();

		return $query->result_array();

	}

	public function get_r_scholarships($limit = 0, $start = 0) {
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(r.dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('scholarships s');
		$this->db->join('beneficiaries b', 's.ben_id = b.ben_id');
		$this->db->join('rvoters r', 'r.id_no_comelec = b.id_no_comelec');
		$this->db->join('schools', 's.school_id = schools.school_id');
		$this->db->where('r.trash = 0');
		$this->db->order_by('r.lname', 'ASC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();

		return $query->result_array();

	}

	public function get_scholarship_by_id($id = FALSE, $flag = FALSE) {
		if ($id === FALSE)
		{
			return 0;
		}
		
		//$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(non_voters.dob, '%Y-%m-%d'))/365)) as age");
		$this->db->select('*');
		$this->db->from('scholarships s');
		$this->db->join('beneficiaries b', 's.ben_id = b.ben_id');
		//$this->db->join('non_voters', 'non_voters.nv_id = beneficiaries.nv_id');
		//$this->db->join('schools', 'scholarships.school_id = schools.school_id');
		$this->db->where("s.scholarship_id = '$id'"); //omit trash = 0 to be able to 'undo' trash one last time
		$query = $this->db->get();		

		return $query->row_array();
	}

	public function get_n_scholarship_by_id($id) {
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(n.dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('scholarships s');
		$this->db->join('beneficiaries b', 's.ben_id = b.ben_id');
		$this->db->join('non_voters n', 'n.nv_id = b.nv_id');
		$this->db->join('schools', 's.school_id = schools.school_id');
		$this->db->where("s.scholarship_id = '$id'"); //omit trash = 0 to be able to 'undo' trash one last time
		$query = $this->db->get();

		return $query->row_array(); //nv_id column has unique attrib
	}

	public function get_r_scholarship_by_id($id) {
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(r.dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('scholarships s');
		$this->db->join('beneficiaries b', 's.ben_id = b.ben_id');
		$this->db->join('rvoters r', 'r.id_no_comelec = b.id_no_comelec');
		$this->db->join('schools', 's.school_id = schools.school_id');
		$this->db->where("s.scholarship_id = '$id'"); //omit trash = 0 to be able to 'undo' trash one last time
		$query = $this->db->get();

		return $query->row_array(); //nv_id column has unique attrib
	}

	public function get_scholarship_by_ben_id($id = FALSE, $flag = FALSE) {
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

	public function get_term_details($id = FALSE) {
		
		if ($id === FALSE)
		{
			return 0;
		}

		$this->db->select('*');
		$this->db->from('scholarships_term_details');
		$this->db->where("scholarship_id = '$id'");
		$query = $this->db->get();

		return $query->result_array();
	} 
	
	public function get_schools() {

		$this->db->select('*');
		$this->db->from('schools');
		$query = $this->db->get();		

		return $query->result_array();
	
	}

	public function filter_scholarships($filter_param1 = FALSE, $filter_param2 = FALSE, $limit = 0, $start = 0) {
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

	public function filter_scholarships_num_rows($filter_param1 = FALSE, $filter_param2 = FALSE) {
		if ($filter_param1 === FALSE)
		{
			return 0;
		}
		
		$this->db->select('*');
		$this->db->from('scholarships');
		$this->db->join('beneficiaries', 'beneficiaries.ben_id = scholarships.ben_id');
		$this->db->join('non_voters', 'beneficiaries.nv_id = non_voters.nv_id');
		$this->db->join('schools', 'scholarships.school_id = schools.school_id');
		$this->db->where("$filter_param1 = '$filter_param2' and beneficiaries.trash = 0");
		$query = $this->db->get();		
		
		return $query->num_rows();
		
	}

	
	
	public function search_scholarships($search_param = FALSE)
	{
		if ($search_param === FALSE)
		{
			return 0;
		}
		
		$this->db->select('*');
		$this->db->from('scholarships');
		$this->db->where("lname like '%$search_param%' or fname like '%$search_param%' and trash = 0");
		$query = $this->db->get();		

		return $query->result_array();
		
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
		
		//prep data for beneficiary table
		$data = array(
				'id_no_comelec' => $id_no_comelec,
				'nv_id' => $nv_id,
				'trash' => $trash
		);

		//insert new beneficiary
		$this->db->insert('beneficiaries', $data);
		
		$ben_id = $this->db->insert_id();
		
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
	public function update_scholarship($scholarship_id = NULL) 
	{
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
				'scholarship_remarks' => $this->input->post('scholarship_remarks'),
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
