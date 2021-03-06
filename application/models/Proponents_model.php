<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class proponents_model extends CI_Model {

	public function __construct()
	{
    	$this->load->database();
	}

	public function get_proponents($proponent_id = FALSE)
	{
		if ($proponent_id === FALSE)
		{
			$this->db->order_by('organization_name', 'ASC');
			$query = $this->db->get('proponents');
		    return $query->result_array();
		}

		$query = $this->db->get_where('proponents', array('proponent_id' => $proponent_id));
		return $query->row_array();
	}
	
	public function search_proponents($search_param = FALSE)
	{
		if ($search_param === FALSE)
		{
			return 0;
		}

		$this->db->order_by('organization_name', 'ASC');
		$this->db->where("organization_name like '%$search_param%'");
		$query = $this->db->get('proponents');
	    return $query->result_array();

	}
	
		
	public function set_proponents()
	{
		//print_r($_POST);
		//die();
		
		$this->load->helper('url');
		
		$data = array(
			'organization_name' => $this->input->post('organization_name'),
			'alias' => $this->input->post('alias'),
			'year_established' => $this->input->post('year_established'),
			'govt_agency_registered' => $this->input->post('govt_agency_registered'),
			'address' => $this->input->post('address'),
			'telephone' => $this->input->post('telephone'),
			'fax' => $this->input->post('fax'),
			'email' => $this->input->post('email'),
			'website' => $this->input->post('website'),
			'signatory_name' => $this->input->post('signatory_name'),
			'signatory_position' => $this->input->post('signatory_position'),
			'contact_person' => $this->input->post('contact_person'),
			'contact_position' => $this->input->post('contact_position'),
			'contact_address' => $this->input->post('contact_address'),
			'contact_phone' => $this->input->post('contact_phone'),
			'contact_email' => $this->input->post('contact_email'),
			'remarks' => $this->input->post('remarks')
		);
		
		return $this->db->insert('proponents', $data);
		
	}

	public function update_proponent($proponent_id = NULL)
	{
		$this->load->helper('url');
		
		$data = array(
			'organization_name' => $this->input->post('organization_name'),
			'alias' => $this->input->post('alias'),
			'year_established' => $this->input->post('year_established'),
			'govt_agency_registered' => $this->input->post('govt_agency_registered'),
			'address' => $this->input->post('address'),
			'telephone' => $this->input->post('telephone'),
			'fax' => $this->input->post('fax'),
			'email' => $this->input->post('email'),
			'website' => $this->input->post('website'),
			'signatory_name' => $this->input->post('signatory_name'),
			'signatory_position' => $this->input->post('signatory_position'),
			'contact_person' => $this->input->post('contact_person'),
			'contact_position' => $this->input->post('contact_position'),
			'contact_address' => $this->input->post('contact_address'),
			'contact_phone' => $this->input->post('contact_phone'),
			'contact_email' => $this->input->post('contact_email'),
			'remarks' => $this->input->post('remarks')
		);
		
		$proponent_id = $this->input->post('proponent_id');
		$this->db->where('proponent_id', $proponent_id);
		return $this->db->update('proponents', $data);
		
	}
	
	public function get_proponent_projects($proponent_id = NULL)
	{
		$query = $this->db->get_where('projects', array('proponent_id' => $proponent_id));
		return $query->result_array();
	}

	public function dupe_check($key)
	{
		$this->db->where('organization_name',$key);
		$query = $this->db->get('proponents');
		if ($query->num_rows() > 0) 
		{
			return TRUE;	
		}
		else
		{
			return FALSE;
		}
	}
	
}
