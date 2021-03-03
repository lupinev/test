<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fpdi {

	public function __construct() {
		require_once APPPATH.'third_party/fpdf/fpdf-1.8.2.php';
		require_once APPPATH.'third_party/fpdi/src/autoload.php';
	}

}
