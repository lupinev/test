<?php defined('BASEPATH') OR exit('No direct script access allowed');
// Testingu 101
class Joborder extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->session->userdata('user_id')) redirect('access');
	}

  public function notifs() {
    $data['newwait'] = '0';
    return $data;
  }

  public function index() {
    $data = $this->notifs();
    $data['menu'] = 'joborder';
    $data['header'] = 'Job Order Requests';
    $data['gmenu'] = '';
    $this->load->view('a_header', $data);
    $this->load->view('joborderrequests');
    $this->load->view('a_footer');
  }

	public function create_update() {
		$this->output->set_content_type("application/json")
		->set_output( json_encode( $this->jobordermodel->create_update( $this->input->post() ) ) );
	}

  public function read() {
		$selectedType = $this->uri->segment(3, 'active');
		$output = $this->jobordermodel->read($selectedType);
		$response = array(
		  'aaData' => $output,
		  'iTotalRecords' => count($output),
		  'iTotalDisplayRecords' => count($output),
		  'iDisplayStart' => 0
		);

		if (isset($_REQUEST['sEcho'])) {
		  $response['sEcho'] = $_REQUEST['sEcho'];
		}

    $this->output->set_content_type("application/json")
		->set_output(json_encode($response));
	}

	public function read_selected_id() {
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->jobordermodel->read_selected_id( $this->input->post('selected_jo_id') )));
	}

	public function reject_selected_jo_id() {
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->jobordermodel->reject_selected_jo_id( $this->input->post('jo_reject_id') )));
	}

	public function check_duplicate_JO() {
		echo $this->jobordermodel->check_duplicate_JO( $this->input->post('jo_no') );
	}

	public function check_duplicate_pnri_code() {
		echo $this->jobordermodel->check_duplicate_pnri_code( $this->input->post('pnri_code') );
	}

	function remove_this_line () {
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->jobordermodel->remove_this_line($this->input->post('jo_item_id'))));
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

	public function date_converter() {
		 echo date("M j, Y", strtotime( $this->input->post('date') ));
	}

	public function change_fee() {
		echo $this->jobordermodel->change_fee($this->input->post());
	}

	public function notif_get_pending_jo_count() {
		echo $this->jobordermodel->notif_get_pending_jo_count();
	}

	public function get_sync_approved_jo_count() {
		echo $this->jobordermodel->get_sync_approved_jo_count();
	}

	public function get_sync_latest_approved_jo() {
		echo $this->jobordermodel->get_sync_latest_approved_jo();
	}

}
