<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class beneficiaries_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}
        
    public function record_count() {
		$this->db->where('trash = 0');
        return $this->db->count_all("beneficiaries");
    }

    public function count_rv_ben_by_brgy($brgy = false) {

        $query = "select count(*) as total from beneficiaries b
                join rvoters r on r.id_no_comelec = b.id_no_comelec
                where r.barangay = '$brgy' 
                and (b.trash = 0 and r.trash = 0)";
        $result = $this->db->query($query);
        $count = $result->row();
        
        //die($count->total);
        return $count->total;
    }


    public function count_nv_ben_by_brgy($brgy = false) {

        $query = "select count(*) as total from beneficiaries b
                join non_voters n on n.nv_id = b.nv_id
                where n.barangay = '$brgy' 
                and (b.trash = 0 and n.trash = 0)";
        $result = $this->db->query($query);
        $count = $result->row();
        
        //die($count->total);
        return $count->total;

    }

	public function get_rv_beneficiaries($limit = 0, $start = 0, $where_clause = false) {
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(r.dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('beneficiaries b');
		$this->db->join('rvoters r', 'r.id_no_comelec = b.id_no_comelec');
		
		if ($where_clause === false) {
			$this->db->where('b.trash = 0 and r.trash = 0'); 
		}
		else{
			$where_clause .= " and (b.trash = 0 and r.trash = 0)";
			//die($where_clause);
			$this->db->where($where_clause); 
		}
		$this->db->order_by('r.lname', 'ASC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();

		return $query->result_array();

	}

    public function get_nv_beneficiaries($limit = 0, $start = 0, $where_clause = false) {
		
		$this->db->select("*, floor((DATEDIFF(CURRENT_DATE, STR_TO_DATE(n.dob, '%Y-%m-%d'))/365)) as age");
		$this->db->from('beneficiaries b');
		$this->db->join('non_voters n', 'n.nv_id = b.nv_id');

		if ($where_clause === false) {
			$this->db->where('b.trash = 0 and n.trash = 0');
		}
		else{
			$where_clause .= " and (b.trash = 0 and n.trash = 0)";
			//die($where_clause);
			$this->db->where($where_clause); 
		}
		$this->db->order_by('n.lname', 'ASC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();

		return $query->result_array();

	}

	public function get_beneficiary_by_id($id = FALSE) { //get by ben id
		if ($id === FALSE) {
			return 0; 
		}
		
		$this->db->select("*");
		$this->db->from('beneficiaries');
		$this->db->where("ben_id = '$id'"); //omit trash = 0 to be able to 'undo' trash one last time
		$query = $this->db->get();		
		$r =  $query->row_array();

		if (!empty($r['id_no_comelec']))  { //if not empty, then a registered voter
			$ben = $this->rvoters_model->get_rvoter_by_comelec_id($r['id_no_comelec'], false);
		}
		else{
			$ben = $this->nonvoters_model->get_nonvoter_by_id($r['nv_id'], false);
		}

		return $ben;
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
	
	public function search_beneficiaries($limit, $start, $search_param = FALSE, $s_key = FALSE) {
		/*
		if ($search_param === FALSE or $s_key === FALSE) {
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
			$where_clause = '1';
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
		*/

		$result_array = 0;
		return $result_array;

		/* the basic search functionality is embedded into the respective get_nv_beneficiaries and get_rv_beneficiaries methods*/

	}
	
	
	public function get_ben_by_nvid($id) {
		$this->db->select('*');
		$this->db->from('beneficiaries');
		$this->db->join('non_voters', 'non_voters.nv_id = beneficiaries.nv_id');
		$this->db->where("beneficiaries.nv_id = '$id'");
		$query = $this->db->get();

		return $query->row_array(); //nv_id column has unique attrib
	}

	public function get_ben_by_comid($id) {
		$this->db->select('*');
		$this->db->from('beneficiaries');
		$this->db->join('rvoters', 'rvoters.id_no_comelec = beneficiaries.id_no_comelec');
		$this->db->where("beneficiaries.id_no_comelec = '$id'");
		$query = $this->db->get();

		//echo $this->db->last_query(); die();
		return $query->row_array(); //id_no_comelec has unique attrib
	}



	public function get_recent_beneficiaries($count_limit = 5) {
				
		$this->db->select('id, fname, lname');
		$this->db->from('beneficiaries');
		$this->db->where("trash = 0");
		$this->db->order_by('id', 'DESC');
		$this->db->limit($count_limit);
		$query = $this->db->get();		

		return $query->result_array();
	}
	
	//new beneficiary;
	public function set_beneficiary($id = null, $id_type = null) {// $id_type should either be nv or rv
	
		$this->load->helper('url');

		//echo '<pre>'; print_r($this->input->post()); echo '</pre>'; die();

		if ($id == NULL) {

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
		}
		else{
			
			if ($id_type == 'rv') {
				$id_no_comelec = $id;
				$nv_id = NULL;
			}
			elseif ($id_type == 'nv') {
				$id_no_comelec = NULL;
				$nv_id = $id;
			}
			else{
				return 0;
			}
		}

		$trash = ( $this->input->post('trash') !== null )  ? $this->input->post('trash') : 0 ;
		
		$data = array(
				'id_no_comelec' => $id_no_comelec,
				'nv_id' => $nv_id,
				'trash' => $trash
		);

		//insert new beneficiary
		$this->db->insert('beneficiaries', $data);
		
		$ben_id = $this->db->insert_id();
		
		//add audit trail
		$user = $this->ion_auth->user()->row();
		$data1 = array(
					'id_no_comelec' => $id_no_comelec,
					'nv_id' => $nv_id,
					'ben_id' => $ben_id,
					'user' => $user->username,
					'activity' => 'created',
					'mod_details' => 'made beneficiary'
		);
		$this->db->insert('audit_trail', $data1);
		
		return $ben_id;
	}

    public function get_all_beneficiaries() {

        //nonvoters
        $query1 = "select n.fname, n.mname, n.lname, n.id_no as id_no, n.dob, n.address, n.barangay, n.sex, n.nv_remarks as remarks
                    from beneficiaries as b 
                    join non_voters as n on n.nv_id = b.nv_id
                    where (b.trash = 0 and n.trash = 0) 
                    ";
        $result1 = $this->db->query($query1);

        //registered voters
        $query2 = "select r.fname, r.mname, r.lname, r.id_no_comelec as id_no, r.dob, r.address, r.barangay, r.sex, r.remarks as remarks
                    from beneficiaries as b
                    join rvoters as r on r.id_no_comelec = b.id_no_comelec
                    where (b.trash = 0 and r.trash = 0) 
                    ";
        $result2 = $this->db->query($query2);

        return array_merge($result1->result_array(), $result2->result_array());

    }

}
