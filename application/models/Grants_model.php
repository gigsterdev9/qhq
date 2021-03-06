<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class grants_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
    /*
   	public function get_grants($slug = FALSE)
	{
		if ($slug === FALSE)
		{
			$query = $this->db->get('grants');
		    return $query->result_array();
		}

		$query = $this->db->get_where('grants', array('slug' => $slug));
		return $query->row_array();
	}
	*/
	public function get_grants($slug = FALSE)
	{
		if ($slug === FALSE)
		{
			$this->db->select('*');
			$this->db->from('projects as a');
			$this->db->join('proponents as b', 'b.proponent_id = a.proponent_id');
			$this->db->join('sgp5_sites as c', 'c.location_id = a.location_id');
			$this->db->where('trash = 0');
			$this->db->order_by('a.project_title', 'ASC');
			$query = $this->db->get();

		    return $query->result_array();
		}
		
		$this->db->select('*, a.remarks as prx');
		$this->db->from('projects as a');
		$this->db->join('proponents as b', 'b.proponent_id = a.proponent_id');
		$this->db->join('sgp5_sites as c', 'c.location_id = a.location_id');
		$this->db->where("slug = '$slug' and trash = 0");
		$query = $this->db->get();		

		return $query->row_array();
	}
	
	
	public function get_grant_by_id($id = FALSE)
	{
		if ($id === FALSE)
		{
			return 0;
		}
		
		$this->db->select('*, a.remarks as prx');
		$this->db->from('projects as a');
		$this->db->join('proponents as b', 'b.proponent_id = a.proponent_id');
		$this->db->join('sgp5_sites as c', 'c.location_id = a.location_id');
		$this->db->where("project_id = '$id'"); //omit trash = 0 to be able to 'undo' trash one last time
		$query = $this->db->get();		

		return $query->row_array();
	}
	
	
	public function filter_grants($filter_param1 = FALSE, $filter_param2 = FALSE)
	{
		if ($filter_param1 === FALSE)
		{
			return 0;
		}
		
		if ($filter_param1 == 'output') 
		{
			$this->db->select('*');
			$this->db->from('projects as a');
			$this->db->join('proponents as b', 'b.proponent_id = a.proponent_id');
			$this->db->join('sgp5_sites as c', 'c.location_id = a.location_id');
			$this->db->join('project_indicators as d', 'a.project_id = d.project_id');
			$this->db->where("d.indicator_code = '$filter_param2' and trash = 0");
			$query = $this->db->get();
		}
		else
		{
			$this->db->select('*');
			$this->db->from('projects as a');
			$this->db->join('proponents as b', 'b.proponent_id = a.proponent_id');
			$this->db->join('sgp5_sites as c', 'c.location_id = a.location_id');
			$this->db->where("$filter_param1 = '$filter_param2' and trash = 0");
			$query = $this->db->get();		
		}
		
		return $query->result_array();
		
	}
	
	public function search_grants($search_param = FALSE)
	{
		if ($search_param === FALSE)
		{
			return 0;
		}
		
		$this->db->select('*');
		$this->db->from('projects as a');
		$this->db->join('proponents as b', 'b.proponent_id = a.proponent_id');
		$this->db->join('sgp5_sites as c', 'c.location_id = a.location_id');
		$this->db->where("project_title like '%$search_param%' and trash = 0");
		$query = $this->db->get();		

		return $query->result_array();
		
	}
	
	
	public function get_grant_indicators($id = FALSE)
	{
		if ($id === FALSE) 
		{
			return 0;
		}
		
		$this->db->select('*');
		$this->db->from('project_indicators');
		$this->db->where('project_id', $id);
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	
	public function get_due_grants()
	{
		//look to 2 months prior to due date
		//activate by october? 
		$year = date('Y');
		
		$this->db->select('*');
		$this->db->from('projects');
		$this->db->where("project_end = '$year' and trash = 0");
		$query = $this->db->get();
		return $query->result_array();
		
	}
	
	public function get_target_indicators()
	{
		//compute indicators
		//outcome 1.1
		$this->db->select('SUM(indicator_value) as score');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code like '%1.1'");
		$query = $this->db->get();
		$row = $query->row();
		$indicator[11] = $row->score;
		
		//outcome 1.2
		$this->db->select('SUM(indicator_value) as score');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code like '%1.2'");
		$query = $this->db->get();
		$row = $query->row();
		$indicator[12] = $row->score;
		
		//outcome 1.3
		$this->db->select('SUM(indicator_value) as score');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code like '%1.3'");
		$query = $this->db->get();
		$row = $query->row();
		$indicator[13] = $row->score;
		
		//outcome 1.4
		$this->db->select('SUM(indicator_value) as score');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code like '%1.4'");
		$query = $this->db->get();
		$row = $query->row();
		$indicator[14] = $row->score;
		
		//outcome 2.1
		$this->db->select('SUM(indicator_value) as score');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code like '%2.1'");
		$query = $this->db->get();
		$row = $query->row();
		$indicator[21] = $row->score;
		
		//outcome 2.2
		$this->db->select('SUM(indicator_value) as score');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code like '%2.2'");
		$query = $this->db->get();
		$row = $query->row();
		$indicator[22] = $row->score;
		
		//outcome 3.1
		$this->db->select('SUM(indicator_value) as score');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code like '%3.1'");
		$query = $this->db->get();
		$row = $query->row();
		$indicator[31] = $row->score;
		
		//outcome 4.1
		$this->db->select('SUM(indicator_value) as score');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code like '%4.1'");
		$query = $this->db->get();
		$row = $query->row();
		$indicator[41] = $row->score;
		
		//outcome 4.2
		$this->db->select('SUM(indicator_value) as score');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code like '%4.2'");
		$query = $this->db->get();
		$row = $query->row();
		$indicator[42] = $row->score;
		
		//outcome 4.3
		$this->db->select('SUM(indicator_value) as score');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code like '%4.3'");
		$query = $this->db->get();
		$row = $query->row();
		$indicator[43] = $row->score;
		
		//outcome 4.4
		$this->db->select('SUM(indicator_value) as score');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code like '%4.4'");
		$query = $this->db->get();
		$row = $query->row();
		$indicator[44] = $row->score;
		
		//outcome 5.1
		$this->db->select('SUM(indicator_value) as score');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code like '%5.1'");
		$query = $this->db->get();
		$row = $query->row();
		$indicator[51] = $row->score;
		
		//outcome 5.2
		$this->db->select('SUM(indicator_value) as score');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code like '%5.2'");
		$query = $this->db->get();
		$row = $query->row();
		$indicator[52] = $row->score;
		
		//outcome 5.3
		$this->db->select('SUM(indicator_value) as score');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code like '%5.3'");
		$query = $this->db->get();
		$row = $query->row();
		$indicator[53] = $row->score;
		
		
		//return result array
		return $indicator;

	}

	public function get_grants_by_type()
	{
		//group by small
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('projects');
		$this->db->where("grant_type = 'Small' and trash = 0");
		$query = $this->db->get();
		$row = $query->row();
		$type['small'] = $row->counter;
		
		//group by planning
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('projects');
		$this->db->where("grant_type = 'Planning' and trash = 0");
		$query = $this->db->get();
		$row = $query->row();
		$type['planning'] = $row->counter;
		
		//group by strategic
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('projects');
		$this->db->where("grant_type = 'Strategic' and trash = 0");
		$query = $this->db->get();
		$row = $query->row();
		$type['strategic'] = $row->counter;
		
		//return result array
		return $type;
	}
	
	public function get_grants_by_status()
	{
		//group by pending
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('projects');
		$this->db->where("project_status = '1' and trash = 0");
		$query = $this->db->get();
		$row = $query->row();
		$status['pending'] = $row->counter;
		
		//group by approved
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('projects');
		$this->db->where("project_status = '2' and trash = 0");
		$query = $this->db->get();
		$row = $query->row();
		$status['approved'] = $row->counter;
		
		//group by declined
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('projects');
		$this->db->where("project_status = '3' and trash = 0");
		$query = $this->db->get();
		$row = $query->row();
		$status['declined'] = $row->counter;
		
		//group by completed
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('projects');
		$this->db->where("project_status = '4' and trash = 0");
		$query = $this->db->get();
		$row = $query->row();
		$status['completed'] = $row->counter;
		
		
		//group by cancelled
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('projects');
		$this->db->where("project_status = '5' and trash = 0");
		$query = $this->db->get();
		$row = $query->row();
		$status['cancelled'] = $row->counter;
		
		//count historical
		$this->db->select('COUNT(id) as counter');
		$this->db->from('grants');
		$query = $this->db->get();
		$row = $query->row();
		$status['historical'] = $row->counter;
		
		//return result array
		return $status;
	}
	
	
	public function get_grants_by_outcome()
	{
		//group by outcome
		//outcome 1
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code like '1%'");
		$query = $this->db->get();
		$row = $query->row();
		$outcome[1] = $row->counter;
		
		//outcome 2
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code like '2%'");
		$query = $this->db->get();
		$row = $query->row();
		$outcome[2] = $row->counter;

		//outcome 3
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code like '3%'");
		$query = $this->db->get();
		$row = $query->row();
		$outcome[3] = $row->counter;

		//outcome 4
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code like '4%'");
		$query = $this->db->get();
		$row = $query->row();
		$outcome[4] = $row->counter;
		
		//outcome 5
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code like '5%'");
		$query = $this->db->get();
		$row = $query->row();
		$outcome[5] = $row->counter;
		
		//return result array
		return $outcome;
		
	}
	
	
	public function get_grants_by_output()
	{
		//group by outputs
		//output 1.1
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code = '1.1.1'");
		$query = $this->db->get();
		$row = $query->row();
		$output['1.1'] = $row->counter;
		
		//output 1.2
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code = '1.1.2'");
		$query = $this->db->get();
		$row = $query->row();
		$output['1.2'] = $row->counter;

		//output 1.3
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code = '1.1.3'");
		$query = $this->db->get();
		$row = $query->row();
		$output['1.3'] = $row->counter;

		//outputs 1.4
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code = '1.1.4'");
		$query = $this->db->get();
		$row = $query->row();
		$output['1.4'] = $row->counter;
		
		//outputs 2.1
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code = '2.2.1'");
		$query = $this->db->get();
		$row = $query->row();
		$output['2.1'] = $row->counter;
		
		//outputs 2.2
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code = '2.2.2'");
		$query = $this->db->get();
		$row = $query->row();
		$output['2.2'] = $row->counter;
		
		//outputs 3.1
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code = '2.3.1'");
		$query = $this->db->get();
		$row = $query->row();
		$output['3.1'] = $row->counter;
		
		//outputs 4.1
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code = '3.4.1'");
		$query = $this->db->get();
		$row = $query->row();
		$output['4.1'] = $row->counter;
		
		//outputs 4.2
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code = '3.4.2'");
		$query = $this->db->get();
		$row = $query->row();
		$output['4.2'] = $row->counter;
		
		//outputs 4.3
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code = '3.4.3'");
		$query = $this->db->get();
		$row = $query->row();
		$output['4.3'] = $row->counter;
		
		//outputs 4.4
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code = '3.4.4'");
		$query = $this->db->get();
		$row = $query->row();
		$output['4.4'] = $row->counter;
		
		//outputs 5.1
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code = '3.5.1'");
		$query = $this->db->get();
		$row = $query->row();
		$output['5.1'] = $row->counter;
		
		//outputs 5.2
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code = '3.5.2'");
		$query = $this->db->get();
		$row = $query->row();
		$output['5.2'] = $row->counter;
		
		//outputs 5.3
		$this->db->select('COUNT(project_id) as counter');
		$this->db->from('project_indicators');
		$this->db->where("indicator_code = '3.5.3'");
		$query = $this->db->get();
		$row = $query->row();
		$output['5.3'] = $row->counter;
		
		//return result array
		return $output;
		
	}
	
		
	public function get_recent_grants($count_limit = 5)
	{
				
		$this->db->select('project_id, project_title, slug');
		$this->db->from('projects');
		$this->db->where("trash = 0");
		$this->db->order_by('project_id', 'DESC');
		$this->db->limit($count_limit);
		$query = $this->db->get();		

		return $query->result_array();
	}
	
	public function get_submitted_docs($id = FALSE)
	{
		$this->db->select('*');
		$this->db->from('submitted_docs');
		$this->db->where('project_id', $id);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function set_grants() //new grants
	{
		$this->load->helper('url');
		
		$slug = url_title($this->input->post('title'), 'dash', TRUE);
		$moa_number = ($this->input->post('moa_number') == '') ? NULL : $this->input->post('moa_number');
		
		$data = array(
				'project_title' => $this->input->post('title'),
				'slug' => $slug,
				'location' => $this->input->post('location'),
				'location_id' => $this->input->post('site'),
				'proponent_id' => $this->input->post('proponent'),
				'project_objectives' => $this->input->post('project_objectives'),
				'key_partners' => $this->input->post('key_partners'),
				'beneficiaries' => $this->input->post('beneficiaries'),
				'project_duration' => $this->input->post('project_duration'),
				'project_start' => $this->input->post('project_start'),
				'project_end' => $this->input->post('project_end'),
				'actual_start' => $this->input->post('actual_start'),
				'actual_end' => $this->input->post('actual_end'),
				'project_budget' => $this->input->post('project_budget'),
				'amount_requested' => $this->input->post('amount_requested'),
				'co_financing' => $this->input->post('co_financing'),
				'project_status' => $this->input->post('project_status'),
				'grant_type' => $this->input->post('grant_type'),
				'moa_number' => $moa_number,
				'remarks' => $this->input->post('remarks')
		);
		//insert new project
		$this->db->insert('projects', $data);
		
		$project_id = $this->db->insert_id();
		
		//prep outcome indicators and values
		if ($this->input->post('o111') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '1.1.1',
				'indicator_value' => $this->input->post('o111')
			);
		}
		if ($this->input->post('o112') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '1.1.2',
				'indicator_value' => $this->input->post('o112')
			);
		}
		if ($this->input->post('o113') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '1.1.3',
				'indicator_value' => $this->input->post('o113')
			);
		}
		if ($this->input->post('o114') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '1.1.4',
				'indicator_value' => $this->input->post('o114')
			);
		}
		if ($this->input->post('o221') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '2.2.1',
				'indicator_value' => $this->input->post('o221')
			);
		}
		if ($this->input->post('o222') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '2.2.2',
				'indicator_value' => $this->input->post('o222')
			);
		}
		if ($this->input->post('o231') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '2.3.1',
				'indicator_value' => $this->input->post('o231')
			);
		}
		if ($this->input->post('o341') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '3.4.1',
				'indicator_value' => $this->input->post('o341')
			);
		}
		if ($this->input->post('o342') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '3.4.2',
				'indicator_value' => $this->input->post('o342')
			);
		}
		if ($this->input->post('o343') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '3.4.3',
				'indicator_value' => $this->input->post('o343')
			);
		}
		if ($this->input->post('o344') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '3.4.4',
				'indicator_value' => $this->input->post('o344')
			);
		}
		if ($this->input->post('o351') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '3.5.1',
				'indicator_value' => $this->input->post('o351')
			);
		}
		if ($this->input->post('o352') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '3.5.2',
				'indicator_value' => $this->input->post('o352')
			);
		}
		if ($this->input->post('o353') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '3.5.3',
				'indicator_value' => $this->input->post('o353')
			);
		}
		
		//insert project indicators if at least one indicator is set
		if (isset($data1))
		{
			$this->db->insert_batch('project_indicators', $data1);
		}
		
		/*remove related docs stuff
		$data2 = array(
				'project_id' => $project_id,
				'cover_letter' => $this->input->post('cover_letter'),
				'summary_sheet' => $this->input->post('summary_sheet'),
				'proj_proposal' => $this->input->post('proj_proposal'),
				'proof_of_registration' => $this->input->post('summary_sheet'),
				'financial_statements' => $this->input->post('financial_statements'),
				'endorsements' => $this->input->post('endorsements'),
				'others' => $this->input->post('others')
		);
		//insert submitted docs
		$this->db->insert('submitted_docs', $data2);
		*/
		
		//prep finance data
		$data2[] = array(
				'project_id' => $project_id,
				'tranche' => 1,
				'amount' => $this->input->post('t1_amount'),
				'amount_released' => $this->input->post('t1_released'),
				'date_released' => $this->input->post('t1_date_released')
			);	
		$data2[] = array(
				'project_id' => $project_id,
				'tranche' => 2,
				'amount' => $this->input->post('t2_amount'),
				'amount_released' => $this->input->post('t2_released'),
				'date_released' => $this->input->post('t2_date_released')
			);	
		$data2[] = array(
				'project_id' => $project_id,
				'tranche' => 3,
				'amount' => $this->input->post('t3_amount'),
				'amount_released' => $this->input->post('t3_released'),
				'date_released' => $this->input->post('t3_date_released')
			);	
		$data2[] = array(
				'project_id' => $project_id,
				'tranche' => 4,
				'amount' => $this->input->post('t4_amount'),
				'amount_released' => $this->input->post('t4_released'),
				'date_released' => $this->input->post('t4_date_released')
			);	
		$data2[] = array(
				'project_id' => $project_id,
				'tranche' => 5,
				'amount' => $this->input->post('t5_amount'),
				'amount_released' => $this->input->post('t5_released'),
				'date_released' => $this->input->post('t5_date_released')
			);		
		$data2[] = array(
				'project_id' => $project_id,
				'tranche' => 6,
				'amount' => $this->input->post('t6_amount'),
				'amount_released' => $this->input->post('t6_released'),
				'date_released' => $this->input->post('t6_date_released')
			);		
		//insert finance data
		$this->db->insert_batch('project_finances', $data2);
		
			
		//add audit trail
		$user = $this->ion_auth->user()->row();
		$data3 = array(
					'project_id' => $project_id,
					'user' => $user->username,
					'activity' => 'created'
		);
		$this->db->insert('audit_trail', $data3);
		
		return;
	}
	
	
	//update individual grant
	public function update_grant($project_id = NULL) 
	{
		//echo '<pre>'; print_r($_POST); echo '</pre>'; die();
		$this->load->helper('url');
		
		$slug = url_title($this->input->post('title'), 'dash', TRUE);
		$project_id = $this->input->post('project_id');
		$moa_number = ($this->input->post('moa_number') == '') ? NULL : $this->input->post('moa_number');
		
		//delete all instances of outcome contributions; then re-add, if any
		$this->db->where('project_id', $project_id);
		$this->db->delete('project_indicators');
		
		//prep outcome indicators and values
		if ($this->input->post('o111') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '1.1.1',
				'indicator_value' => $this->input->post('o111')
			);
		}
		if ($this->input->post('o112') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '1.1.2',
				'indicator_value' => $this->input->post('o112')
			);
		}
		if ($this->input->post('o113') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '1.1.3',
				'indicator_value' => $this->input->post('o113')
			);
		}
		if ($this->input->post('o114') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '1.1.4',
				'indicator_value' => $this->input->post('o114')
			);
		}
		if ($this->input->post('o221') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '2.2.1',
				'indicator_value' => $this->input->post('o221')
			);
		}
		if ($this->input->post('o222') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '2.2.2',
				'indicator_value' => $this->input->post('o222')
			);
		}
		if ($this->input->post('o231') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '2.3.1',
				'indicator_value' => $this->input->post('o231')
			);
		}
		if ($this->input->post('o341') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '3.4.1',
				'indicator_value' => $this->input->post('o341')
			);
		}
		if ($this->input->post('o342') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '3.4.2',
				'indicator_value' => $this->input->post('o342')
			);
		}
		if ($this->input->post('o343') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '3.4.3',
				'indicator_value' => $this->input->post('o343')
			);
		}
		if ($this->input->post('o344') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '3.4.4',
				'indicator_value' => $this->input->post('o344')
			);
		}
		if ($this->input->post('o351') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '3.5.1',
				'indicator_value' => $this->input->post('o351')
			);
		}
		if ($this->input->post('o352') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '3.5.2',
				'indicator_value' => $this->input->post('o352')
			);
		}
		if ($this->input->post('o353') != NULL) 
		{
			$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '3.5.3',
				'indicator_value' => $this->input->post('o353')
			);
		}
		
		//buffer
		$data1[] = array(
				'project_id' => $project_id,
				'indicator_code' => '0.0.0',
				'indicator_value' => '0'
			);
		
		//insert project indicators
		$this->db->insert_batch('project_indicators', $data1);

		$data = array(
				'project_title' => $this->input->post('title'),
				'slug' => $slug,
				'location' => $this->input->post('location'),
				'location_id' => $this->input->post('site'),
				'proponent_id' => $this->input->post('proponent'),
				'project_objectives' => $this->input->post('project_objectives'),
				'key_partners' => $this->input->post('key_partners'),
				'beneficiaries' => $this->input->post('beneficiaries'),
				'project_duration' => $this->input->post('project_duration'),
				'project_start' => $this->input->post('project_start'),
				'project_end' => $this->input->post('project_end'),
				'actual_start' => $this->input->post('actual_start'),
				'actual_end' => $this->input->post('actual_end'),
				'project_budget' => $this->input->post('project_budget'),
				'amount_requested' => $this->input->post('amount_requested'),
				'co_financing' => $this->input->post('co_financing'),
				'project_status' => $this->input->post('project_status'),
				'grant_type' => $this->input->post('grant_type'),
				'moa_number' => $moa_number,
				'remarks' => $this->input->post('remarks'),
				'trash' => $this->input->post('trash')
		);
		
		$this->db->where('project_id', $project_id);
		$this->db->update('projects', $data);
		
		/*
		$data2 = array(
				'cover_letter' => $this->input->post('cover_letter'),
				'summary_sheet' => $this->input->post('summary_sheet'),
				'proj_proposal' => $this->input->post('proj_proposal'),
				'proof_of_registration' => $this->input->post('summary_sheet'),
				'financial_statements' => $this->input->post('financial_statements'),
				'commitments' => $this->input->post('commitments'),
				'endorsements' => $this->input->post('endorsements'),
				'others' => $this->input->post('others')
		);
		//update submitted docs
		$this->db->where('project_id', $project_id);
		$this->db->update('submitted_docs', $data2);
		*/
		
		//prep tranche data
		$data2[1] = array(
					'amount' => $this->input->post('t1_amount'),
					'amount_released' => $this->input->post('t1_released'),
					'date_released' => $this->input->post('t1_date_released')
				);
				
		$data2[2] = array(
					'amount' => $this->input->post('t2_amount'),
					'amount_released' => $this->input->post('t2_released'),
					'date_released' => $this->input->post('t2_date_released')
				);
				
		$data2[3] = array(
					'amount' => $this->input->post('t3_amount'),
					'amount_released' => $this->input->post('t3_released'),
					'date_released' => $this->input->post('t3_date_released')
				);
				
		$data2[4] = array(
					'amount' => $this->input->post('t4_amount'),
					'amount_released' => $this->input->post('t4_released'),
					'date_released' => $this->input->post('t4_date_released')
				);
				
		$data2[5] = array(
					'amount' => $this->input->post('t5_amount'),
					'amount_released' => $this->input->post('t5_released'),
					'date_released' => $this->input->post('t5_date_released')
				);
				
		$data2[6] = array(
					'amount' => $this->input->post('t6_amount'),
					'amount_released' => $this->input->post('t6_released'),
					'date_released' => $this->input->post('t6_date_released')
				);
		//update tranche data
		for ($i=1; $i<=6; $i++) 
		{
			$this->db->where('project_id', $project_id);
			$this->db->where('tranche',$i);
			$this->db->update('project_finances', $data2[$i]); 
		}
			
		//add audit trail
		$altered = $this->input->post('altered');
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
	
	public function get_historical_grants($slug = FALSE)
	{
		if ($slug === FALSE)
		{
			$this->db->select('*');
			$this->db->from('grants');
			$this->db->where("trash = 0");
			$query = $this->db->get();
		    return $query->result_array();
		}

		$query = $this->db->get_where('grants', array('slug' => $slug));
		return $query->row_array();
	}
	
	public function get_historical_grant_by_id($id)
	{
		$query = $this->db->get_where('grants', array('id' => $id));
		return $query->row_array();
	}
	
	
	public function search_historical_grants($search_param = FALSE)
	{
		if ($search_param === FALSE)
		{
			return 0;
		}
		
		$this->db->select('*');
		$this->db->from('grants');
		$this->db->where("title like '%$search_param%' and trash = 0");
		$query = $this->db->get();		

		return $query->result_array();
		
	}
	
	public function set_historical_grants()
	{
		$this->load->helper('url');
		
		$slug = url_title($this->input->post('title'), 'dash', TRUE);

		$data = array(
				'title' => $this->input->post('title'),
				'slug' => $slug,
				'proponent' => $this->input->post('proponent'),
				'site' => $this->input->post('site'),
				'description' => $this->input->post('description'),
				'grant_amount' => $this->input->post('grant_amount'),
				'currency' => $this->input->post('currency'),
				'grant_type' => $this->input->post('grant_type'),
				'phase' => $this->input->post('phase'),
				'remarks' => $this->input->post('remarks'),
				'status' => '0'
		);

		return $this->db->insert('grants', $data);
	}

	
	public function update_historical_grants($id)
	{
		$this->load->helper('url');
		
		$slug = url_title($this->input->post('title'), 'dash', TRUE);

		$data = array(
				'title' => $this->input->post('title'),
				'slug' => $slug,
				'proponent' => $this->input->post('proponent'),
				'site' => $this->input->post('site'),
				'description' => $this->input->post('description'),
				'grant_amount' => $this->input->post('grant_amount'),
				'currency' => $this->input->post('currency'),
				'grant_type' => $this->input->post('grant_type'),
				'phase' => $this->input->post('phase'),
				'remarks' => $this->input->post('remarks'),
				'status' => '0',
				'trash' => $this->input->post('trash')
		);

		$this->db->where('id', $id);
		$query = $this->db->update('grants', $data);

		return;
	}
	
	
	public function get_sites()
	{
		$this->db->select('location_id, location_name');
		$query = $this->db->get('sgp5_sites');
		return $query->result_array();
	}
	
	public function get_indicators()
	{
		$this->db->select('indicator_code, indicator_desc, indicator_peg, indicator_peg_unit');
		$query = $this->db->get('sgp5_indicators');
		return $query->result_array();
	}

	public function get_proponents()
	{
		$this->db->select('proponent_id, organization_name');
		$query = $this->db->get('proponents');
		return $query->result_array();
	}
	
	public function show_activities($id)
	{
		$this->db->select('*');
		$this->db->from('audit_trail');
		$this->db->order_by('timestamp', 'desc');
		$this->db->where("project_id = '$id' and activity = 'modified'");
		$this->db->limit(5);
		$query = $this->db->get();		
		
		$tracker['modified'] = $query->result_array();	
		
		$this->db->select('*');
		$this->db->from('audit_trail');
		$this->db->where("project_id = '$id' and activity = 'created'");
		$query = $this->db->get();		
		
		$tracker['created'] = $query->row_array();	
		
		return $tracker;
	}
	
	public function show_finances($id)
	{
		$this->db->select('*');
		$this->db->from('project_finances');
		$this->db->where("project_id = '$id'");
		$query = $this->db->get();		
		
		return $query->result_array();	
	}

}
