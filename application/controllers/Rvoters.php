<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rvoters extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
				$this->load->model('rvoters_model');
				$this->load->model('scholarships_model');
				$this->load->model('beneficiaries_model');
				$this->load->model('services_model');
				$this->load->model('tracker_model');
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
							$data['rvoters'] = $this->rvoters_model->filter_rvoters($config["per_page"], $page, 'barangay',$brgy);
								$config['total_rows'] = $data['rvoters']['result_count'];
								$this->pagination->initialize($config);
							$data['links'] = $this->pagination->create_links();
							break;
						case 'district':
							$district = $this->input->get('filter_by_district');
							$data['filterval'] = array('district',$district,''); //the '' is to factor in the 3rd element introduced by the age filter
							$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
							$data['rvoters'] = $this->rvoters_model->filter_rvoters($config["per_page"], $page, 'district',$district);
								$config['total_rows'] = $data['rvoters']['result_count'];
								$this->pagination->initialize($config);
							$data['links'] = $this->pagination->create_links();
							break;
						case 'age':
							$age_operand = $this->input->get('filter_by_age_operand');
							$age_value = $this->input->get('filter_by_age_value');

							if ($age_operand == 'between' and stristr($age_value, 'and') == FALSE) {
								$data['rvoters']['result_count'] = 0;
								$data['rvoters']['result_count'] = 0;
								$data['links'] = '';
								break;
							}

							$data['filterval'] = array('age',$age_operand, $age_value);
							$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
							$data['rvoters'] = $this->rvoters_model->filter_rvoters($config["per_page"], $page, 'age',$age_value, $age_operand);
								$config['total_rows'] = $data['rvoters']['result_count'];
								$this->pagination->initialize($config);
							$data['links'] = $this->pagination->create_links();
							break;
						default: 
							break;
					}
					
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
								$where_clause .= "lname like '$s_lname%' and fname like '%$s_fname%' and trash = 0";
							}
							else{
								$where_clause .= '( ';
								foreach ($params as $p) {
									$where_clause .= "lname like '$p%' or fname like '$p%'";
									if ($p != end($params)) $where_clause .= ' or ';
								}
								$where_clause .= ' ) and trash = 0';
							}
						}
						elseif (!in_array('s_name', $s_key) && in_array('s_address', $s_key)) {
							$where_clause = "address like '%$search_param%' and trash = 0";
						}
						elseif (in_array('s_name', $s_key) && in_array('s_address', $s_key)) {
							$where_clause .= '( ';
							foreach ($params as $p) {
								$where_clause .= "lname like '$p%' or fname like '$p%' or address like '%$p%'";
								if ($p != end($params)) $where_clause .= 'or ';
							}
							$where_clause .= ' ) and trash = 0';
						}
						else{
							$where_clause = '1';
						}
						//die($where_clause);

						$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
						$data['rvoters'] = $this->rvoters_model->search_rvoters($config["per_page"], $page, $where_clause);
							$config['total_rows'] = $data['rvoters']['result_count'];
							$this->pagination->initialize($config);
						$data['links'] = $this->pagination->create_links();
						$data['searchval'] = $search_param;
					}
					else {
						$data['rvoters']['result_count'] = 0;
						$data['links'] = '';
					}
				}
				else{
					//Display all
					//implement pagination
					$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
					$data['rvoters'] = $this->rvoters_model->get_rvoters($config["per_page"], $page);
					$data['rvoters']['result_count'] = $this->rvoters_model->record_count();
						$config['total_rows'] = $data['rvoters']['result_count'];
						$this->pagination->initialize($config);
					$data['links'] = $this->pagination->create_links();
				}
				
                $data['title'] = 'Master List';
				//echo '<pre>'; print_r($data); echo '</pre>';
				$this->load->view('templates/header', $data);
				$this->load->view('rvoters/index', $data);
				$this->load->view('templates/footer');
				
				//$this->output->cache(1);
				//$this->output->delete_cache();
				
        }

        public function view($id = NULL) {
				
				//retrieve primary data
				$data['rvoter'] = $this->rvoters_model->get_rvoter_by_id($id);
				$id = $data['rvoter']['id'];
				$id_no_comelec = $data['rvoter']['id_no_comelec'];

				if (empty($data['rvoter'])) {
				    show_404();
				}

				//check if already tagged as beneficiary 
				$check = $this->beneficiaries_model->get_ben_by_comid($id_no_comelec);
				if (!empty($check)) {
					$data['ben_id'] = $check['ben_id'];
				}
				else{
					$data['ben_id'] = '';
				}
				//retrieve scholarship related data
				$data['scholarships'] = $this->scholarships_model->get_r_scholarships_by_id($id_no_comelec);

				//retrieve services related data
				$data['services'] = $this->services_model->get_r_services_by_comelec_id($id_no_comelec);
				
				//retrieve audit trail
				//$data['tracker'] = $this->rvoters_model->show_activities($id_no_comelec);
				$data['tracker'] = $this->tracker_model->get_activities($id_no_comelec, 'rvoters');
				
				$this->load->view('templates/header', $data);
				$this->load->view('rvoters/view', $data);
				$this->load->view('templates/footer');
				
        }
		
		public function add() {
			if (!$this->ion_auth->in_group('admin')) {
				redirect('rvoters');
			}
			
			$this->load->helper('form');
			$this->load->library('form_validation');

			//$data['rvoters'] = $this->rvoters_model->get_rvoters();
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
				$this->load->view('rvoters/add');
				$this->load->view('templates/footer');

			}
			else
			{
				//execute insert
				$this->rvoters_model->set_rvoter();
				
				$data['title'] = 'Registered voter entry.';
				$data['alert_success'] = 'Entry successful.';
				
				$this->load->view('templates/header', $data);
				$this->load->view('rvoters/add');
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
					
					$data['rvoter'] = $this->rvoters_model->get_rvoter_by_id($id);
					
					$this->load->view('templates/header', $data);
					$this->load->view('rvoters/edit');
					$this->load->view('templates/footer');
	
				}
				else {
					//execute data update
					$this->rvoters_model->update_rvoter();
					//retrieve updated data
					$data['rvoter'] = $this->rvoters_model->get_rvoter_by_id($this->input->post('id'));
					
					if ( $this->input->post('trash') == '1') {
						$data['alert_trash'] = 'Marked for deletion.'; //This is your last chance to undo by unchecking the "Delete" checkbox below and clicking submit.<br />';
					}
					else {
						$data['alert_success'] = 'Voter entry updated.';
					}
					
					$this->load->view('templates/header', $data);
					$this->load->view('rvoters/edit');
					$this->load->view('templates/footer');
				}
				
			}
			else{
				$data['rvoter'] = $this->rvoters_model->get_rvoter_by_id($id);
				
				if (empty($data['rvoter'])) {
					show_404();
				}

				$this->load->view('templates/header', $data);
				$this->load->view('rvoters/edit');
				$this->load->view('templates/footer');
			}
			
		}
        
        public function batch_import() {

			$data['title'] = 'COMELEC data update';

			if ($this->input->post('action') == 'upload') {

				//print_r($_FILES);
				
				$config['upload_path'] 		= './tmp/';
				$config['allowed_types']    = 'csv';
                $config['max_size']         = 10240;
                
				$this->load->library('upload', $config);
				
				if ( ! $this->upload->do_upload('userfile')) {
						
						//$error = array('error' => $this->upload->display_errors());
						//echo '<pre>'; print_r($error); echo '</pre>';

						$data['error'] = array('error' => $this->upload->display_errors());
						$this->load->view('templates/header', $data);
						$this->load->view('rvoters/batch_import');
						$this->load->view('templates/footer');		
                }
                else{
						
						$dd = array('upload_data' => $this->upload->data());
						//echo '<pre>'; print_r($dd); echo '</pre>';

						if ($dd['upload_data']['file_size'] > 0) {
							
							$userfile = $dd['upload_data']['full_path'];
							//echo $userfile;
							$this->load->library('CSVReader');
							$result =   $this->csvreader->parse_file($userfile);//path to csv file
							//$data['flow'] = $result;
							$data['csvData'] =  $result;
							
							//initiate system lockdown
							$ctr = 0;
							foreach ($result as $r) {
								
								$keys = array_keys($r);
								$values = $r[$keys[0]];
								$keys = explode(',', $keys[0]);
								$values = explode(',', $values);	

								for ($i = 0; $i < count($keys); $i++){
									$keys[$i] = trim($keys[$i]);
									$r[$keys[$i]] = $values[$i];
								}
								//echo '<pre>'; print_r($r); echo '</pre>'; die();
                                
                                $code = $r['CODE'];
                                $id_no = $r['ID_NO'];
                                $id_no_comelec = $r['ID_NO_COMELEC'];
								$fname = $r['FNAME'];
								$mname = $r['MNAME'];
								$lname = $r['LNAME'];
								$dob = $r['DOB'];
								$address = $r['ADDRESS'];
								$barangay = $r['BARANGAY'];
								$district = $r['DISTRICT'];
                                $sex = $r['SEX'];
                                $precinct = $r['PRECINCT'];
								$mobile_no = $r['MOBILE_NO'];
                                $email = $r['EMAIL'];
                                $referee = $r['REFEREE'];
                                $remarks = $r['REMARKS'];
								
								$data['flow'][$ctr]['fullname'] = $fname.' '.$mname.' '.$lname;
								
								//check if record exists in rvoter
                                //$rvoter_match = $this->rvoters_model->find_rvoter_match($fname, $mname, $lname, $dob);
                                $rvoter_match = $this->rvoters_model->get_rvoter_by_comelec_id($id_no_comelec, true); //include 'trashed' entries
                                
                                //match is found
								if (!empty($rvoter_match)) {
                                    //DO NOTHING
                                    //echo '<pre>'; print_r($rvoter_match); echo '</pre>';
                                    //$data['notice'][] = 'Entry exists for:  ('.$id_no_comelec.') '.$fname.' '.$mname.' '.$lname;
                                }
                                //entry is new
								else {
                                    //add into rvoters table 
                                    $new_entry = array(
                                        'fname' => $fname,
                                        'mname' => $mname,
                                        'lname' => $lname,
                                        'dob' => $dob,
                                        'address' => $address,
                                        'barangay' => $barangay,
                                        'district' => $district,
                                        'sex' => $sex,
                                        'code' => $code,
                                        'id_no' => $id_no,
                                        'id_no_comelec' => $id_no_comelec,
                                        'precinct' => $precinct,
                                        'mobile_no' => $mobile_no,
                                        'email' => $email,
                                        'referee' => $referee,
                                        'remarks' => $remarks
                                    );
                                    $this->rvoters_model->set_rvoter($new_entry); 

                                    //report data insertion
                                    $data['notice'][] = 'New entry added:  ('.$id_no_comelec.') '.$fname.' '.$mname.' '.$lname;
								}
								
								$ctr++;
							}
							//release system lockdown
                        }
                        
                        $this->tracker_model->log_event('completed','completed rvoters data update. '.$ctr.' records processed');

                        $data['ctr'] = $ctr;
						$data['import_success'] = TRUE;
						//echo '<pre>'; print_r($data); echo '</pre>'; die();

						$this->load->view('templates/header', $data);
						$this->load->view('rvoters/batch_import', $data);
						$this->load->view('templates/footer');
                }
			
			}
			else{
				
				$this->tracker_model->log_event('initiated','initiated rvoters data update.');

				$this->load->view('templates/header', $data);
				$this->load->view('rvoters/batch_import', $data);
				$this->load->view('templates/footer');
			}
		
		}

		public function all_to_excel() {  //disable this! data is too massive to export.
        //export all data to Excel file
        
            $this->load->library('export');
            $sql = $this->rvoters_model->get_rvoters();

            //echo '<pre>'; print_r($sql); echo '</pre>';
			//$this->export->to_excel($sql, 'all_rvoters'); 
			
        }
        
        public function filtered_to_excel() {
        	$this->load->library('export');
        	
        	$filter = $this->uri->uri_to_assoc(3);
        	//echo '<pre>'; print_r($filter); echo '</pre>';
        	$field = key($filter);
        	$value = $filter[key($filter)];
        	$sql = $this->rvoters_model->filter_rvoters($field, $value);
			//echo '<pre>'; print_r($sql); echo '</pre>';
			$filename = 'filtered_'.$field.'_'.$value.'_'.date('Y-m-d-Hi');
			echo $filename;
			$this->export->to_excel($sql, $filename); 
	
			
        }
        
        public function results_to_excel() {
        	$this->load->library('export');
        	
        	$search = $this->uri->segment(3);
			//echo $search;
        	$sql = $this->rvoters_model->search_rvoters($search);
			$filename = 'results_'.$search.'_'.date('Y-m-d-Hi');
			//echo $filename;
			$this->export->to_excel($sql, $filename); 
	
        }
	
	
}
