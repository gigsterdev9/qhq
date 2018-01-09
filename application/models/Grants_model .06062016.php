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
			$this->db->order_by('a.project_title', 'ASC');
			$query = $this->db->get();
			//$query = $this->db->get('projects');
		    return $query->result_array();
		}
		
		$this->db->select('*');
		$this->db->from('projects as a');
		$this->db->join('proponents as b', 'b.proponent_id = a.proponent_id');
		$this->db->join('sgp5_sites as c', 'c.location_id = a.location_id');
		$this->db->where('slug',$slug);
		$query = $this->db->get();		

		return $query->row_array();
	}
	
	public function get_due_grants()
	{
		//look to 2 months prior to due date

		//return $query->result_array();
	}
	
	public function get_recent_grants($count_limit = 5)
	{
				
		$this->db->select('project_id, project_title, slug');
		$this->db->from('projects');
		$this->db->order_by('project_id', 'DESC');
		$this->db->limit($count_limit);
		$query = $this->db->get();		

		return $query->result_array();
	}
	
	public function set_grants() //new grants
	{
		$this->load->helper('url');
		
		$slug = url_title($this->input->post('title'), 'dash', TRUE);

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
				'remarks' => $this->input->post('remarks'),
		);

		return $this->db->insert('projects', $data);
	}
	
	public function update_grant($project_id = NULL) //update individual grant
	{
		$this->load->helper('url');
		
		$slug = url_title($this->input->post('title'), 'dash', TRUE);

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
				'remarks' => $this->input->post('remarks'),
		);
		
		$project_id = $this->input->post('project_id');
		$this->db->where('project_id', $project_id);
		return $this->db->update('projects', $data);
	}
	
	public function get_historical_grants($slug = FALSE)
	{
		if ($slug === FALSE)
		{
			$query = $this->db->get('grants');
		    return $query->result_array();
		}

		$query = $this->db->get_where('grants', array('slug' => $slug));
		return $query->row_array();
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
				'grant_type' => $this->input->post('grant_type'),
				'remarks' => $this->input->post('remarks'),
				'status' => '0'
		);

		return $this->db->insert('grants', $data);
	}


	public function get_sites()
	{
		$this->db->select('location_id, location_name');
		$query = $this->db->get('sgp5_sites');
		return $query->result_array();
	}


	public function get_proponents()
	{
		$this->db->select('proponent_id, organization_name');
		$query = $this->db->get('proponents');
		return $query->result_array();
	}

}
