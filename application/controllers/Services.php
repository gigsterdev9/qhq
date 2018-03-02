<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Services extends CI_Controller {

        public function __construct() {

				parent::__construct();
				$this->load->model('beneficiaries_model');
				$this->load->model('services_model');
				$this->load->model('nonvoters_model');
				$this->load->model('rvoters_model');
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
						case 'type':
							$type = $this->input->post('filter_by_type');
							$data['r_services'] = $this->services_model->get_r_services($config["per_page"], $page, "service_type = '$type'");
							$data['n_services'] = $this->services_model->get_n_services($config["per_page"], $page, "service_type = '$type'");
							$data['filterval'] = array('service type',$type); 
							break;
						case 'brgy': 
							$brgy = $this->input->post('filter_by_brgy');
							$data['r_services'] = $this->services_model->filter_r_services('rvoters.barangay', $brgy, $config["per_page"], $page);
							$data['n_services'] = $this->services_model->filter_n_services('non_voters.barangay', $brgy, $config["per_page"], $page);
							$data['filterval'] = array('barangay',$brgy); 
							break;
						case 'district': 
							$district = $this->input->post('filter_by_district');
							$data['r_services'] = $this->services_model->filter_r_services('rvoters.district', $district, $config["per_page"], $page);
							$data['n_services'] = $this->services_model->filter_n_services('non_voters.district', $district, $config["per_page"], $page);
							$data['filterval'] = array('district',$district); 
							break;
						case 'date_single':
							$date_single = $this->input->post('date_single');
							$data['r_services'] = $this->services_model->get_r_services($config["per_page"], $page, "req_date = '$date_single'");
							$data['n_services'] = $this->services_model->get_n_services($config["per_page"], $page, "req_date = '$date_single'");
							break;
						case 'date_range':
							$date_range = $this->input->post('date_range');
							break;
						default: 
							break;

					}
					$r_count = (!empty($data['r_services'])) ? count($data['r_services']) : 0;
					$n_count = (!empty($data['n_services'])) ? count($data['n_services']) : 0;

						$config['total_rows'] = $r_count + $n_count;
						$this->pagination->initialize($config);
					$data['links'] = $this->pagination->create_links();
					$data['total_result_count'] = $r_count + $n_count;

				}
				elseif ($this->input->get('search_param') != NULL) {

					$search_param = $this->input->get('search_param');
					$s_key = $this->input->get('s_key'); 
					
					if (!empty($s_key)) {

						//sort the search key and values
						if (in_array('s_name', $s_key) && !in_array('s_address', $s_key)) {
							$where_clause = "lname like '%$search_param%' or fname like '%$search_param%'";
						}
						elseif (!in_array('s_name', $s_key) && in_array('s_address', $s_key)) {
							$where_clause = "address like '%$search_param%'";		
						}
						elseif (in_array('s_name', $s_key) && in_array('s_address', $s_key)) {
							$where_clause = "lname like '%$search_param%' or fname like '%$search_param%' or address like '%$search_param%'";
						}
						else{
							$where_clause = '1';
						}
						
						$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
						//$data['nonvoters'] = $this->beneficiaries_model->search_beneficiaries($config["per_page"], $page, $search_param, $search_key);
						$data['r_services'] = $this->services_model->search_r_services($config["per_page"], $page, $where_clause);
						$data['n_services'] = $this->services_model->search_n_services($config["per_page"], $page, $where_clause);
						
						$r_count = (!empty($data['r_services'])) ? count($data['r_services']) : 0;
						$n_count = (!empty($data['n_services'])) ? count($data['n_services']) : 0;

							$config['total_rows'] = $r_count + $n_count;
							$this->pagination->initialize($config);
						$data['links'] = $this->pagination->create_links();
						$data['searchval'] = $search_param;
						$data['total_result_count'] = $r_count + $n_count;
					}
					else {
						$data['nonvoters']['result_count'] = 0;
						$data['links'] = '';
					}

				}
				else{

					//Display registered first, non-voters next
					//implement pagination
					$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
					$r_s = $this->services_model->get_r_services($config["per_page"], $page); 
						foreach ($r_s as $s) {
							if (is_array($s)) { //do not display 'result_count' 
								$data['r_services'][] = $s;
							}
						}
					$n_s = $this->services_model->get_n_services($config["per_page"], $page);
						foreach ($n_s as $s) {
							if (is_array($s)) { //do not display 'result_count' 
								$data['n_services'][] = $s;
							}
						}
					$data['total_result_count'] = count($data['n_services']) + count($data['r_services']);
						$config['total_rows'] = $data['total_result_count'];
						$this->pagination->initialize($config);
					$data['links'] = $this->pagination->create_links();

				}
                
                $data['title'] = 'Service Beneficiaries';

				$this->load->view('templates/header', $data);
				$this->load->view('services/index', $data);
				$this->load->view('templates/footer');
				
				//$this->output->cache(1);
				//$this->output->delete_cache();
				
        }

        public function view($id = NULL) {

			//retrieve service availment details
			$data['service'] = $this->services_model->get_service_by_id($id);
			//retrieve availment history data
				$ben_id = $data['service']['ben_id'];
			$data['services'] = $this->services_model->get_services_by_id($ben_id);
			//retrieve audit trail
			//$data['tracker'] = $this->rvoters_model->show_activities($id);
			$data['tracker'] = 0;

			
			$this->load->view('templates/header', $data);
			$this->load->view('services/view', $data);
			$this->load->view('templates/footer');


		}
        
        
        public function add() {
			if (!$this->ion_auth->in_group('admin')) {
				redirect('services');
			}
			
			$this->load->helper('form');
			$this->load->library('form_validation');

			$data['title'] = 'New service';

			//get all possible requestors from within the beneficiaries table 
			$rv_req = $this->beneficiaries_model->get_rv_beneficiaries();
			$nv_req = $this->beneficiaries_model->get_nv_beneficiaries();

			$ctr = 0;
			foreach ($rv_req as $rv) {
				$data['requestors'][$ctr]['fullname'] = $rv['fname'].' '.$rv['mname'].' '.$rv['lname'];
				$data['requestors'][$ctr]['ben_id'] = $rv['ben_id'];
				$ctr++;
			}
			foreach ($nv_req as $nv) {
				$data['requestors'][$ctr]['fullname'] = $nv['fname'].' '.$nv['mname'].' '.$nv['lname'];
				$data['requestors'][$ctr]['ben_id'] = $nv['ben_id'];
				$ctr++;
			}

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


		public function add_exist($ben_id = FALSE) { 
		
			if (!$this->ion_auth->in_group('admin')) {
				redirect('services'); 
			}

			$this->load->helper('form');
			$this->load->library('form_validation');

			$data['title'] = 'New availment';
			$data['ben_id'] = $ben_id;
		
			//get all possible requestors from within the beneficiaries table 
			$rv_req = $this->beneficiaries_model->get_rv_beneficiaries();
			$nv_req = $this->beneficiaries_model->get_nv_beneficiaries();

			$ctr = 0;
			foreach ($rv_req as $rv) {
				$data['requestors'][$ctr]['fullname'] = $rv['fname'].' '.$rv['mname'].' '.$rv['lname'];
				$data['requestors'][$ctr]['ben_id'] = $rv['ben_id'];
				$ctr++;
			}
			foreach ($nv_req as $nv) {
				$data['requestors'][$ctr]['fullname'] = $nv['fname'].' '.$nv['mname'].' '.$nv['lname'];
				$data['requestors'][$ctr]['ben_id'] = $nv['ben_id'];
				$ctr++;
			}

				
			$ben = $this->beneficiaries_model->get_beneficiary_by_id($ben_id);
			
			if (isset($ben['nv_id']) && $ben['nv_id'] != '') { //then entry must be a non voter
				$nv_details = $this->nonvoters_model->get_nonvoter_by_id($ben['nv_id']); 
				$data['recipient_fullname'] = $nv_details['fname'].' '.$nv_details['mname'].' '.$nv_details['lname'];
			}

			if (isset($ben['id_no_comelec']) && $ben['id_no_comelec']!= '') { //then entry must be a registered voter
				$rv_details = $this->rvoters_model->get_rvoter_by_comelec_id($ben['id_no_comelec']);
				$data['recipient_fullname'] = $rv_details['fname'].' '.$rv_details['mname'].' '.$rv_details['lname'];
			}
			
			//availment data validation
			$this->form_validation->set_rules('req_date','Request date','required');
			$this->form_validation->set_rules('ben_id','Recipient ID','required');
			$this->form_validation->set_rules('req_ben_id','Requestor','required');
			$this->form_validation->set_rules('service_type','Type','required');
			$this->form_validation->set_rules('particulars','Particulars','required');
			$this->form_validation->set_rules('s_status','Request status','required');

			if ($this->form_validation->run() === FALSE) {
				$this->load->view('templates/header', $data);
				$this->load->view('services/add_exist');
				$this->load->view('templates/footer');

			}
			else {
				
				//insert into services table
				$this->services_model->set_service();
				$data['alert_success'] = 'New entry created.';
				$data['ben_id'] = $this->input->post('ben_id'); //for some reason $data['ben_id'] becomes null so need to reset the value

				$this->load->view('templates/header', $data);
				$this->load->view('services/add_exist');
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
