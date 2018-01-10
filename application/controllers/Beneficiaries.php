<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Beneficiaries extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
				$this->load->model('beneficiaries_model');
				$this->load->model('rvoters_model');
				$this->load->model('nonvoters_model');
                $this->load->helper('url');
                $this->load->helper('form');
				$this->load->library('ion_auth');
				$this->load->library('pagination');
                
                
                
                if (!$this->ion_auth->logged_in())
				{
					redirect('auth/login');
				}
				
        }

        public function index() {		
		
			//if ($_SERVER['REMOTE_ADDR'] <> '125.212.122.21') die('Undergoing maintenance.');

			//set general pagination config
			$config = array();
			$config['base_url'] = base_url() . 'rvoters';
			
			$config['per_page'] = 100;
			$config['uri_segment'] = 2;
			$config['cur_tag_open'] = '<span>';
			$config['cur_tag_close'] = '</span>';
			$config['prev_link'] = '&laquo;';
			$config['next_link'] = '&raquo;';
			$config['reuse_query_string'] = TRUE; 
			$config["num_links"] = 9;
			

				if ($this->input->get('filter_by') != NULL) {
					$filter_by = $this->input->get('filter_by');
					switch ($filter_by) 
					{
						case 'brgy': 
							$brgy = $this->input->get('filter_by_brgy');
							$data['filterval'] = array('barangay',$brgy,''); //the '' is to factor in the 3rd element introduced by the age filter
							$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
							$data['nonvoters'] = $this->nonvoters_model->filter_rvoters($config["per_page"], $page, 'barangay',$brgy);
								$config['total_rows'] = $data['nonvoters']['result_count'];
								$this->pagination->initialize($config);
							$data['links'] = $this->pagination->create_links();
							break;
						case 'district':
							$district = $this->input->get('filter_by_district');
							$data['filterval'] = array('district',$district,''); //the '' is to factor in the 3rd element introduced by the age filter
							$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
							$data['nonvoters'] = $this->nonvoters_model->filter_rvoters($config["per_page"], $page, 'district',$district);
								$config['total_rows'] = $data['nonvoters']['result_count'];
								$this->pagination->initialize($config);
							$data['links'] = $this->pagination->create_links();
							break;
						case 'age':
							$age_operand = $this->input->get('filter_by_age_operand');
							$age_value = $this->input->get('filter_by_age_value');

							if ($age_operand == 'between' and stristr($age_value, 'and') == FALSE) {
								$data['nonvoters']['result_count'] = 0;
								$data['nonvoters']['result_count'] = 0;
								$data['links'] = '';
								break;
							}

							$data['filterval'] = array('age',$age_operand, $age_value);
							$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
							$data['nonvoters'] = $this->nonvoters_model->filter_rvoters($config["per_page"], $page, 'age',$age_value, $age_operand);
								$config['total_rows'] = $data['nonvoters']['result_count'];
								$this->pagination->initialize($config);
							$data['links'] = $this->pagination->create_links();
							break;
						default: 
							break;
					}
					
				}
				elseif ($this->input->get('search_param') != NULL) {
					
					$search_param = $this->input->get('search_param');
					$search_key = $this->input->get('s_key'); 

					if (!empty($search_key)) {
						$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
						$data['nonvoters'] = $this->nonvoters_model->search_rvoters($config["per_page"], $page, $search_param, $search_key);
							$config['total_rows'] = $data['nonvoters']['result_count'];
							$this->pagination->initialize($config);
						$data['links'] = $this->pagination->create_links();
						$data['searchval'] = $search_param;
					}
					else {
						$data['nonvoters']['result_count'] = 0;
						$data['links'] = '';
					}
				}
				else{
					//Display all
					//implement pagination
					$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
					$data['nonvoters'] = $this->nonvoters_model->get_nonvoters($config["per_page"], $page);
					$data['nonvoters']['result_count'] = $this->nonvoters_model->record_count();
						$config['total_rows'] = $data['nonvoters']['result_count'];
						$this->pagination->initialize($config);
					$data['links'] = $this->pagination->create_links();
				}
				
                $data['title'] = 'Master List';
				//echo '<pre>'; print_r($data); echo '</pre>';
				$this->load->view('templates/header', $data);
				$this->load->view('nonvoters/index', $data);
				$this->load->view('templates/footer');
				
        }

        public function view($id = NULL) {
		//essentially classifies a beneficiary as either a registered voter or a non-voter and loads the appropriate viewing pages 

                $beneficiary = $this->beneficiaries_model->get_beneficiary_by_id($id);
                if (empty($beneficiary)) {
				    show_404();
				}
				else{
					//echo '<pre>'; print_r($beneficiary); echo '</pre>'; die();
					if ($beneficiary['id_no_comelec'] != '') { //then entry must be a registered voter
						$data['rvoter'] = $this->rvoters_model->get_beneficiary_by_comelec_id($id);
						$data['tracker'] = $this->rvoters_model->show_activities($data['rvoter']['id']);
					
						$this->load->view('templates/header', $data);
						$this->load->view('nonvoters/view', $data);
						$this->load->view('templates/footer');	
					}
					elseif ($beneficiary['nv_id'] != ''){ //then entry must be a non voter
						$data['nonvoter'] = $this->nonvoters_model->get_nonvoter_by_id($id);
						$data['tracker'] = $this->nonvoters_model->show_activities($id);
                	
						$this->load->view('templates/header', $data);
						$this->load->view('nonvoters/view', $data);
						$this->load->view('templates/footer');		
					}
					else{
						show_404();
					}
				}
				
        }
        
      	public function all_to_excel() {
        //export all data to Excel file
        
        	$this->load->library('export');
			$sql = $this->nonvoters_model->get_grants();
			$this->export->to_excel($sql, 'allgrants'); 
			
        }
        
        public function filtered_to_excel() {
        	$this->load->library('export');
        	
        	$filter = $this->uri->uri_to_assoc(3);
        	//echo '<pre>'; print_r($filter); echo '</pre>';
        	$field = key($filter);
        	$value = $filter[key($filter)];
        	$sql = $this->nonvoters_model->filter_grants($field, $value);
			//echo '<pre>'; print_r($sql); echo '</pre>';
			$filename = 'filtered_'.$field.'_'.$value.'_'.date('Y-m-d-Hi');
			echo $filename;
			$this->export->to_excel($sql, $filename); 
	
			
        }
        
        public function results_to_excel() {
        	$this->load->library('export');
        	
        	$search = $this->uri->segment(3);
			//echo $search;
        	$sql = $this->nonvoters_model->search_grants($search);
			$filename = 'results_'.$search.'_'.date('Y-m-d-Hi');
			//echo $filename;
			$this->export->to_excel($sql, $filename); 
	
        }
	
	
}
