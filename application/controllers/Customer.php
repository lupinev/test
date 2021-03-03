<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

  public function index() {
    $this->load->view('a_header_customer');
		$this->load->view('jobordercustomer');
		$this->load->view('a_footer');
  }

	public function create_update() {
		$this->output->set_content_type("application/json")
		->set_output( json_encode( $this->jobordermodel->create_update( $this->input->post() ) ) );
	}

	public function get_companies() {
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->jobordermodel->get_companies()));
	}

	public function get_specific_address() {
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->jobordermodel->get_specific_address( $this->input->post('company') )));
	}

	public function get_specific_applicant() {
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->jobordermodel->get_specific_applicant( $this->input->post('company') )));
	}

	public function get_specific_designation() {
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->jobordermodel->get_specific_designation( $this->input->post('company') )));
	}

	public function get_specific_contact_number() {
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->jobordermodel->get_specific_contact_number( $this->input->post('company') )));
	}

	public function get_specific_email_address() {
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->jobordermodel->get_specific_email_address( $this->input->post('company') )));
	}

	public function get_specific_contact_person() {
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->jobordermodel->get_specific_contact_person( $this->input->post('company') )));
	}

	public function change_fee() {
		echo $this->jobordermodel->change_fee($this->input->post());
	}


}
