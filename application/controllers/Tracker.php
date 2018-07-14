<?php
class Tracker extends CI_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('tracker_model');
            $this->load->helper('url');
            $this->load->helper('form');
            $this->load->library('ion_auth');
			$this->load->library('pagination');
        }

        public function index() {
            $data['activities'] = $this->tracker_model->get_all_activities();
            $data['title'] = 'Audit Trail';

			$this->load->view('templates/header', $data);
			$this->load->view('tracker/index', $data);
			$this->load->view('templates/footer');
        }

}