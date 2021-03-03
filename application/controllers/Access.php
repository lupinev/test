<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Access extends CI_Controller{

	public function __construct() {
	    parent::__construct();
	}

	public function index() {
		$this->login();
	}

  public function login() {
		$this->load->view('login');
	}

  public function validatecredentials() {
    $this->output->set_content_type("application/json")
    ->set_output(json_encode($this->accessmodel->validatecredentials($this->input->post())));
  }

  public function logout() {
    $output = $this->accessmodel->logout();
    if($output) {
      $this->session->sess_destroy();
    }
    redirect('access/login');
  }

  public function changepassword() {
    $this->output->set_content_type("application/json")
    ->set_output(json_encode($this->accessmodel->changepassword($this->input->post())));
  }

	public function get_all_personnel() {
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->accessmodel->get_all_personnel()));
	}

	public function get_personnel_details_via_id() {
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->accessmodel->get_personnel_details_via_id($this->input->post('id'))));
	}

}
