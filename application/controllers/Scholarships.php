<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Scholarships extends CI_Controller {

        public function __construct() {
                parent::__construct();
				$this->load->model('scholarships_model');
				$this->load->model('nonvoters_model');
                $this->load->helper('url');
                $this->load->helper('form');
				$this->load->library('ion_auth');
				$this->load->library('pagination');
                
                //$this->output->enable_profiler(TRUE);	
                
                if (!$this->ion_auth->logged_in())
				{
					redirect('auth/login');
				}
				
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
							$data['scholarships'] = $this->scholarships_model->filter_scholarships('barangay', $brgy, $config["per_page"], $page);
							$data['record_count'] = $this->scholarships_model->filter_scholarships_num_rows('barangay', $brgy);
							$data['filterval'] = array('barangay',$brgy); 
							break;
						case 'school': 
							$school = $this->input->post('filter_by_school');
							$data['scholarships'] = $this->scholarships_model->filter_scholarships('schools.school_id', $school, $config["per_page"], $page);
							$data['record_count'] = $this->scholarships_model->filter_scholarships_num_rows('schools.school_id', $school);
							$data['filterval'] = array('school ID',$school); 
							break;
						case 'district': 
							$district = $this->input->post('filter_by_district');
							$data['scholarships'] = $this->scholarships_model->filter_scholarships('district', $district, $config["per_page"], $page);
							$data['record_count'] = $this->scholarships_model->filter_scholarships_num_rows('district', $district);
							$data['filterval'] = array('district',$district); 
							break;
						case 'gender': 
							$gender = $this->input->post('filter_by_gender');
							$data['scholarships'] = $this->scholarships_model->filter_scholarships('sex', $gender, $config["per_page"], $page);
							$data['record_count'] = $this->scholarships_model->filter_scholarships_num_rows('sex', $gender);
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
					//$data['grants'] = array(1, 2, 3);
					$search_param = $this->input->post('search_param');
					$data['scholarships'] = $this->scholarships_model->search_scholarships($search_param);
					$data['searchval'] = $search_param;
				}
				else
				{
					//Display all
					//implement pagination
					$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
					$data['scholarships'] = $this->scholarships_model->get_scholarships($config["per_page"], $page);
					$data['record_count'] = $this->scholarships_model->record_count();
						$config['total_rows'] = $data['record_count'];
						$this->pagination->initialize($config);
					$data['links'] = $this->pagination->create_links();
				}
                
                $data['title'] = 'Scholarship Grantees';

				$this->load->view('templates/header', $data);
				$this->load->view('scholarships/index', $data);
				$this->load->view('templates/footer');
				
				//$this->output->enable_profiler(TRUE);
        }

        public function view($scholar_id = NULL) {

                $data['scholar'] = $this->scholarships_model->get_scholarship_by_id($scholar_id);
                if (empty($data['scholar']))
				{
				        show_404();
				}
				$data['availments'] = $this->scholarships_model->get_term_details($scholar_id);
                $data['tracker'] = $this->scholarships_model->show_activities($scholar_id);
                
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
			
			$this->load->helper('form');
			$this->load->library('form_validation');

			$data['non_voters'] = $this->nonvoters_model->get_nonvoters();
			$data['scholarships'] = $this->scholarships_model->get_scholarships();
			$data['title'] = 'New scholarship';

			$this->form_validation->set_rules('proponent', 'Proponent', 'required');
			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('grant_type','Grant type','required');
			$this->form_validation->set_rules('location','Location','required');
			$this->form_validation->set_rules('site','Site','required');
			$this->form_validation->set_rules('project_duration','Project duration','required');
			$this->form_validation->set_rules('project_budget','Project budget','required');
			$this->form_validation->set_rules('amount_requested','Amount requested','required');
			$this->form_validation->set_rules('co_financing','Co-financing','required');
			$this->form_validation->set_rules('project_status','Project status','required');

			if ($this->form_validation->run() === FALSE) {
				$this->load->view('templates/header', $data);
				$this->load->view('scholarships/add');
				$this->load->view('templates/footer');

			}
			else
			{
				$this->grants_model->set_grants();
				
				$data['title'] = 'Grant item entered';
				$data['alert_success'] = 'Grant entry successful.';
				
				$this->load->view('templates/header', $data);
				$this->load->view('grants/add');
				$this->load->view('templates/footer');
			}
		}
		
		
		
		public function edit($slug = NULL)
		{
			
			if (!$this->ion_auth->in_group('admin'))
			{
				redirect('grants');
			}
						
			if ($this->input->post('action') == 1) 
			{
				$this->grants_model->update_grant($this->input->post('project_id'));
				$data['grant_item'] = $this->grants_model->get_grant_by_id($this->input->post('project_id'));
				
				if ( $this->input->post('trash') == 1)
				{
					$data['alert_trash'] = 'Marked for deletion. This is your last chance to undo by unchecking the "Delete this entry" box below and clicking submit.<br />';
				}
				else
				{
					$data['alert_success'] = 'Grant entry updated.';
				}					
			}
			else
			{
				$data['grant_item'] = $this->grants_model->get_grants($slug);
			}
			
			//print_r($data);
			if (empty($data['grant_item']))
			{
				show_404();
			}
			
			
			$this->load->helper('form');
			$this->load->library('form_validation');

			$data['indicators'] = $this->grants_model->get_indicators();
				
				$project_id = $data['grant_item']['project_id'];
                
                $indicators = $this->grants_model->get_grant_indicators($project_id);
                foreach ($indicators as $indicator) 
                {
                	$indicator_code = $indicator['indicator_code'];
                	
                	switch (substr($indicator_code,0,1)) 
                	{
                		case '1': 
                			$data['outcome']['1'][][$indicator_code] = $indicator['indicator_value'];
                			break;
                		case '2': 
                			$data['outcome']['2'][][$indicator_code] = $indicator['indicator_value'];
                			break;
                		case '3': 
							$data['outcome']['3'][][$indicator_code] = $indicator['indicator_value'];
                			break;
                		default: break;
                	}
                	
                }
			//$data['submitted_docs'] = $this->grants_model->get_submitted_docs($project_id);
			$tranches = $this->grants_model->show_finances($project_id);
            foreach ($tranches as $tranche) 
            {
               	$fin[$tranche['tranche']]['amount'] = $tranche['amount'];
              	$fin[$tranche['tranche']]['amount_released'] = $tranche['amount_released'];
             	$fin[$tranche['tranche']]['date_released'] = $tranche['date_released'];
            }
            $data['tranches'] = (isset($fin)) ? $fin : 0;
			
			$data['proponents'] = $this->grants_model->get_proponents();
			$data['sites'] = $this->grants_model->get_sites();
			$data['title'] = 'Edit grant';

			$this->form_validation->set_rules('proponent', 'Proponent', 'required');
			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('grant_type','Grant type','required');
			$this->form_validation->set_rules('location','Location','required');
			$this->form_validation->set_rules('site','Site','required');
			$this->form_validation->set_rules('project_duration','Project duration','required');
			$this->form_validation->set_rules('project_budget','Project budget','required');
			$this->form_validation->set_rules('amount_requested','Amount requested','required');
			$this->form_validation->set_rules('co_financing','Co-financing','required');
			$this->form_validation->set_rules('project_status','Project status','required');

			if ($this->form_validation->run() === FALSE)
			{
				$this->load->view('templates/header', $data);
				$this->load->view('grants/edit');
				$this->load->view('templates/footer');

			}
			else
			{
				//$this->grants_model->update_grant($slug);
				
				$this->load->view('templates/header', $data);
				$this->load->view('grants/edit');
				$this->load->view('templates/footer');
			}
		}
		
		
		public function add_historic()
		{
			
			if (!$this->ion_auth->in_group('admin'))
			{
				redirect('grants');
			}
			
			$this->load->helper('form');
			$this->load->library('form_validation');

			$data['title'] = 'Add historical grant';

			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('proponent', 'Proponent', 'required');

			if ($this->form_validation->run() === FALSE)
			{
				$this->load->view('templates/header', $data);
				$this->load->view('grants/add_historic');
				$this->load->view('templates/footer');

			}
			else
			{
				$this->grants_model->set_historical_grants();
				
				//$data['title'] = 'Enter new grant (Historical)';
				$data['alert_success'] = 'Grant entry successful.';
				
				$this->load->view('templates/header', $data);
				$this->load->view('grants/add_historic');
				$this->load->view('templates/footer');
			}
		}
		
		
		public function edit_historic($id)
		{
			
			if (!$this->ion_auth->in_group('admin'))
			{
				redirect('grants');
			}
			
			
			
			//echo '<pre>'; print_r($data); echo '</pre>';
			if (empty($data['grant_item']))
			{
				show_404();
			}
			
			$this->load->helper('form');
			$this->load->library('form_validation');

			$data['title'] = 'Edit historical grant';

			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('proponent', 'Proponent', 'required');

			if ($this->form_validation->run() === FALSE)
			{
				$data['grant_item'] = $this->grants_model->get_historical_grant_by_id($id);
				
				$this->load->view('templates/header', $data);
				$this->load->view('grants/edit_historic');
				$this->load->view('templates/footer');

			}
			else
			{
				unset($data['grant_item']);
				$this->grants_model->update_historical_grants($id);
				//$data['grant_item'] = $this->grants_model->get_historical_grant_by_id($id);
				$data['alert_success'] = 'Entry update successful.';
				
				$this->load->view('templates/header', $data);
				$this->load->view('grants/edit_historic');
				$this->load->view('templates/footer');
			}
		}
		
		
		public function historic($slug = NULL)
        {
        
        		$data['historical_item'] = $this->grants_model->get_historical_grants($slug);
            
                if (empty($data['historical_item']))
				{
				        show_404();
				}
				
				$data['title'] = $data['historical_item']['title'];
				//echo '<pre>'; print_r($data); echo '</pre>';
				
				$this->load->view('templates/header', $data);
				$this->load->view('grants/view_historic', $data);
				$this->load->view('templates/footer');
				
        }
        
        public function all_to_excel()
        {
        //export all data to Excel file
        
        	$this->load->library('export');
			$sql = $this->grants_model->get_grants();
			$this->export->to_excel($sql, 'allgrants'); 
	
			//$this->output->enable_profiler(TRUE);	
        }
        
        public function filtered_to_excel()
        {
        	$this->load->library('export');
        	
        	$filter = $this->uri->uri_to_assoc(3);
        	//echo '<pre>'; print_r($filter); echo '</pre>';
        	$field = key($filter);
        	$value = $filter[key($filter)];
        	$sql = $this->grants_model->filter_grants($field, $value);
			//echo '<pre>'; print_r($sql); echo '</pre>';
			$filename = 'filtered_'.$field.'_'.$value.'_'.date('Y-m-d-Hi');
			echo $filename;
			$this->export->to_excel($sql, $filename); 
	
			//$this->output->enable_profiler(TRUE);	
        }
        
        public function results_to_excel()
        {
        	$this->load->library('export');
        	
        	$search = $this->uri->segment(3);
			//echo $search;
        	$sql = $this->grants_model->search_grants($search);
			$filename = 'results_'.$search.'_'.date('Y-m-d-Hi');
			//echo $filename;
			$this->export->to_excel($sql, $filename); 
	
        }
		
		public function change_request()
		{
			//load helpers
			$this->load->helper('email');
			$this->load->library('form_validation');
			
			//sort variables
			$project_id = $this->input->post('project_id');
			$fields = $this->input->post('fields');
			$new_values = $this->input->post('new_values');

			$user = $this->ion_auth->user()->row();
			$requestor = ucfirst($user->username);
			$userip = $_SERVER['REMOTE_ADDR'];
			
			//set validation rules
			$this->form_validation->set_rules('fields', 'Fields', 'required');
			$this->form_validation->set_rules('new_values', 'New Vallues', 'required');
			
			if ($this->form_validation->run() === FALSE)
			{
				//do nothing
				//echo 'Error';
				redirect('grants');
			}
			else
			{
				
				//get more data about project
				$scholar = $this->grants_model->get_grant_by_id($project_id);
			
				//prep message
				$msg = 'Project Title: '.$scholar['project_title'].'\n'.
						'Field(s): '.$fields.'\n'.
						'New value(s): '.$new_values.'\n'.
						'Requestor: '.$requestor.'\n'.
						'Originating IP: '.$userip;

				//send	
				mail('pj.villarta@gmail.com', '[SGP-5 GIS] Data modification request', nl2br($msg));
			
				redirect('grants/'.$scholar['slug']);
			}
			
		}
			
}
