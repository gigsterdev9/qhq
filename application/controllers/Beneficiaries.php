<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Beneficiaries extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
				$this->load->model('beneficiaries_model');
				$this->load->model('rvoters_model');
				$this->load->model('nonvoters_model');
				$this->load->model('scholarships_model');
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
		
		public function match_find() {
			//echo '<pre>'; print_r($_POST); echo '</pre>'; die();
			$fname = $this->input->post('fname');
			$mname = $this->input->post('mname');
			$lname = $this->input->post('lname');
			$dob = $this->input->post('dob');

			$rvoter_match = $this->rvoters_model->find_rvoter_match($fname, $mname, $lname, $dob);
			$nvoter_match = $this->nonvoters_model->find_nvoter_match($fname, $mname, $lname, $dob);
			
			//registered voter matches
			if (isset($rvoter_match) && $rvoter_match != NULL) {
				echo '<br />Possible match in REGISTERED VOTERS.';
				foreach($rvoter_match as $rmatch) {
					//$match_name = $rmatch['fname'] .' '.$rmatch['mname'].' '.$rmatch['lname'].' ('.$rmatch['dob'].')';
					
					echo '<div class="radio">';
					echo '<label><input type="radio" name="optradio" id="optradio" value="id_no_comelec|'.$rmatch['id_no_comelec'].'"> ';
							//'<a href="#" data-toggle="modal" data-target="#quick-view-'.$rmatch['id_no_comelec'].'">'.$match_name.'</a>';
					echo 'COMELEC ID No. '.$rmatch['id_no_comelec'].' | Address: '.$rmatch['address'].' | Barangay'.$rmatch['barangay'].' | District :'.$rmatch['district'];
					echo '</label></div>';
				
					$id_nos_comelec[] = $rmatch['id_no_comelec'];
				}
				$show_last_radio = true;
			}

			//Non voter matches
			if (isset($nvoter_match) && $nvoter_match != NULL) {
				echo '<br />Possible match in NON-VOTERS.';
				foreach($nvoter_match as $nmatch) {
					//$match_name = $nmatch['fname'] .' '.$nmatch['mname'].' '.$nmatch['lname'].' ('.$nmatch['dob'].')';
					
					echo '<div class="radio">';
					echo '<label><input type="radio" name="optradio" id="optradio" value="nv_id|'.$nmatch['nv_id'].'">';
							//'<a href="#" data-toggle="modal" data-target="#quick-view-'.$nmatch['nv_id'].'">'.$match_name.'</a>';
					echo 'ID No. '.$nmatch['id_no'].' | Address: '.$nmatch['address'].' | Barangay'.$nmatch['barangay'].' | District :'.$nmatch['district'];
					echo '</div>';
				
					$nv_ids[] = $nmatch['nv_id'];

				}
				$show_last_radio = true;
			}
			
			//Ben table matches
			if (isset($id_nos_comelec) && is_array($id_nos_comelec)) {
				foreach ($id_nos_comelec as $id_no_comelec) {
					//echo $id_no_comelec;
					$ben_ids_com[] = $this->beneficiaries_model->get_ben_by_comid($id_no_comelec);
				}
			}
			
			if (isset($nv_ids) && is_array($nv_ids)) {
				foreach ($nv_ids as $nv_id) {
					//echo $nv_id;
					$ben_ids_nv[] = $this->beneficiaries_model->get_ben_by_nvid($nv_id);
				}
			}

			//Scholarship table matches
			if (isset($ben_ids_com) && is_array($ben_ids_com)) {
				foreach ($ben_ids_com as $ben) {
					$s_match = $this->scholarships_model->get_scholarship_by_ben_id($ben['ben_id'], 'r');
				}
				$show_last_radio = true;
			}
			
			if (isset($ben_ids_nv) && is_array($ben_ids_nv)) {
				foreach ($ben_ids_nv as $ben) {
					$s_match = $this->scholarships_model->get_scholarship_by_ben_id($ben['ben_id'], 'n');
				}
				$show_last_radio = true;
			}
			
			//echo '<pre>'; print_r($s_match); echo '</pre>';
			if (isset($s_match)) {
				echo '<br />Possible match in SCHOLARSHIPS.';
				echo '<div class="radio">';
				//echo '<a href="#" data-toggle="modal" data-target="#quick-view-'.$nmatch['nv_id'].'">'.$match_name.'</a>';
				if ($s_match['nv_id'] != '') {
					if ($s_match['id_no_comelec'] != '') { //comelec id trumps nv_id in the unlikely case that they co-exist in a record
						echo '<label><input type="radio" name="optradio" id="optradio" value="id_no_comelec|'.$s_match['id_no_comelec'].'">';
						echo '<a href="'.base_url('scholarships/view').'/'.$s_match['scholarship_id'].'">';
						echo 'COMELEC ID No.'.$s_match['id_no_comelec'];
					} 
					else{
						echo '<label><input type="radio" name="optradio" id="optradio" value="nv_id|'.$s_match['nv_id'].'">';
						echo '<a href="'.base_url('scholarships/view').'/'.$s_match['scholarship_id'].'">';
						echo 'ID No.'.$s_match['nv_id'];
					}

				}
				else{
					echo '<label><input type="radio" name="optradio" id="optradio" value="id_no_comelec|'.$s_match['id_no_comelec'].'">';
					echo '<a href="'.base_url('scholarships/view').'/'.$s_match['scholarship_id'].'">';
					echo 'COMELEC ID No.'.$s_match['id_no_comelec'];
				}
				echo ' | Address: '.$s_match['address'].' | Barangay'.$s_match['barangay'].' | District :'.$s_match['district'];
				echo '</a></div>';
			}	

			if (isset($show_last_radio)) {
				echo '<br /><br />';
				echo '<button type="button" class="btn btn-sm" data-toggle="collapse" data-target="#with-match" id="btn-existing-ben" >Continue</button><br /><br />';
				echo 'If none of the above is an actual match, you may proceed to ' .
						'<a href="'.base_url('nonvoters/add').'?fname='.$fname.'&mname='.$mname.'&lname='.$lname.'&dob='.$dob.'">create a new beneficiary entry</a>. <br />';
			}
			else{
				echo 'No match found. &nbsp; ';
				echo '<a href="'.base_url('nonvoters/add').'?fname='.$fname.'&mname='.$mname.'&lname='.$lname.'&dob='.$dob.'">create a new beneficiary entry</a>.';
			
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
