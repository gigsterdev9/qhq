<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Services extends CI_Controller {

        public function __construct() {

				parent::__construct();
				$this->load->model('services_model');
				$this->load->model('nonvoters_model');
				$this->load->model('rvoters_model');
				$this->load->model('beneficiaries_model');
                $this->load->helper('url');
                $this->load->helper('form');
				$this->load->library('ion_auth');
				$this->load->library('pagination');
                
                if (!$this->ion_auth->logged_in())
				{
					redirect('auth/login');
				}

				//$this->output->enable_profiler(TRUE);	
				
        }

        public function index() {		
        
        	//if ($_SERVER['REMOTE_ADDR'] <> '125.212.122.21') die('Undergoing maintenance.');
			
			//set general pagination config
			$config = array();
			$config['base_url'] = base_url() . 'services';
			
			$config['per_page'] = 100;
			$config['uri_segment'] = 2;
			$config['cur_tag_open'] = '<span>';
			$config['cur_tag_close'] = '</span>';
			$config['prev_link'] = '&laquo;';
			$config['next_link'] = '&raquo;';
			$config['reuse_query_string'] = TRUE; 
			$config["num_links"] = 9;

				if ($this->input->post('filter_by') != NULL) {

					$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
					$filter_by = $this->input->post('filter_by');
					switch ($filter_by) {
						case 'brgy': 
							$brgy = $this->input->post('filter_by_brgy');
							$data['services'] = $this->services_model->filter_services('barangay', $brgy, $config["per_page"], $page);
							$data['record_count'] = $this->services_model->filter_services_num_rows('barangay', $brgy);
							$data['filterval'] = array('barangay',$brgy); 
							break;
						case 'district': 
							$district = $this->input->post('filter_by_district');
							$data['services'] = $this->services_model->filter_services('district', $district, $config["per_page"], $page);
							$data['record_count'] = $this->services_model->filter_services_num_rows('district', $district);
							$data['filterval'] = array('district',$district); 
							break;
						case 'gender': 
							$gender = $this->input->post('filter_by_gender');
							$data['services'] = $this->services_model->filter_services('sex', $gender, $config["per_page"], $page);
							$data['record_count'] = $this->services_model->filter_services_num_rows('sex', $gender);
							$data['filterval'] = array('gender',$gender); 
							break;
						default: 
							break;

					}
					
					$config['total_rows'] = $data['record_count'];
						$this->pagination->initialize($config);
					$data['links'] = $this->pagination->create_links();
					
				}
				elseif ($this->input->post('search_param') != NULL)
				{
					//$data['services'] = array(1, 2, 3);
					$search_param = $this->input->post('search_param');
					$data['services'] = $this->services_model->search_services($search_param);
					$data['searchval'] = $search_param;
				}
				else
				{
					//Display all
					//implement pagination
					$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
					$data['n_services'] = $this->services_model->get_n_services($config["per_page"], $page);
					$data['r_services'] = $this->services_model->get_r_services($config["per_page"], $page); 
					$data['record_count'] = $this->services_model->record_count();
						$config['total_rows'] = $data['record_count'];
						$this->pagination->initialize($config);
					$data['links'] = $this->pagination->create_links();
				}
                
                $data['title'] = 'Service Beneficiaries';

				$this->load->view('templates/header', $data);
				$this->load->view('services/index', $data);
				$this->load->view('templates/footer');
				
				//$this->output->cache(1);
				$this->output->delete_cache();
				
        }

        public function view($id = NULL) {
			//essentially classifies a beneficiary as either a registered voter or a non-voter and loads the appropriate viewing pages 

			$ben = $this->beneficiaries_model->get_beneficiary_by_id($id);
			if (empty($ben)) {
				show_404();
			}
			else{
				//echo '<pre>'; print_r($ben); echo '</pre>'; die();
				if ($ben['id_no_comelec'] != '') { //then entry must be a registered voter
					$data['rvoter'] = $this->rvoters_model->get_rvoter_by_comelec_id($ben['id_no_comelec']);
					$data['tracker'] = $this->rvoters_model->show_activities($data['rvoter']['id']);
				
					$this->load->view('templates/header', $data);
					$this->load->view('rvoters/view', $data);
					$this->load->view('templates/footer');	
				}
				elseif ($ben['nv_id'] != ''){ //then entry must be a non voter
					$data['nonvoter'] = $this->nonvoters_model->get_nonvoter_by_id($ben['nv_id']);
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
        
        
        public function add() {
			if (!$this->ion_auth->in_group('admin'))
			{
				redirect('services');
			}
			
			$this->load->helper('form');
			$this->load->library('form_validation');

			$data['schools'] = $this->services_model->get_schools(); //display school names in filter dropdown
			$data['title'] = 'New service';

			//primary service data
			$this->form_validation->set_rules('batch','Batch','required');
			$this->form_validation->set_rules('school_id','School ID','required');
			$this->form_validation->set_rules('course','Course','required');
			$this->form_validation->set_rules('service_status','service status','required');
			
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('templates/header', $data);
				$this->load->view('services/add');
				$this->load->view('templates/footer');

			}
			else
			{
				echo '<pre>'; print_r($_POST); echo '</pre>'; 
				
				//insert into services table
				$this->services_model->set_service();
				$data['alert_success'] = 'New entry created.';
				
				$this->load->view('templates/header', $data);
				$this->load->view('services/add');
				$this->load->view('templates/footer');
			}

		}
		
		
		
		public function edit($service_id = NULL) {
			
			if (!$this->ion_auth->in_group('admin')) {
				redirect('services'); 
			}

			$this->load->helper('form');
			$this->load->library('form_validation');

			$data['title'] = 'Edit service';
			$data['schools'] = $this->services_model->get_schools(); //display school names in filter dropdown
			$data['service_id'] = $service_id;

			$sch = $this->services_model->get_service_by_id($service_id);
			if (empty($sch))
			{
					show_404();
			}
			else{
				if ($sch['id_no_comelec'] != '') { //then entry must be a registered voter
					$data['service'] = $this->services_model->get_r_service_by_id($service_id);
				}
				elseif ($sch['nv_id'] != ''){ //then entry must be a non voter
					$data['service'] = $this->services_model->get_n_service_by_id($service_id);
				}
				else{
					show_404();
				}
			}


			//service data
			$this->form_validation->set_rules('batch','Batch','required');
			$this->form_validation->set_rules('school_id','School ID','required');
			$this->form_validation->set_rules('course','Course','required');
			$this->form_validation->set_rules('service_status','service Status','required');
			
			//upon submission of edit action
			if ($this->input->post('action') == 1) {
				
				if ($this->form_validation->run() === FALSE) {
					
					$data['service'] = $this->services_model->get_service_by_id($service_id);
					
					$this->load->view('templates/header', $data);
					$this->load->view('services/edit');
					$this->load->view('templates/footer');
	
				}
				else {
					//execute data update
					$this->services_model->update_service($service_id);
					//retrieve updated data
					$data['service'] = $this->services_model->get_service_by_id($service_id);
					
					if ( $this->input->post('trash') == 1) {
						$data['alert_trash'] = 'Marked for deletion. This is your last chance to undo by unchecking the "Delete this entry" box below and clicking submit.<br />';
					}
					else {
						$data['alert_success'] = 'Entry updated.';
					}
					
					$this->load->view('templates/header', $data);
					$this->load->view('services/edit');
					$this->load->view('templates/footer');
				}
				
			}
			else{
				$data['service'] = $this->services_model->get_service_by_id($service_id);
				
				if (empty($data['service'])) {
					show_404();
				}

				$this->load->view('templates/header', $data);
				$this->load->view('services/edit');
				$this->load->view('templates/footer');
			}
		
		}


		public function add_term($id = FALSE) {
			if (!$this->ion_auth->in_group('admin')) {
				redirect('services'); 
			}

			$this->load->helper('form');
			$this->load->library('form_validation');

			//$data['services'] = $this->services_model->get_services();
			$data['title'] = 'New service term';
			$data['service_id'] = $id;

			//term data
			$this->form_validation->set_rules('year_level','Year Level','required');
			$this->form_validation->set_rules('school_year','School Year','required');
			$this->form_validation->set_rules('guardian_combined_income','Parent/Guardian Combined Income','required');

			if ($this->form_validation->run() === FALSE) {
				$this->load->view('templates/header', $data);
				$this->load->view('services/add_term');
				$this->load->view('templates/footer');

			}
			else {
				//echo '<pre>'; print_r($_POST); echo '</pre>'; 
				
				//insert into services table
				$this->services_model->set_service_term();
				$data['s_id'] = $this->input->post('service_id');
				$data['alert_success'] = 'New entry created.';
				
				$this->load->view('templates/header', $data);
				$this->load->view('services/add_term');
				$this->load->view('templates/footer');
			}
			
		}

		public function edit_term($s_id = FALSE, $t_id = FALSE) {
			if (!$this->ion_auth->in_group('admin')) {
				redirect('services'); 
			}
			//echo $s_id.' - '.$t_id;

			$this->load->helper('form');
			$this->load->library('form_validation');

			//$data['services'] = $this->services_model->get_services();
			$data['title'] = 'Edit service term details';
			$data['s_id'] = $s_id;
			$data['t_id'] = $t_id;
			$data['s_term'] = $this->services_model->get_single_term_details($t_id);

			//term data
			$this->form_validation->set_rules('year_level','Year Level','required');
			$this->form_validation->set_rules('school_year','School Year','required');
			$this->form_validation->set_rules('guardian_combined_income','Parent/Guardian Combined Income','required');

			if ($this->form_validation->run() === FALSE) {
				$this->load->view('templates/header', $data);
				$this->load->view('services/edit_term');
				$this->load->view('templates/footer');

			}
			else {
				//echo '<pre>'; print_r($_POST); echo '</pre>'; 
				
				//insert into services table
				$this->services_model->update_service_term();
				$data['alert_success'] = 'Entry updated.';
				$data['s_id'] = $this->input->post('service_id');
				
				$this->load->view('templates/header', $data);
				$this->load->view('services/edit_term');
				$this->load->view('templates/footer');
			}
			
		}

		public function rem_term($s_id = FALSE, $t_id = FALSE) {
			if (!$this->ion_auth->in_group('admin')) {
				redirect('services'); 
			}

			//echo $s_id.' - '.$t_id;
			$this->services_model->trash_term($s_id, $t_id);
			redirect('services/view/'.$s_id);

		}
		
		public function all_to_excel() {
        //export all data to Excel file
        
        	$this->load->library('export');
			$sql = $this->services_model->get_services();
			$this->export->to_excel($sql, 'allservices'); 
	
			//$this->output->enable_profiler(TRUE);	
        }
        
        public function filtered_to_excel() {
        	$this->load->library('export');
        	
        	$filter = $this->uri->uri_to_assoc(3);
        	//echo '<pre>'; print_r($filter); echo '</pre>';
        	$field = key($filter);
        	$value = $filter[key($filter)];
        	$sql = $this->services_model->filter_services($field, $value);
			//echo '<pre>'; print_r($sql); echo '</pre>';
			$filename = 'filtered_'.$field.'_'.$value.'_'.date('Y-m-d-Hi');
			echo $filename;
			$this->export->to_excel($sql, $filename); 
	
			//$this->output->enable_profiler(TRUE);	
        }
        
        public function results_to_excel() {
        	$this->load->library('export');
        	
        	$search = $this->uri->segment(3);
			//echo $search;
        	$sql = $this->services_model->search_services($search);
			$filename = 'results_'.$search.'_'.date('Y-m-d-Hi');
			//echo $filename;
			$this->export->to_excel($sql, $filename); 
	
        }
		
			
}
