<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->session->userdata('user_id')) redirect('access');
	}

	public function notifs() {
		$data['newwait'] = '0';
		return $data;
	}

	public function index() {
		redirect('joborder');
		$data = $this->notifs();
		$data['menu'] = 'dashboard';
		$data['gmenu'] = '';
		$this->load->view('a_header', $data);
		$this->load->view('a_footer');
	}

}
