<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Services extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('services_model');
                $this->load->helper('url');
                $this->load->helper('form');
                $this->load->library('ion_auth');
                
                //$this->output->enable_profiler(TRUE);	
                
                if (!$this->ion_auth->logged_in())
				{
					redirect('auth/login');
				}
								
        }

        public function index() {		
			
        	//if ($_SERVER['REMOTE_ADDR'] <> '125.212.122.21') die('Undergoing maintenance.');
        	
				if ($this->input->post('filter_by') != NULL)
				{
					$filter_by = $this->input->post('filter_by');
					switch ($filter_by) 
					{
						case 'brgy': 
							$brgy = $this->input->post('filter_by_brgy');
							$data['rvoters'] = $this->services_model->filter_services('barangay',$brgy);
							$data['filterval'] = array('barangay',$brgy); 
							break;
						default: 
							break;
					}
					
				}
				elseif ($this->input->post('search_param') != NULL)
				{
					//$data['grants'] = array(1, 2, 3);
					$search_param = $this->input->post('search_param');
					$data['rvoters'] = $this->services_model->search_services($search_param);
					$data['searchval'] = $search_param;
				}
				else
				{
					$data['rvoters'] = $this->services_model->get_services($x);
				}
                
                //$data['grants'] = $this->grants_model->get_grants();
                //$data['historical_grants'] = $this->grants_model->get_historical_grants();
                $data['title'] = 'Services';

				$this->load->view('templates/header', $data);
				$this->load->view('services', $data);
				$this->load->view('templates/footer');
				
				//$this->output->enable_profiler(TRUE);
        }

        public function view($slug = NULL)
        {

                $data['grants_item'] = $this->grants_model->get_grants($slug);
                if (empty($data['grants_item']))
				{
				        show_404();
				}
                $project_id = $data['grants_item']['project_id'];
                
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
                
                $data['tracker'] = $this->grants_model->show_activities($project_id);
                $tranches = $this->grants_model->show_finances($project_id);
                //echo '<pre>Fin: '; print_r($tranches); echo '</pre>';
                if ($tranches <> NULL) 
                {
		            foreach ($tranches as $tranche) 
		            {
		            	$fin[$tranche['tranche']]['amount'] = $tranche['amount'];
		            	$fin[$tranche['tranche']]['amount_released'] = $tranche['amount_released'];
		            	$fin[$tranche['tranche']]['date_released'] = $tranche['date_released'];
		            }
                }
                $data['tranches'] = (isset($fin)) ? $fin : 0;
                
                //echo '<pre>'; print_r($data); echo '</pre>'; die();
                $data['title'] = $data['grants_item']['project_title'];
				
				$this->load->view('templates/header', $data);
				$this->load->view('grants/view', $data);
				$this->load->view('templates/footer');
				
				//$this->output->enable_profiler(TRUE);
        }
        
        
        public function add()
		{
			if (!$this->ion_auth->in_group('admin'))
			{
				redirect('grants');
			}
			
			$this->load->helper('form');
			$this->load->library('form_validation');

			$data['proponents'] = $this->grants_model->get_proponents();
			$data['sites'] = $this->grants_model->get_sites();
			$data['indicators'] = $this->grants_model->get_indicators();
			$data['title'] = 'New grant';

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
				$this->load->view('grants/add');
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
				$grants_item = $this->grants_model->get_grant_by_id($project_id);
			
				//prep message
				$msg = 'Project Title: '.$grants_item['project_title'].'\n'.
						'Field(s): '.$fields.'\n'.
						'New value(s): '.$new_values.'\n'.
						'Requestor: '.$requestor.'\n'.
						'Originating IP: '.$userip;

				//send	
				mail('pj.villarta@gmail.com', '[SGP-5 GIS] Data modification request', nl2br($msg));
			
				redirect('grants/'.$grants_item['slug']);
			}
			
		}
			
}
