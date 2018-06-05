<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Services extends CI_Controller {

        public function __construct() {

				parent::__construct();
				$this->load->model('beneficiaries_model');
				$this->load->model('services_model');
				$this->load->model('nonvoters_model');
				$this->load->model('rvoters_model');
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
					//$r_count = (!empty($data['r_services'])) ? count($data['r_services']) : 0;
					//$n_count = (!empty($data['n_services'])) ? count($data['n_services']) : 0;
                        //$config['total_rows'] = $r_count + $n_count;
                    $data['total_result_count'] = $this->services_model->record_count();
                        $config['total_rows'] = $data['total_result_count'];
						$this->pagination->initialize($config);
					$data['links'] = $this->pagination->create_links();
					

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
						//$data['nonvoters'] = $this->beneficiaries_model->search_beneficiaries($config["per_page"], $page, $search_param, $search_key);
						$data['r_services'] = $this->services_model->search_r_services($config["per_page"], $page, $where_clause);
						$data['n_services'] = $this->services_model->search_n_services($config["per_page"], $page, $where_clause);
						
						//$r_count = (!empty($data['r_services'])) ? count($data['r_services']) : 0;
						//$n_count = (!empty($data['n_services'])) ? count($data['n_services']) : 0;
                            //$config['total_rows'] = $r_count + $n_count;
                        $data['total_result_count'] = $this->services_model->record_count();
                            $config['total_rows'] = $data['total_result_count'];
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
					$r_s = $this->services_model->get_r_services($config["per_page"], $page); 
					if (is_array($r_s)) {
						foreach ($r_s as $s) {
							if (is_array($s)) { //do not display 'result_count' 
								$data['r_services'][] = $s;
							}
						}
					}
					$n_s = $this->services_model->get_n_services($config["per_page"], $page);
					if (is_array($n_s)) {
						foreach ($n_s as $s) {
							if (is_array($s)) { //do not display 'result_count' 
								$data['n_services'][] = $s;
							}
						}
					}
					//$count_r_services = (isset($data['r_services'])) ? count($data['r_services']) : 0 ;
					//$count_n_services = (isset($data['n_services'])) ? count($data['n_services']) : 0 ;
					//$data['total_result_count'] = $count_r_services + $count_n_services;
                        //$config['total_rows'] = $data['total_result_count'];
                    $data['total_result_count'] = $this->services_model->record_count();
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
			if ($data['service'] == 0) {
				show_404();
			}
			//retrieve availment history data
				$ben_id = $data['service']['ben_id'];
			//retrieve all other  services availment for same beneficiary
			$data['services'] = $this->services_model->get_services_by_id($ben_id); //echo 'BEN ID: '.$ben_id;
			//retrieve audit trail
			//$data['tracker'] = $this->rvoters_model->show_activities($id);
			$data['tracker'] = $this->tracker_model->get_activities($id, 'services');

			$this->load->view('templates/header', $data);
			$this->load->view('services/view', $data);
			$this->load->view('templates/footer');


		}
        
        
        public function add() {
			if (!$this->ion_auth->in_group('admin')) {
				redirect('services');
			}

			$data['title'] = 'New service';
			/* 
			$this->load->helper('form');
			$this->load->library('form_validation');

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
			$this->form_validation->set_rules('req_date','Request date','required');
			$this->form_validation->set_rules('req_ben_id','Requestor','required');
			$this->form_validation->set_rules('relationshiop','Relationship','required');
			$this->form_validation->set_rules('s_type','Service Type','required');
			$this->form_validation->set_rules('s_status','Service Status','required');
			
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('templates/header', $data);
				$this->load->view('services/add');
				$this->load->view('templates/footer');

			}
			else
			{
				//echo '<pre>'; print_r($_POST); echo '</pre>'; 
				
				//insert into services table
				$this->services_model->set_service();
				$data['alert_success'] = 'New entry created.';
				
				$this->load->view('templates/header', $data);
				$this->load->view('services/add');
				$this->load->view('templates/footer');
			}
			*/

			$this->load->view('templates/header', $data);
			$this->load->view('services/add');
			$this->load->view('templates/footer');

		}
		
		
		
		public function edit($service_id = NULL) {
			
			if (!$this->ion_auth->in_group('admin')) {
				redirect('services'); 
			}

			$this->load->helper('form');
			$this->load->library('form_validation');

			$data['title'] = 'Edit service';

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

			$data['service'] = $this->services_model->get_service_by_id($service_id);
			$data['service_id'] = $service_id;
			
			//validation
			$this->form_validation->set_rules('req_date','Request Date','required');
			$this->form_validation->set_rules('ben_id','Recipient','required');
			$this->form_validation->set_rules('req_ben_id','Requester','required');
			$this->form_validation->set_rules('relationship','Relationship','required');
			$this->form_validation->set_rules('service_type','Service Type','required');
            $this->form_validation->set_rules('particulars','Request particulars','required');
            $this->form_validation->set_rules('s_status','Service Status','required');
			
			//upon submission of edit action
			if ($this->input->post('action') == 1) {
				
				if ($this->form_validation->run() === FALSE) {
					
					//$data['service'] = $this->services_model->get_service_by_id($service_id);
					
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
				
				//check if service record already exists
					//via similar_text and concat of date,servicetype and amount
				$req_date =  $this->input->post('req_date');
				$ben_id = $this->input->post('ben_id');	
				$service_type = $this->input->post('service_type');
				$particulars = $this->input->post('particulars');
				$amount = $this->input->post('amount');

				$dupe = $this->services_model->dupe_check($req_date, $ben_id, $service_type, $particulars, $amount);

				if (empty($dupe)) {
				
					//insert into services table
					$this->services_model->set_service();
					$data['alert_success'] = 'New entry created.';
					$data['ben_id'] = $this->input->post('ben_id'); //for some reason $data['ben_id'] becomes null so need to reset the value

					$this->load->view('templates/header', $data);
					$this->load->view('services/add_exist');
					$this->load->view('templates/footer');
				}
				else{

					$data['errors'] = "Duplicate entry detected. If you are certain the entry you are about to create is not a duplicate, modifying the particulars will help.";

					$this->load->view('templates/header', $data);
					$this->load->view('services/add_exist');
					$this->load->view('templates/footer');

				}
			}
			
		}

		public function delete($service_id = FALSE, $ben_id = FALSE) {
			if (!$this->ion_auth->in_group('admin')) {
				redirect('services'); 
			}
			$this->services_model->trash_service($service_id, $ben_id);
			redirect('beneficiaries/view/'.$ben_id);

		}

		/*
		public function do_upload() {

			$config['upload_path']          = './tmp/';
			$config['allowed_types']        = 'gif|jpg|png|csv';
			$config['max_size']             = 100;
			$config['max_width']            = 1024;
			$config['max_height']           = 768;

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('userfile'))
			{
					$error = array('error' => $this->upload->display_errors());
					echo '<pre>'; print_r($error); echo '</pre>';
					//$this->load->view('services/batch_import', $error);
			}
			else
			{
					$data = array('upload_data' => $this->upload->data());
					//$this->load->view('services/import_success', $data);
					echo '<pre>'; print_r($data); echo '</pre>';
			}
		}
		*/

		public function batch_import() {

			$data['title'] = 'Services data import';

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
						$this->load->view('services/batch_import');
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
								
								$fname = $r['FNAME'];
								$mname = $r['MNAME'];
								$lname = $r['LNAME'];
								$dob = $r['DOB'];
								
								$address = $r['ADDRESS'];
								$barangay = $r['BARANGAY'];
								$district = $r['DISTRICT'];
								$sex = $r['SEX'];
								$mobile_no = $r['MOBILE_NO'];
								$email = $r['EMAIL'];

								$req_date =  $r['REQUEST_DATE'];
								$service_type = $r['SERVICE_TYPE'];
                                $particulars = $r['PARTICULARS'];
                                $institution = $r['INSTITUTION'];
								$amount = $r['AMOUNT'];
								$service_status = $r['SERVICE_STATUS'];
								$action_officer = $r['ACTION_OFFICER'];
								$recommendation = $r['RECOMMENDATION'];
								$remarks = $r['REMARKS'];
								
								

								$data['flow'][$ctr]['fullname'] = $fname.' '.$mname.' '.$lname;
								
								//check if record exists in rvoter
								$rvoter_match = $this->rvoters_model->find_rvoter_match($fname, $mname, $lname, $dob);
								//check if record exists in nvoter
								$nvoter_match = $this->nonvoters_model->find_nvoter_match($fname, $mname, $lname, $dob);

								$rmatch = FALSE;
								$nmatch = FALSE;

								if (isset($rvoter_match) && !empty($rvoter_match)) {
									$rmatch = TRUE;
									$id_no_comelec = $rvoter_match[0]['id_no_comelec'];
									
									$data['flow'][$ctr]['rmatch'] = TRUE;
									$data['flow'][$ctr]['id_no_comelec'] = $id_no_comelec;

								}
								if (isset($nvoter_match) && !empty($nvoter_match)) {
									$nmatch = TRUE;
									$nv_id = $nvoter_match[0]['nv_id'];
									
									$data['flow'][$ctr]['nmatch'] = TRUE;
									$data['flow'][$ctr]['nv_id'] = $nv_id;

								}

								//true in both rvoter and nvoter
								if ($rmatch == TRUE && $nmatch == TRUE) {
									$data['flow'][$ctr]['match_condition'] = 'both are true';
									//rvoter supersedes nvoter
									$ben_match = $this->beneficiaries_model->get_ben_by_comid($id_no_comelec);

									if (!empty($ben_match)) {
										
										//check if service record already exists
										$ben_id = $ben_match['ben_id']; 
										$dupe = $this->services_model->dupe_check($req_date, $ben_id, $service_type, $particulars, $amount);

										if (empty($dupe)) {
										
											$service_data = array(
													'req_date' => $req_date,
													'ben_id' => $ben_id,
													'req_ben_id' => $ben_id, //defaulting to self
													'relationship' => 'self',
													'service_type' => $service_type,
                                                    'particulars' => $particulars,
                                                    'institution' => $institution,
													'amount' => $amount,
													's_status' => $service_status,
													'action_officer' => $action_officer,
													'recommendation' => $recommendation,
													's_remarks' => $remarks.' (batch upload)',
													'trash' => 0
											);
											$this->services_model->set_service($service_data);
										}
										else{

											$data['notice'][] = 'Entry exists for:  ('.$id_no_comelec.') '.$fname.' '.$mname.' '.$lname.' / '.$req_date.' '.$service_type.' '.$particulars.' '.$amount;

										}
										
									}
									else{
										//create new ben via id_no_comelec
										$this->beneficiaries_model->set_beneficiary($id_no_comelec, 'rv');
										//create new service with new ben id
										$new_ben_id = $this->beneficiaries_model->get_ben_by_comid($id_no_comelec);
										
										$service_data = array(
											'req_date' => $req_date,
											'ben_id' => $new_ben_id,
											'req_ben_id' => $new_ben_id, //defaulting to self
											'relationship' => 'self',
											'service_type' => $service_type,
                                            'particulars' => $particulars,
                                            'institution' => $institution,
											'amount' => $amount,
											's_status' => $service_status,
											'action_officer' => $action_officer,
											'recommendation' => $recommendation,
											's_remarks' => $remarks.' (batch upload)',
											'trash' => 0
										);
										$this->services_model->set_service($service_data);

									}
								}
								//true for rvoter
								elseif ($rmatch == TRUE && $nmatch == FALSE) {
									
									$data['flow'][$ctr]['match_condition'] = 'rmatch is true';
									
									$ben_match = $this->beneficiaries_model->get_ben_by_comid($id_no_comelec);
									
									if (!empty($ben_match)) {
										
										//check if service record already exists
										$ben_id = $ben_match['ben_id'];
										$dupe = $this->services_model->dupe_check($req_date, $ben_id, $service_type, $particulars, $amount);

										if (empty($dupe)) {
										
											$service_data = array(
													'req_date' => $req_date,
													'ben_id' => $ben_id,
													'req_ben_id' => $ben_id, //defaulting to self
													'relationship' => 'self',
													'service_type' => $service_type,
                                                    'particulars' => $particulars,
                                                    'institution' => $institution,
													'amount' => $amount,
													's_status' => $service_status,
													'action_officer' => $action_officer,
													'recommendation' => $recommendation,
													's_remarks' => $remarks.' (batch upload)',
													'trash' => 0
											);
											$this->services_model->set_service($service_data);
										}
										else{
											
											$data['notice'][] = 'Entry exists for:  ('.$id_no_comelec.') '.$fname.' '.$mname.' '.$lname.' / '.$req_date.' '.$service_type.' '.$particulars.' '.$amount;

										}

									}
									else{
										
										//create new ben via id_no_comelec
										$this->beneficiaries_model->set_beneficiary($id_no_comelec, 'rv');
										//create new service with new ben id
										$new_ben_id = $this->beneficiaries_model->get_ben_by_comid($id_no_comelec);
										$service_data = array(
											'req_date' => $req_date,
											'ben_id' => $new_ben_id,
											'req_ben_id' => $new_ben_id, //defaulting to self
											'relationship' => 'self',
											'service_type' => $service_type,
                                            'particulars' => $particulars,
                                            'institution' => $institution,
											'amount' => $amount,
											's_status' => $service_status,
											'action_officer' => $action_officer,
											'recommendation' => $recommendation,
											's_remarks' => $remarks.' (batch upload)',
											'trash' => 0
										);
										$this->services_model->set_service($service_data);

									}

								}
								//true for nvoter
								elseif ($rmatch == FALSE && $nmatch == TRUE) {
									
									$data['flow'][$ctr]['match_condition'] = 'nmatch is true';
									
									$ben_match = $this->beneficiaries_model->get_ben_by_nvid($nv_id);

									if (!empty($ben_match)) {
										
										//check if service record already exists
										$ben_id = $ben_match['ben_id'];
										$dupe = $this->services_model->dupe_check($req_date, $ben_id, $service_type, $particulars, $amount);

										if (empty($dupe)) {
										
											$service_data = array(
													'req_date' => $req_date,
													'ben_id' => $ben_id,
													'req_ben_id' => $ben_id, //defaulting to self
													'relationship' => 'self',
													'service_type' => $service_type,
                                                    'particulars' => $particulars,
                                                    'institution' => $institution,
													'amount' => $amount,
													's_status' => $service_status,
													'action_officer' => $action_officer,
													'recommendation' => $recommendation,
													's_remarks' => $remarks.' (batch upload)',
													'trash' => 0
											);
											$this->services_model->set_service($service_data);
										}
										else{
											
											$data['notice'][] = 'Entry exists for:  '.$fname.' '.$mname.' '.$lname.' / '.$req_date.' '.$service_type.' '.$particulars.' '.$amount;

										}

									}
									else{
										
										//create new ben via nv_id
										$this->beneficiaries_model->set_beneficiary($nv_id, 'nv');
										//create new service with new ben id
										$new_ben_id = $this->beneficiaries_model->get_ben_by_nvid($nv_id);
										$service_data = array(
											'req_date' => $req_date,
											'ben_id' => $new_ben_id,
											'req_ben_id' => $new_ben_id, //defaulting to self
											'relationship' => 'self',
											'service_type' => $service_type,
                                            'particulars' => $particulars,
                                            'institution' => $institution,
											'amount' => $amount,
											's_status' => $service_status,
											'action_officer' => $action_officer,
											'recommendation' => $recommendation,
											's_remarks' => $remarks.' (batch upload)',
											'trash' => 0
										);
										$this->services_model->set_service($service_data);
									}
								}
								elseif ($rmatch == FALSE && $nmatch == FALSE) {
								//if not exist in nvoter or rvoter (both are false)
									$data['flow'][$ctr]['match_condition'] = 'both are false';
																	
									//create new nvoter entry, this creates new ben entry as well
										//default status to active, referee to null
									$nv_data = array(
										'code' => NULL,
										'id_no' => NULL,
										'fname' => strtoupper($fname),
										'mname' => strtoupper($mname),
										'lname' => strtoupper($lname),
										'dob' => $dob,
										'address' => $address,
										'barangay' => $barangay,
										'district' => $district,
										'sex' => $sex,
										'mobile_no' => $mobile_no,
										'email' => $email,
										'referee' => NULL,
										'nv_status' => 1,
										'nv_remarks' => $remarks.' (batch upload)',
										'trash' => 0
										);	
									$this->nonvoters_model->set_nonvoter($nv_data);
									
									//retrieve new ben id
									$nvoter_match = $this->nonvoters_model->find_nvoter_match($fname, $mname, $lname, $dob);
									$nv_id = $nvoter_match[0]['nv_id'];
									$ben_details = $this->beneficiaries_model->get_ben_by_nvid($nv_id);
									$new_ben_id = $ben_details['ben_id'];
									
									//create new service entry, 
									//preset values for s_remarks .= 'batch upload', req_ben_id = ben_id, relationship = 'self'
									$service_data = array(
										'req_date' => $req_date,
										'ben_id' => $new_ben_id,
										'req_ben_id' => $new_ben_id, //defaulting to self
										'relationship' => 'self',
										'service_type' => $service_type,
                                        'particulars' => $particulars,
                                        'institution' => $institution,
										'amount' => $amount,
										's_status' => $service_status,
										'action_officer' => $action_officer,
										'recommendation' => $recommendation,
										's_remarks' => $remarks.' (batch upload)',
										'trash' => 0
									);
									$this->services_model->set_service($service_data);
									

								}
								else {
									$data['flow'][$ctr]['match_condition'] = 'Invalid';

								}
								
								$ctr++;
							}
							//release system lockdown
						}

						$this->tracker_model->log_event('completed','completed services data import. '.$ctr.' records processed');

						$data['import_success'] = TRUE;
						//echo '<pre>'; print_r($data); echo '</pre>'; die();

						$this->load->view('templates/header', $data);
						$this->load->view('services/batch_import', $data);
						$this->load->view('templates/footer');
                }
			
			}
			else{
				
				$this->tracker_model->log_event('initiated','initiated services data import');

				$this->load->view('templates/header', $data);
				$this->load->view('services/batch_import', $data);
				$this->load->view('templates/footer');
			}
		
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
