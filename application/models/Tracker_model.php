<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class tracker_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}
    
    
    public function record_count() {
        return $this->db->count_all('audit_trail');
    }

    
    public function log_event($activity, $mod_details) {

        $user = $this->ion_auth->user()->row();
		$data = array(
					'user' => $user->username,
					'activity' => $activity,
					'mod_details' => $mod_details
				);
        $this->db->insert('audit_trail', $data);
        
        return;
    }
    
    public function get_all_activities() {
        
        $this->db->select('*');
        $this->db->from('audit_trail');
        $this->db->order_by('timestamp', 'desc');
        $query = $this->db->get();	

        $activities = $query->result_array();

        return $activities;

    }

	// this is the refactored tracker that consolidates all requests from the major tables into 1
	public function get_activities($id, $module = 'beneficiaries') {
        //echo $module; echo $id;
        switch ($module) {
            
            case 'rvoters':
                $this->db->select('*');
                $this->db->from('audit_trail');
                $this->db->order_by('timestamp', 'desc');
                $this->db->where("id_no_comelec = '$id' and activity = 'modified'");
                $this->db->limit(5);
                $query = $this->db->get();		
                
                $tracker['modified'] = $query->result_array();	
                
                $this->db->select('*');
                $this->db->from('audit_trail');
                $this->db->where("id_no_comelec = '$id' and activity = 'created'");
                $query = $this->db->get();		
                
                $tracker['created'] = $query->row_array();	

                break;
            
            case 'nvoters':
                $this->db->select('*');
                $this->db->from('audit_trail');
                $this->db->order_by('timestamp', 'desc');
                $this->db->where("nv_id = '$id' and activity = 'modified'");
                $this->db->limit(5);
                $query = $this->db->get();		
                
                $tracker['modified'] = $query->result_array();	
                
                $this->db->select('*');
                $this->db->from('audit_trail');
                $this->db->where("nv_id = '$id' and activity = 'created'");
                $query = $this->db->get();		
                
                $tracker['created'] = $query->row_array();	

                break;

            case 'scholarships':
                $this->db->select('*');
                $this->db->from('audit_trail');
                $this->db->order_by('timestamp', 'desc');
                $this->db->where("scholarship_id = '$id' and activity = 'modified'");
                $this->db->limit(5);
                $query = $this->db->get();		
                
                $tracker['modified'] = $query->result_array();	
                
                $this->db->select('*');
                $this->db->from('audit_trail');
                $this->db->where("scholarship_id = '$id' and activity = 'created'");
                $query = $this->db->get();		
                
                $tracker['created'] = $query->row_array();	

                break;

            case 'services':
                $this->db->select('*');
                $this->db->from('audit_trail');
                $this->db->order_by('timestamp', 'desc');
                $this->db->where("service_id = '$id' and activity = 'modified'");
                $this->db->limit(5);
                $query = $this->db->get();		
                
                $tracker['modified'] = $query->result_array();	
                
                $this->db->select('*');
                $this->db->from('audit_trail');
                $this->db->where("service_id = '$id' and activity = 'created'");
                $query = $this->db->get();		
                
                $tracker['created'] = $query->row_array();	

                break;

            default: 

                $this->db->select('*');
                $this->db->from('audit_trail');
                $this->db->order_by('timestamp', 'desc');
                $this->db->where("ben_id = '$id' and activity = 'modified'");
                $this->db->limit(5);
                $query = $this->db->get();		
                
                $tracker['modified'] = $query->result_array();	
                
                $this->db->select('*');
                $this->db->from('audit_trail');
                $this->db->where("ben_id = '$id' and activity = 'created'");
                $query = $this->db->get();		
                
                $tracker['created'] = $query->row_array();	

                break;
        }

        return $tracker;

	}
	
	
}
