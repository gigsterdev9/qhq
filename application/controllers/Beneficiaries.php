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

				//debug
				//$this->output->enable_profiler(TRUE);
				
        }

        public function index() {		
		
			//if ($_SERVER['REMOTE_ADDR'] <> '125.212.122.21') die('Undergoing maintenance.');

			//set general pagination config
			$config = array();
			$config['base_url'] = base_url() . 'beneficiaries';
			
			$config['per_page'] = 25;
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
					//Display registered first, non-voters next
					//implement pagination
					$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
					$data['total_result_count'] = $this->beneficiaries_model->record_count();
						$config['total_rows'] = $data['total_result_count'];
						$this->pagination->initialize($config);

					$data['nonvoters'] = $this->beneficiaries_model->get_nv_beneficiaries($config["per_page"], $page);
					$data['rvoters'] = $this->beneficiaries_model->get_rv_beneficiaries($config["per_page"], $page);

					$data['links'] = $this->pagination->create_links();

				}
				
                $data['title'] = 'Master List';
				//echo '<pre>'; print_r($data); echo '</pre>';
				$this->load->view('templates/header', $data);
				$this->load->view('beneficiaries/index', $data);
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
		
		public function match_find() {
			//echo '<pre>'; print_r($_POST); echo '</pre>'; die();
			$fname = $this->input->post('fname');
			$mname = $this->input->post('mname');
			$lname = $this->input->post('lname');
			$dob = $this->input->post('dob');

			$rvoter_match = $this->rvoters_model->find_rvoter_match($fname, $mname, $lname, $dob);
			//$nvoter_match = $this->nonvoters_model->find_nvoter_match($fname, $mname, $lname, $dob);

			if (isset($rvoter_match) && $rvoter_match != NULL) {
				echo 'Possible match(es) found.';
				foreach($rvoter_match as $rmatch) {
					$match_name = $rmatch['fname'] .' '.$rmatch['mname'].' '.$rmatch['lname'].' ('.$rmatch['dob'].')';
					
					echo '<div class="radio">';
					echo '<label><input type="radio" name="optradio"><a href="#" data-toggle="modal" data-target="#quick-view-'.$rmatch['id'].'">'.$match_name.'</a></label>';
					echo '</div>';
				
					//create modal for entry details
					?>
					<!-- modals -->
					<div id="quick-view-<?php echo $rmatch['id'] ?>" class="modal quick-view" role="dialog">
					<div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Entry Details</h4>
						</div>
						<div class="modal-body">
							<?php
								
								echo 'First Name: '.$rmatch['fname'];
								echo '<br />';
								echo 'Middle Name: '.$rmatch['mname'];
								echo '<br />';
								echo 'Last Name: '.$rmatch['lname'];
								echo '<br />';
								echo 'Birthdate: '.$rmatch['dob'];
								echo '<br />';
								echo 'Code: '.$rmatch['code'];
								echo '<br />';
								echo 'Comelec ID No.: '.$rmatch['id_no_comelec'];
								echo '<br />';
								echo 'ID No.: '.$rmatch['id_no'];
								echo '<br />';
								echo 'Address: '.$rmatch['address'];
								echo '<br />';
								echo 'Barangay: '.$rmatch['barangay'];
								echo '<br />';
								echo 'District: '.$rmatch['district'];
							?>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
						</div>

					</div>
					</div>
					<?php
				}
				$show_last_radio = true;
			}
							
			if (isset($show_last_radio)) {
				echo '<div class="radio">';
				echo '<label><input type="radio" name="optradio">Create New</label>';
				echo '</div>';
				echo 'If none of the above is an actual match, you may proceed to create a new entry. &nbsp; ';
				echo '<button type="button" class="btn btn-sm" data-toggle="collapse" data-target="#no-match" id="btn-proceed" >Proceed with caution.</button>';
			}
			else{
				echo 'No match found. &nbsp; ';
				echo '<button type="button" class="btn btn-sm" data-toggle="collapse" data-target="#no-match" id="btn-proceed">Proceed.</button>';
			}
			//$data[$nvoter_match] = $this->nonvoters_model->find_nvoter_match($fname, $mname, $lname, $dob);
			//echo '<pre>'; print_r($data['rvoter_match']); echo '</pre>'; 
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
