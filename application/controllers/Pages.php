<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

		public function __construct()
        {
        	parent::__construct();
			$this->load->model('rvoters_model');
			$this->load->model('scholarships_model');
            $this->load->helper('url');
            $this->load->library('ion_auth');
            
            //$this->output->enable_profiler(TRUE);	
            
            if (!$this->ion_auth->logged_in())
			{
				redirect('auth/login');
			}
			
			/**
			//add users
			$username = 'nimda';
			$password = 'Afv!yzG#8h';
			$email = 'pj.villarta@gmail.com';
			$additional_data = array(
								'first_name' => 'Admin',
								'last_name' => 'GIS',
								);
			$group = array('2'); // Sets user to admin.
			$this->ion_auth->register($username, $password, $email, $additional_data, $group);
			
			**/
        }
		
        public function view($page = 'dashboard')
        {
        	$this->load->helper('email');
        
	     	if ( ! file_exists(APPPATH.'/views/pages/'.$page.'.php')) {
		            // Whoops, we don't have a page for that!
		            show_404();
		    }
		    
		    if ($page == 'dashboard') {
				$data['recent_rvoters'] = $this->rvoters_model->get_recent_rvoters(20);
				$data['recent_scholars'] = $this->scholarships_model->get_recent_scholars(20);
		    }
		    $data['title'] = ucfirst($page); // Capitalize the first letter

		    $this->load->view('templates/header', $data);
		    $this->load->view('pages/'.$page, $data);
		    $this->load->view('templates/footer', $data);
		    
		    //$this->output->enable_profiler(TRUE);
        }
        
        
}
