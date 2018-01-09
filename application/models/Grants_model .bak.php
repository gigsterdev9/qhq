<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class grants_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
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
		
	public function set_grants()
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

}
