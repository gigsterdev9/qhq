<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Proponents extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('proponents_model');
                $this->load->helper('form');
                $this->load->helper('url');
                $this->load->library('ion_auth');
                
                if (!$this->ion_auth->logged_in())
				{
					redirect('auth/login');
				}
        }

        public function index()
        {
        		if ($this->input->post('search_param') != NULL)
				{
					$search_param = $this->input->post('search_param');
					$data['proponents'] = $this->proponents_model->search_proponents($search_param);
				}
				else
				{
                	$data['proponents'] = $this->proponents_model->get_proponents();
                }
                $data['title'] = 'Proponents Index';

				$this->load->view('templates/header', $data);
				$this->load->view('proponents/index', $data);
				$this->load->view('templates/footer');
        }

        public function view($proponent_id = NULL)
        {
                $data['proponent_item'] = $this->proponents_model->get_proponents($proponent_id);
                $data['proponent_projects'] = $this->proponents_model->get_proponent_projects($proponent_id);
                
                if (empty($data['proponent_item']))
				{
				        show_404();
				}

				$data['title'] = $data['proponent_item']['organization_name'];

				$this->load->view('templates/header', $data);
				$this->load->view('proponents/view', $data);
				$this->load->view('templates/footer');
        }
        
        public function add()
		{
			$this->load->helper('form');
			$this->load->library('form_validation');

			$data['title'] = 'Add proponent';

			$this->form_validation->set_rules('organization_name', 'Organization name', 'required');
			$this->form_validation->set_rules('organization_name', 'Organization name', 'callback_dupekey_check');

			if ($this->form_validation->run() === FALSE)
			{
				$this->load->view('templates/header', $data);
				$this->load->view('proponents/add');
				$this->load->view('templates/footer');

			}
			else
			{
				$this->proponents_model->set_proponents();
				
				$data['title'] = 'New proponent';
				$data['alert_success'] = TRUE;
				
				$this->load->view('templates/header', $data);
				$this->load->view('proponents/add');
				$this->load->view('templates/footer');
			}
		}
		
		
		public function edit($proponent_id = NULL)
		{

			//print_r($this->input->post());
			if ($this->input->post('action') != 1) 
			{
				$data['proponent_item'] = $this->proponents_model->get_proponents($proponent_id);	
			}
			else
			{
				$this->proponents_model->update_proponent($this->input->post('proponent_id'));
				$data['proponent_item'] = $this->proponents_model->get_proponents($this->input->post('proponent_id'));
				$data['alert_success'] = TRUE;
			}
			
		    if (empty($data['proponent_item']))
			{
			    show_404();
			}
				
			$data['title'] = $data['proponent_item']['organization_name'];
			
			$this->load->helper('form');
			$this->load->library('form_validation');

			$this->form_validation->set_rules('organization_name', 'Organization name', 'required');
			$this->form_validation->set_rules('organization_name', 'Organization name', 'callback_dupekey_check');
			
			if ($this->form_validation->run() === FALSE)
			{
				$this->load->view('templates/header', $data);
				$this->load->view('proponents/edit');
				$this->load->view('templates/footer');

			}
			else
			{
				$this->load->view('templates/header', $data);
				$this->load->view('proponents/edit');
				$this->load->view('templates/footer');
			}
		}
		
		public function dupekey_check($key)
		{	
			$this->proponents_model->dupe_check($key);
		}


}
