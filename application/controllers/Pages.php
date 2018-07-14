<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

		public function __construct()
        {
			parent::__construct();
			$this->load->model('beneficiaries_model');
			$this->load->model('rvoters_model');
			$this->load->model('nonvoters_model');
			$this->load->model('services_model');
			$this->load->model('scholarships_model');
			$this->load->helper('url');
            $this->load->library('ion_auth');
            
            //$this->output->enable_profiler(TRUE);	
            
            if (!$this->ion_auth->logged_in())
			{
				redirect('auth/login');
			}
			
			/*
			//add users
			$username = 'QDev';
			$password = 'Afv!yzG#8h';
			$email = 'pj@infragrey.com';
			$additional_data = array(
								'first_name' => 'Dev',
								'last_name' => 'Q',
								);
			$group = array('2'); // Sets user to admin.
			$this->ion_auth->register($username, $password, $email, $additional_data, $group);
			*/
        }
		
        public function view($page = 'dashboard') {

        	if ( ! file_exists(APPPATH.'/views/pages/'.$page.'.php')) {
				show_404();
		    }
			
			$this->load->helper('email');
					
		    if ($page == 'dashboard') {
				
				//total ben
				$data['total_ben'] = $this->beneficiaries_model->record_count();
				$data['recent_service_availments'] = $this->services_model->get_recent_service_availments(5);
				$data['recent_scholars'] = $this->scholarships_model->get_recent_scholars(10);

				//get all services
                $data['total_services'] = $this->services_model->record_count();
                $data['r_services'] = $this->services_model->record_count_r();
                //$data['r_services'] = $this->services_model->get_r_services($data['total_services'], 0);
                $data['n_services'] = $this->services_model->record_count_n();
				//$data['n_services'] = $this->services_model->get_n_services($data['total_services'], 0);
					//$services_amount = $this->services_model->total_services_amount();
                //$data['total_services_amount'] = $services_amount['total'];
                $data['total_services_amount'] = $this->services_model->total_services_amount();

				//get all scholarships
				$data['total_scholarships'] = $this->scholarships_model->record_count();
				$data['r_scholarships'] = $this->scholarships_model->get_r_scholarships($data['total_scholarships'], 0);
				$data['n_scholarships'] = $this->scholarships_model->get_n_scholarships($data['total_scholarships'], 0);

				//distribution by service type
				$data['burials'] = $this->services_model->get_by_servtype('burial');
				$data['endorsements'] = $this->services_model->get_by_servtype('endorsements');
				$data['financials'] = $this->services_model->get_by_servtype('financial');
				$data['legals'] = $this->services_model->get_by_servtype('legal');
				$data['medicals'] = $this->services_model->get_by_servtype('medical');
				$data['referrals'] = $this->services_model->get_by_servtype('referral');

				

				//distribution by beneficiary type
				$data['r_ben'] = $this->beneficiaries_model->get_rv_beneficiaries($data['total_ben'], 0, false);
				$data['n_ben'] = $this->beneficiaries_model->get_nv_beneficiaries($data['total_ben'], 0, false);

                //distribution by barangay
                $data['r_brgy']['barangka'] = $this->beneficiaries_model->count_rv_ben_by_brgy('Barangka');
                $data['r_brgy']['con_uno'] = $this->beneficiaries_model->count_rv_ben_by_brgy('Concepcion Uno');
				$data['r_brgy']['con_dos'] = $this->beneficiaries_model->count_rv_ben_by_brgy('Concepcion Dos');
				$data['r_brgy']['fortune'] = $this->beneficiaries_model->count_rv_ben_by_brgy('Fortune');
				$data['r_brgy']['ivc'] = $this->beneficiaries_model->count_rv_ben_by_brgy('Industrial Valley Complex');
				$data['r_brgy']['jdp'] = $this->beneficiaries_model->count_rv_ben_by_brgy('Jesus Dela Peña');
				$data['r_brgy']['kalumpang'] = $this->beneficiaries_model->count_rv_ben_by_brgy('Kalumpang');
				$data['r_brgy']['malanday'] = $this->beneficiaries_model->count_rv_ben_by_brgy('Malanday');
				$data['r_brgy']['heights'] = $this->beneficiaries_model->count_rv_ben_by_brgy('Marikina Heights');
				$data['r_brgy']['nangka'] = $this->beneficiaries_model->count_rv_ben_by_brgy('Nangka');
				$data['r_brgy']['parang'] = $this->beneficiaries_model->count_rv_ben_by_brgy('Parang');
				$data['r_brgy']['santonino'] = $this->beneficiaries_model->count_rv_ben_by_brgy('Santo Niño');
				$data['r_brgy']['sanroque'] = $this->beneficiaries_model->count_rv_ben_by_brgy('San Roque');
				$data['r_brgy']['santaelena'] = $this->beneficiaries_model->count_rv_ben_by_brgy('Santa Elena');
				$data['r_brgy']['tanong'] = $this->beneficiaries_model->count_rv_ben_by_brgy('Tañong');
				$data['r_brgy']['tumana'] = $this->beneficiaries_model->count_rv_ben_by_brgy('Tumana');

                /*
                $data['r_brgy']['barangka'] = $this->beneficiaries_model->get_rv_beneficiaries($data['total_ben'], 0, "barangay = 'Barangka'");
                $data['r_brgy']['con_uno'] = $this->beneficiaries_model->get_rv_beneficiaries($data['total_ben'], 0, "barangay = 'Concepcion Uno'");
				$data['r_brgy']['con_dos'] = $this->beneficiaries_model->get_rv_beneficiaries($data['total_ben'], 0, "barangay = 'Concepcion Dos'");
				$data['r_brgy']['fortune'] = $this->beneficiaries_model->get_rv_beneficiaries($data['total_ben'], 0, "barangay = 'Fortune'");
				$data['r_brgy']['ivc'] = $this->beneficiaries_model->get_rv_beneficiaries($data['total_ben'], 0, "barangay = 'Industrial Valley Complex'");
				$data['r_brgy']['jdp'] = $this->beneficiaries_model->get_rv_beneficiaries($data['total_ben'], 0, "barangay = 'Jesus Dela Peña'");
				$data['r_brgy']['kalumpang'] = $this->beneficiaries_model->get_rv_beneficiaries($data['total_ben'], 0, "barangay = 'Kalumpang'");
				$data['r_brgy']['malanday'] = $this->beneficiaries_model->get_rv_beneficiaries($data['total_ben'], 0, "barangay = 'Malanday'");
				$data['r_brgy']['heights'] = $this->beneficiaries_model->get_rv_beneficiaries($data['total_ben'], 0, "barangay = 'Marikina Heights'");
				$data['r_brgy']['nangka'] = $this->beneficiaries_model->get_rv_beneficiaries($data['total_ben'], 0, "barangay = 'Nangka'");
				$data['r_brgy']['parang'] = $this->beneficiaries_model->get_rv_beneficiaries($data['total_ben'], 0, "barangay = 'Parang'");
				$data['r_brgy']['santonino'] = $this->beneficiaries_model->get_rv_beneficiaries($data['total_ben'], 0, "barangay = 'Santo Niño'");
				$data['r_brgy']['sanroque'] = $this->beneficiaries_model->get_rv_beneficiaries($data['total_ben'], 0, "barangay = 'San Roque'");
				$data['r_brgy']['santaelena'] = $this->beneficiaries_model->get_rv_beneficiaries($data['total_ben'], 0, "barangay = 'Santa Elena'");
				$data['r_brgy']['tanong'] = $this->beneficiaries_model->get_rv_beneficiaries($data['total_ben'], 0, "barangay = 'Tañong'");
				$data['r_brgy']['tumana'] = $this->beneficiaries_model->get_rv_beneficiaries($data['total_ben'], 0, "barangay = 'Tumana'");
                */
                
                $data['n_brgy']['barangka'] = $this->beneficiaries_model->count_nv_ben_by_brgy('Barangka');
                $data['n_brgy']['con_uno'] = $this->beneficiaries_model->count_nv_ben_by_brgy('Concepcion Uno');
				$data['n_brgy']['con_dos'] = $this->beneficiaries_model->count_nv_ben_by_brgy('Concepcion Dos');
				$data['n_brgy']['fortune'] = $this->beneficiaries_model->count_nv_ben_by_brgy('Fortune');
				$data['n_brgy']['ivc'] = $this->beneficiaries_model->count_nv_ben_by_brgy('Industrial Valley Complex');
				$data['n_brgy']['jdp'] = $this->beneficiaries_model->count_nv_ben_by_brgy('Jesus Dela Peña');
				$data['n_brgy']['kalumpang'] = $this->beneficiaries_model->count_nv_ben_by_brgy('Kalumpang');
				$data['n_brgy']['malanday'] = $this->beneficiaries_model->count_nv_ben_by_brgy('Malanday');
				$data['n_brgy']['heights'] = $this->beneficiaries_model->count_nv_ben_by_brgy('Marikina Heights');
				$data['n_brgy']['nangka'] = $this->beneficiaries_model->count_nv_ben_by_brgy('Nangka');
				$data['n_brgy']['parang'] = $this->beneficiaries_model->count_nv_ben_by_brgy('Parang');
				$data['n_brgy']['santonino'] = $this->beneficiaries_model->count_nv_ben_by_brgy('Santo Niño');
				$data['n_brgy']['sanroque'] = $this->beneficiaries_model->count_nv_ben_by_brgy('San Roque');
				$data['n_brgy']['santaelena'] = $this->beneficiaries_model->count_nv_ben_by_brgy('Santa Elena');
				$data['n_brgy']['tanong'] = $this->beneficiaries_model->count_nv_ben_by_brgy('Tañong');
				$data['n_brgy']['tumana'] = $this->beneficiaries_model->count_nv_ben_by_brgy('Tumana');

                /*
                echo '<pre>';
                print_r($data['r_brgy']);
                print_r($data['n_brgy']);
                echo '<pre>';
                die();
                */

                /*
				$data['n_brgy']['barangka'] = $this->beneficiaries_model->get_nv_beneficiaries($data['total_ben'], 0, "barangay = 'Barangka'");
				$data['n_brgy']['con_uno'] = $this->beneficiaries_model->get_nv_beneficiaries($data['total_ben'], 0, "barangay = 'Concepcion Uno'");
				$data['n_brgy']['con_dos'] = $this->beneficiaries_model->get_nv_beneficiaries($data['total_ben'], 0, "barangay = 'Concepcion Dos'");
				$data['n_brgy']['fortune'] = $this->beneficiaries_model->get_nv_beneficiaries($data['total_ben'], 0, "barangay = 'Fortune'");
				$data['n_brgy']['ivc'] = $this->beneficiaries_model->get_nv_beneficiaries($data['total_ben'], 0, "barangay = 'Industrial Valley Complex'");
				$data['n_brgy']['jdp'] = $this->beneficiaries_model->get_nv_beneficiaries($data['total_ben'], 0, "barangay = 'Jesus Dela Peña'");
				$data['n_brgy']['kalumpang'] = $this->beneficiaries_model->get_nv_beneficiaries($data['total_ben'], 0, "barangay = 'Kalumpang'");
				$data['n_brgy']['malanday'] = $this->beneficiaries_model->get_nv_beneficiaries($data['total_ben'], 0, "barangay = 'Malanday'");
				$data['n_brgy']['heights'] = $this->beneficiaries_model->get_nv_beneficiaries($data['total_ben'], 0, "barangay = 'Marikina Heights'");
				$data['n_brgy']['nangka'] = $this->beneficiaries_model->get_nv_beneficiaries($data['total_ben'], 0, "barangay = 'Nangka'");
				$data['n_brgy']['parang'] = $this->beneficiaries_model->get_nv_beneficiaries($data['total_ben'], 0, "barangay = 'Parang'");
				$data['n_brgy']['santonino'] = $this->beneficiaries_model->get_nv_beneficiaries($data['total_ben'], 0, "barangay = 'Santo Niño'");
				$data['n_brgy']['sanroque'] = $this->beneficiaries_model->get_nv_beneficiaries($data['total_ben'], 0, "barangay = 'San Roque'");
				$data['n_brgy']['santaelena'] = $this->beneficiaries_model->get_nv_beneficiaries($data['total_ben'], 0, "barangay = 'Santa Elena'");
				$data['n_brgy']['tanong'] = $this->beneficiaries_model->get_nv_beneficiaries($data['total_ben'], 0, "barangay = 'Tañong'");
                $data['n_brgy']['tumana'] = $this->beneficiaries_model->get_nv_beneficiaries($data['total_ben'], 0, "barangay = 'Tumana'");
                */

                $data['barangka_count'] = $data['r_brgy']['barangka'] + $data['n_brgy']['barangka'];
				$data['con_uno_count'] = $data['r_brgy']['con_uno'] + $data['n_brgy']['con_uno'];
				$data['con_dos_count'] = $data['r_brgy']['con_dos'] + $data['n_brgy']['con_dos'];
				$data['fortune_count'] = $data['r_brgy']['fortune'] + $data['n_brgy']['fortune'];
				$data['ivc_count'] = $data['r_brgy']['ivc'] + $data['n_brgy']['ivc'];
				$data['jdp_count'] = $data['r_brgy']['jdp'] + $data['n_brgy']['jdp'];
				$data['kalumpang_count'] = $data['r_brgy']['kalumpang'] + $data['n_brgy']['kalumpang'];
				$data['malanday_count'] = $data['r_brgy']['malanday'] + $data['n_brgy']['malanday'];
				$data['heights_count'] = $data['r_brgy']['heights'] + $data['n_brgy']['heights'];
				$data['nangka_count'] = $data['r_brgy']['nangka'] + $data['n_brgy']['nangka'];
				$data['parang_count'] = $data['r_brgy']['parang'] + $data['n_brgy']['parang'];
				$data['santonino_count'] = $data['r_brgy']['santonino'] + $data['n_brgy']['santonino'];
				$data['sanroque_count'] = $data['r_brgy']['sanroque'] + $data['n_brgy']['sanroque'];
				$data['santaelena_count'] = $data['r_brgy']['santaelena'] + $data['n_brgy']['santaelena'];
				$data['tanong_count'] = $data['r_brgy']['tanong'] + $data['n_brgy']['tanong'];
				$data['tumana_count'] = $data['r_brgy']['tumana'] + $data['n_brgy']['tumana'];
                
                /*
				$data['barangka_count'] = count($data['r_brgy']['barangka']) + count($data['n_brgy']['barangka']);
				$data['con_uno_count'] = count($data['r_brgy']['con_uno']) + count($data['n_brgy']['con_uno']);
				$data['con_dos_count'] = count($data['r_brgy']['con_dos']) + count($data['n_brgy']['con_dos']);
				$data['fortune_count'] = count($data['r_brgy']['fortune']) + count($data['n_brgy']['fortune']);
				$data['ivc_count'] = count($data['r_brgy']['ivc']) + count($data['n_brgy']['ivc']);
				$data['jdp_count'] = count($data['r_brgy']['jdp']) + count($data['n_brgy']['jdp']);
				$data['kalumpang_count'] = count($data['r_brgy']['kalumpang']) + count($data['n_brgy']['kalumpang']);
				$data['malanday_count'] = count($data['r_brgy']['malanday']) + count($data['n_brgy']['malanday']);
				$data['heights_count'] = count($data['r_brgy']['heights']) + count($data['n_brgy']['heights']);
				$data['nangka_count'] = count($data['r_brgy']['nangka']) + count($data['n_brgy']['nangka']);
				$data['parang_count'] = count($data['r_brgy']['parang']) + count($data['n_brgy']['parang']);
				$data['santonino_count'] = count($data['r_brgy']['santonino']) + count($data['n_brgy']['santonino']);
				$data['sanroque_count'] = count($data['r_brgy']['sanroque']) + count($data['n_brgy']['sanroque']);
				$data['santaelena_count'] = count($data['r_brgy']['santaelena']) + count($data['n_brgy']['santaelena']);
				$data['tanong_count'] = count($data['r_brgy']['tanong']) + count($data['n_brgy']['tanong']);
				$data['tumana_count'] = count($data['r_brgy']['tumana']) + count($data['n_brgy']['tumana']);
                */

				/*
				echo $data['barangka_count']; echo '<br />';
				echo $data['con_uno_count']; echo '<br />';
				echo $data['con_dos_count']; echo '<br />';
				echo $data['fortune_count']; echo '<br />';
				echo $data['ivc_count']; echo '<br />';
				echo $data['jdp_count']; echo '<br />';
				echo $data['kalumpang_count']; echo '<br />';
				echo $data['malanday_count']; echo '<br />';
				echo $data['heights_count']; echo '<br />';
				echo $data['nangka_count']; echo '<br />';
				echo $data['parang_count']; echo '<br />';
				echo $data['santonino_count']; echo '<br />';
				echo $data['sanroque_count']; echo '<br />';
				echo $data['santaelena_count']; echo '<br />';
				echo $data['tanong_count']; echo '<br />';
				echo $data['tumana_count']; 
				die();
				*/

		    }
		    $data['title'] = ucfirst($page); 

		    $this->load->view('templates/header', $data);
		    $this->load->view('pages/'.$page);
		    $this->load->view('templates/footer');
            
            /*
            $sections = array(
                'config'  => TRUE,
                'memory_usage' => TRUE, 
                'queries' => FALSE
                );
            
            $this->output->set_profiler_sections($sections);
            $this->output->enable_profiler(TRUE);
            */
        }
        
        
}
