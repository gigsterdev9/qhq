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
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(non_voters.dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('scholarships');
		$this->db->join('beneficiaries', 'scholarships.ben_id = beneficiaries.ben_id');
		$this->db->join('non_voters', 'non_voters.nv_id = beneficiaries.nv_id');
		$this->db->join('schools', 'scholarships.school_id = schools.school_id');
		$this->db->where('non_voters.trash = 0');
		$this->db->order_by('non_voters.lname', 'ASC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();

		return $query->result_array();

	}
	
	public function get_scholarship_by_id($id = FALSE)
	{
		if ($id === FALSE)
		{
			return 0;
		}
		
		/*
		$this->db->select('*');
		$this->db->from('rvoters');
		$this->db->where("id = '$id'"); //omit trash = 0 to be able to 'undo' trash one last time
		*/

		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(non_voters.dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('scholarships');
		$this->db->join('beneficiaries', 'scholarships.ben_id = beneficiaries.ben_id');
		$this->db->join('non_voters', 'non_voters.nv_id = beneficiaries.nv_id');
		$this->db->join('schools', 'scholarships.school_id = schools.school_id');
		$this->db->where("scholarships.scholarship_id = '$id'"); //omit trash = 0 to be able to 'undo' trash one last time
		$query = $this->db->get();		

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

	public function filter_rvoters($filter_param1 = FALSE, $filter_param2 = FALSE)
	{
		if ($filter_param1 === FALSE)
		{
			return 0;
		}
		
		$this->db->select('*');
		$this->db->from('rvoters');
		$this->db->where("$filter_param1 = '$filter_param2' and trash = 0");
		$query = $this->db->get();		
		
		return $query->result_array();
		
	}
	
	public function search_rvoters($search_param = FALSE)
	{
		if ($search_param === FALSE)
		{
			return 0;
		}
		
		$this->db->select('*');
		$this->db->from('rvoters');
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
	
	public function set_rvoter() //new voter
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
		$this->db->insert('rvoters', $data);
		
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
	
	
	//update individual grant
	public function update_rvoter($project_id = NULL) 
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
		$this->db->update('rvoters', $data);
		
		//add audit trail
		$altered = $this->input->post('altered'); //hidden field that tracks form edits; see form
		if (strlen($altered) > 0) 
		{
			$user = $this->ion_auth->user()->row();
			$data3 = array(
						'project_id' => $project_id,
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
