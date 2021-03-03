<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mpdf6 {

	public function __construct() {
		require_once APPPATH.'third_party/mpdf/mpdf.php';
	}

}
