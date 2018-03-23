<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Scholarships extends CI_Controller {

        public function __construct() {
                parent::__construct();
				$this->load->model('scholarships_model');
				$this->load->model('nonvoters_model');
				$this->load->model('rvoters_model');
				$this->load->model('beneficiaries_model');
				$this->load->model('tracker_model');
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
			$config['base_url'] = base_url() . 'scholarships';
			
			$config['per_page'] = 100;
			$config['uri_segment'] = 2;
			$config['cur_tag_open'] = '<span>';
			$config['cur_tag_close'] = '</span>';
			$config['prev_link'] = '&laquo;';
			$config['next_link'] = '&raquo;';
			$config['reuse_query_string'] = TRUE; 
			$config["num_links"] = 9;

			$data['schools'] = $this->scholarships_model->get_schools(); //display school names in filter dropdown

			if ($this->input->post('filter_by') != NULL) {

				$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
				$filter_by = $this->input->post('filter_by');
				switch ($filter_by) {
					case 'brgy': 
						$brgy = $this->input->post('filter_by_brgy');
						$data['filterval'] = array('barangay',$brgy); 
						$data['r_scholars'] = $this->scholarships_model->filter_r_scholarships('barangay', $brgy, $config["per_page"], $page);
						$data['n_scholars'] = $this->scholarships_model->filter_n_scholarships('barangay', $brgy, $config["per_page"], $page);
						break;
					case 'school': 
						$school = $this->input->post('filter_by_school');
						$data['r_scholars'] = $this->scholarships_model->filter_r_scholarships('schools.school_id', $school, $config["per_page"], $page);
						$data['n_scholars'] = $this->scholarships_model->filter_n_scholarships('schools.school_id', $school, $config["per_page"], $page);
						$data['filterval'] = array('school ID',$school); 
						break;
					case 'district': 
						$district = $this->input->post('filter_by_district');
						$data['r_scholars'] = $this->scholarships_model->filter_r_scholarships('district', $district, $config["per_page"], $page);
						$data['n_scholars'] = $this->scholarships_model->filter_n_scholarships('district', $district, $config["per_page"], $page);
						$data['filterval'] = array('district',$district); 
						break;
					case 'gender': 
						$gender = $this->input->post('filter_by_gender');
						$data['r_scholars'] = $this->scholarships_model->filter_r_scholarships('sex', $gender, $config["per_page"], $page);
						$data['n_scholars'] = $this->scholarships_model->filter_n_scholarships('sex', $gender, $config["per_page"], $page);
						$data['filterval'] = array('gender',$gender); 
						break;
					default: 
						break;
				}
				
				$r_count = (!empty($data['r_scholars'])) ? count($data['r_scholars']) : 0;
				$n_count = (!empty($data['n_scholars'])) ? count($data['n_scholars']) : 0;

				$config['total_rows'] = $r_count + $n_count;
					$this->pagination->initialize($config);
				$data['links'] = $this->pagination->create_links();
				$data['total_result_count'] = $r_count + $n_count;

			}
			elseif ($this->input->get('search_param') != NULL) { 
					
				$search_param = $this->input->get('search_param');
				$s_key = $this->input->get('s_key'); 
				$s_fullname = FALSE;

				if (strpos($search_param, ',')) {
					$params = explode(',', $search_param);
					$s_lname = $params[0];
					$s_fname = trim($params[1]);
					$s_fullname = TRUE;
				}
				else{
					$params = explode(' ',$search_param);
				}

				if (!empty($s_key)) {

					//initialize var
					$where_clause = '';

					//sort the search key and values
					if (in_array('s_name', $s_key) && !in_array('s_address', $s_key)) {
						
						if ($s_fullname == TRUE) {
							$where_clause .= "lname like '$s_lname%' and fname like '%$s_fname%' ";
						}
						else{
							$where_clause .= '(';
							foreach ($params as $p) {
								$where_clause .= "lname like '$p%' or fname like '$p%' ";
								if ($p != end($params)) $where_clause .= 'or ';
							}
							$where_clause .= ')';
						}
					}
					elseif (!in_array('s_name', $s_key) && in_array('s_address', $s_key)) {
						
						$where_clause = "address like '%$search_param%'";		

					}
					elseif (in_array('s_name', $s_key) && in_array('s_address', $s_key)) {
						
						$where_clause .= '(';
						foreach ($params as $p) {
							$where_clause .= "lname like '$p%' or fname like '$p%' or address like '%$p%' ";
							if ($p != end($params)) $where_clause .= 'or ';
						}
						$where_clause .= ')';
						
					}
					else{
						//do nothing
					}
					//die($where_clause);
					
					$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
					$data['r_scholars'] = $this->scholarships_model->search_r_scholarships($config["per_page"], $page, $where_clause);
					$data['n_scholars'] = $this->scholarships_model->search_n_scholarships($config["per_page"], $page, $where_clause);
						
					$r_count = (!empty($data['r_scholars'])) ? count($data['r_scholars']) : 0;
					$n_count = (!empty($data['n_scholars'])) ? count($data['n_scholars']) : 0;

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
			
				//Display all
				//implement pagination
				$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
				$data['n_scholars'] = $this->scholarships_model->get_n_scholarships($config["per_page"], $page);
				$data['r_scholars'] = $this->scholarships_model->get_r_scholarships($config["per_page"], $page); 
				$data['total_result_count'] = $this->scholarships_model->record_count();
					$config['total_rows'] = $data['total_result_count'];
					$this->pagination->initialize($config);
				$data['links'] = $this->pagination->create_links();
			}
                
            $data['title'] = 'Scholarship Grantees';

			$this->load->view('templates/header', $data);
			$this->load->view('scholarships/index', $data);
			$this->load->view('templates/footer');
				
			
			$this->output->delete_cache();
				
        }

        public function view($s_id = NULL) {

				$sch = $this->scholarships_model->get_scholarship_by_id($s_id);
				if (empty($sch))
				{
				        show_404();
				}
				else{
					
					if ($sch['id_no_comelec'] != '') { //then entry must be a registered voter
						$data['scholar'] = $this->scholarships_model->get_r_scholarship_by_id($s_id);
					}
					elseif ($sch['nv_id'] != ''){ //then entry must be a non voter
						$data['scholar'] = $this->scholarships_model->get_n_scholarship_by_id($s_id);
					}
					else{
						show_404();
					}
				
				}

				if (empty($data['scholar'])) {
					//auto update trash value for ben 
					show_404();
				}
				

				$data['availments'] = $this->scholarships_model->get_term_details($s_id);
				//$data['tracker'] = $this->scholarships_model->show_activities($s_id);
				$data['tracker'] = $this->tracker_model->get_activities($s_id, 'scholarships');
                
                //echo '<pre>'; print_r($data); echo '</pre>'; die();
                
				$this->load->view('templates/header', $data);
				$this->load->view('scholarships/view', $data);
				$this->load->view('templates/footer');
				
				//$this->output->enable_profiler(TRUE);
        }
        
        
        public function add() {
			if (!$this->ion_auth->in_group('admin'))
			{
				redirect('scholarships');
			}
			
			$data['title'] = 'New scholarship';
			/*
			$this->load->helper('form');
			$this->load->library('form_validation');

			$data['schools'] = $this->scholarships_model->get_schools(); //display school names in filter dropdown
			
			//primary scholarship data
			$this->form_validation->set_rules('batch','Batch','required');
			$this->form_validation->set_rules('school_id','School ID','required');
			$this->form_validation->set_rules('course','Course','required');
			$this->form_validation->set_rules('scholarship_status','Scholarship status','required');
			
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('templates/header', $data);
				$this->load->view('scholarships/add');
				$this->load->view('templates/footer');

			}
			else
			{
				echo '<pre>'; print_r($_POST); echo '</pre>'; 
				
				//insert into scholarships table
				$this->scholarships_model->set_scholarship();
				$data['alert_success'] = 'New entry created.';
				
				$this->load->view('templates/header', $data);
				$this->load->view('scholarships/add');
				$this->load->view('templates/footer');
			}
			*/

			$this->load->view('templates/header', $data);
			$this->load->view('scholarships/add');
			$this->load->view('templates/footer');

		}
		
		
		
		public function edit($scholarship_id = NULL) {
			
			if (!$this->ion_auth->in_group('admin')) {
				redirect('scholarships'); 
			}

			$this->load->helper('form');
			$this->load->library('form_validation');

			$data['title'] = 'Edit scholarship';
			$data['schools'] = $this->scholarships_model->get_schools(); //display school names in filter dropdown
			$data['scholarship_id'] = $scholarship_id;

			$sch = $this->scholarships_model->get_scholarship_by_id($scholarship_id);
			if (empty($sch))
			{
					show_404();
			}
			else{
				if ($sch['id_no_comelec'] != '') { //then entry must be a registered voter
					$data['scholar'] = $this->scholarships_model->get_r_scholarship_by_id($scholarship_id);
				}
				elseif ($sch['nv_id'] != ''){ //then entry must be a non voter
					$data['scholar'] = $this->scholarships_model->get_n_scholarship_by_id($scholarship_id);
				}
				else{
					show_404();
				}
			}


			//scholarship data
			$this->form_validation->set_rules('batch','Batch','required');
			$this->form_validation->set_rules('school_id','School ID','required');
			$this->form_validation->set_rules('course','Course','required');
			$this->form_validation->set_rules('scholarship_status','Scholarship Status','required');
			
			//upon submission of edit action
			if ($this->input->post('action') == 1) {
				
				if ($this->form_validation->run() === FALSE) {
					
					$data['scholarship'] = $this->scholarships_model->get_scholarship_by_id($scholarship_id);
					
					$this->load->view('templates/header', $data);
					$this->load->view('scholarships/edit');
					$this->load->view('templates/footer');
	
				}
				else {
					//execute data update
					$this->scholarships_model->update_scholarship($scholarship_id);
					//retrieve updated data
					$data['scholarship'] = $this->scholarships_model->get_scholarship_by_id($scholarship_id);
					
					if ( $this->input->post('trash') == 1) {
						$data['alert_trash'] = 'Marked for deletion. This is your last chance to undo by unchecking the "Delete this entry" box below and clicking submit.<br />';
					}
					else {
						$data['alert_success'] = 'Entry updated.';
					}
					
					$this->load->view('templates/header', $data);
					$this->load->view('scholarships/edit');
					$this->load->view('templates/footer');
				}
				
			}
			else{
				$data['scholarship'] = $this->scholarships_model->get_scholarship_by_id($scholarship_id);
				
				if (empty($data['scholarship'])) {
					show_404();
				}

				$this->load->view('templates/header', $data);
				$this->load->view('scholarships/edit');
				$this->load->view('templates/footer');
			}
		
		}


		public function add_term($id = FALSE) {
			if (!$this->ion_auth->in_group('admin')) {
				redirect('scholarships'); 
			}

			$this->load->helper('form');
			$this->load->library('form_validation');

			//$data['scholarships'] = $this->scholarships_model->get_scholarships();
			$data['title'] = 'New scholarship term';
			$data['scholarship_id'] = $id;

			//term data
			$this->form_validation->set_rules('year_level','Year Level','required');
			$this->form_validation->set_rules('school_year','School Year','required');
			$this->form_validation->set_rules('guardian_combined_income','Parent/Guardian Combined Income','required');

			if ($this->form_validation->run() === FALSE) {
				$this->load->view('templates/header', $data);
				$this->load->view('scholarships/add_term');
				$this->load->view('templates/footer');

			}
			else {
				//echo '<pre>'; print_r($_POST); echo '</pre>'; 
				
				//insert into scholarships table
				$this->scholarships_model->set_scholarship_term();
				$data['s_id'] = $this->input->post('scholarship_id');
				$data['alert_success'] = 'New entry created.';
				
				$this->load->view('templates/header', $data);
				$this->load->view('scholarships/add_term');
				$this->load->view('templates/footer');
			}
			
		}

		public function edit_term($s_id = FALSE, $t_id = FALSE) {
			if (!$this->ion_auth->in_group('admin')) {
				redirect('scholarships'); 
			}
			//echo $s_id.' - '.$t_id;

			$this->load->helper('form');
			$this->load->library('form_validation');

			//$data['scholarships'] = $this->scholarships_model->get_scholarships();
			$data['title'] = 'Edit scholarship term details';
			$data['s_id'] = $s_id;
			$data['t_id'] = $t_id;
			$data['s_term'] = $this->scholarships_model->get_single_term_details($t_id);

			//term data
			$this->form_validation->set_rules('year_level','Year Level','required');
			$this->form_validation->set_rules('school_year','School Year','required');
			$this->form_validation->set_rules('guardian_combined_income','Parent/Guardian Combined Income','required');

			if ($this->form_validation->run() === FALSE) {
				$this->load->view('templates/header', $data);
				$this->load->view('scholarships/edit_term');
				$this->load->view('templates/footer');

			}
			else {
				//echo '<pre>'; print_r($_POST); echo '</pre>'; 
				
				//insert into scholarships table
				$this->scholarships_model->update_scholarship_term();
				$data['alert_success'] = 'Entry updated.';
				$data['s_id'] = $this->input->post('scholarship_id');
				
				$this->load->view('templates/header', $data);
				$this->load->view('scholarships/edit_term');
				$this->load->view('templates/footer');
			}
			
		}

		public function rem_term($s_id = FALSE, $t_id = FALSE) {
			if (!$this->ion_auth->in_group('admin')) {
				redirect('scholarships'); 
			}

			//echo $s_id.' - '.$t_id;
			$this->scholarships_model->trash_term($s_id, $t_id);
			redirect('scholarships/view/'.$s_id);

		}
		
		public function all_to_excel() {
        //export all data to Excel file
        
        	$this->load->library('export');
			$sql = $this->scholarships_model->get_scholarships();
			$this->export->to_excel($sql, 'allscholarships'); 
	
			//$this->output->enable_profiler(TRUE);	
        }
        
        public function filtered_to_excel() {
        	$this->load->library('export');
        	
        	$filter = $this->uri->uri_to_assoc(3);
        	//echo '<pre>'; print_r($filter); echo '</pre>';
        	$field = key($filter);
        	$value = $filter[key($filter)];
        	$sql = $this->scholarships_model->filter_scholarships($field, $value);
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
        	$sql = $this->scholarships_model->search_scholarships($search);
			$filename = 'results_'.$search.'_'.date('Y-m-d-Hi');
			//echo $filename;
			$this->export->to_excel($sql, $filename); 
	
        }
		
			
}
