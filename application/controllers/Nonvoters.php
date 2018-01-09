<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Nonvoters extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('nonvoters_model');
                $this->load->helper('url');
                $this->load->helper('form');
				$this->load->library('ion_auth');
				$this->load->library('pagination');
                
                
                
                if (!$this->ion_auth->logged_in())
				{
					redirect('auth/login');
				}
				
				//debug
				//$this->output->enable_profiler(TRUE);
				
				/*
				$username = 'qseq';
				$password = 'test';
				$email = 'pj.villarta@gmail.com';
				$additional_data = array(
								'first_name' => 'QSec',
								'last_name' => 'QHQ',
								);
				$group = array('1'); // Sets user to admin.

				$this->ion_auth->register($username, $password, $email, $additional_data, $group);
				
				$id = 2;
				$data = array(
							'username' => 'secretariat'
							 );
				$this->ion_auth->update($id, $data);
				/**/
				
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

                $data['nonvoter'] = $this->nonvoters_model->get_nonvoter_by_id($id);
                if (empty($data['nonvoter'])) {
				    show_404();
				}

				$data['tracker'] = $this->nonvoters_model->show_activities($id);
                $id = $data['nonvoter']['nv_id'];
				
				$this->load->view('templates/header', $data);
				$this->load->view('nonvoters/view', $data);
				$this->load->view('templates/footer');
				
        }
        
        
        public function add() {
			if (!$this->ion_auth->in_group('admin')) {
				redirect('rvoters');
			}
			
			$this->load->helper('form');
			$this->load->library('form_validation');

			//$data['nonvoters'] = $this->nonvoters_model->get_nonvoters();
			$data['title'] = 'New registered voter';

			//validation rules
			$this->form_validation->set_rules('code', 'Code', 'required|is_unique[rvoters.code]');
			$this->form_validation->set_rules('id_no', 'ID No.', 'required|is_unique[rvoters.id_no]');
			$this->form_validation->set_rules('id_no_comelec', 'Comelec ID No.', 'required|is_unique[rvoters.id_no_comelec]');
			$this->form_validation->set_rules('fname', 'First Name', 'required');
			$this->form_validation->set_rules('mname', 'Middle Name', 'required');
			$this->form_validation->set_rules('lname', 'Last Name', 'required');
			$this->form_validation->set_rules('dob', 'Birthdate', 'required');
			$this->form_validation->set_rules('address', 'Address', 'required');
			$this->form_validation->set_rules('barangay', 'Barangay', 'required');
			$this->form_validation->set_rules('district', 'District', 'required');
			$this->form_validation->set_rules('sex', 'Sex', 'required');
			$this->form_validation->set_rules('email', 'Email', 'valid_email');
			
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('templates/header', $data);
				$this->load->view('nonvoters/add');
				$this->load->view('templates/footer');

			}
			else
			{
				//execute insert
				$this->nonvoters_model->set_rvoter();
				
				$data['title'] = 'Registered voter entry.';
				$data['alert_success'] = 'Entry successful.';
				
				$this->load->view('templates/header', $data);
				$this->load->view('nonvoters/add');
				$this->load->view('templates/footer');
			}
		}
		
		
		
		public function edit($id = NULL) {

			if (!$this->ion_auth->in_group('admin')) {
				redirect('rvoters');
			}
			
			$this->load->helper('form');
			$this->load->library('form_validation');

			$data['title'] = 'Edit registered voter details';
			$data['id'] = $id;

			//validation rules
			$this->form_validation->set_rules('code', 'Code', 'required');
			$this->form_validation->set_rules('id_no', 'ID No.', 'required');
			$this->form_validation->set_rules('id_no_comelec', 'Comelec ID No.', 'required');
			$this->form_validation->set_rules('fname', 'First Name', 'required');
			$this->form_validation->set_rules('lname', 'Last Name', 'required');
			$this->form_validation->set_rules('dob', 'Birthdate', 'required');
			$this->form_validation->set_rules('address', 'Address', 'required');
			$this->form_validation->set_rules('barangay', 'Barangay', 'required');
			$this->form_validation->set_rules('district', 'District', 'required');
			$this->form_validation->set_rules('sex', 'Sex', 'required');
			$this->form_validation->set_rules('email', 'Email', 'valid_email');

			//upon submission of edit action
			if ($this->input->post('action') == 1) {
				
				if ($this->form_validation->run() === FALSE) {
					
					$data['rvoter'] = $this->nonvoters_model->get_nonvoter_by_id($id);
					
					$this->load->view('templates/header', $data);
					$this->load->view('nonvoters/edit');
					$this->load->view('templates/footer');
	
				}
				else {
					//execute data update
					$this->nonvoters_model->update_rvoter();
					//retrieve updated data
					$data['rvoter'] = $this->nonvoters_model->get_nonvoter_by_id($this->input->post('id'));
					
					if ( $this->input->post('trash') == 1) {
						$data['alert_trash'] = 'Marked for deletion. This is your last chance to undo by unchecking the "Delete this entry" box below and clicking submit.<br />';
					}
					else {
						$data['alert_success'] = 'Voter entry updated.';
					}
					
					$this->load->view('templates/header', $data);
					$this->load->view('nonvoters/edit');
					$this->load->view('templates/footer');
				}
				
			}
			else{
				$data['rvoter'] = $this->nonvoters_model->get_nonvoter_by_id($id);
				
				if (empty($data['rvoter'])) {
					show_404();
				}

				$this->load->view('templates/header', $data);
				$this->load->view('nonvoters/edit');
				$this->load->view('templates/footer');
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
