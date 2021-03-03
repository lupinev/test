<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	function get_initials($nm){
		$acronym = "";
		if($nm) {
			$words = preg_split("/[\s,_-]+/", $nm);
			foreach ($words as $w) {
				$acronym .= $w[0];
			}
		}
		return $acronym;
	}

  public function JO_Test() {
    $id = $this->uri->segment(3, -1);
    if ($id == -1) exit();

    $data = $this->jobordermodel->read_selected_id($id);
    echo "<pre>"; print_r($data);
  }

  public function JO () {
    $id = $this->uri->segment(3, -1);
    if ($id == -1) exit();

    $data = $this->jobordermodel->read_selected_id($id);

    $this->load->library('Fpdi');
    $pdf = new \setasign\Fpdi\Fpdi('P', 'mm', 'A4');

    $pdf->SetTitle('');
    $border = 0;
    $pdf->SetAutoPageBreak(false, 0);
    $pdf->SetFont('Times', '', 9);

    $pdf->AddPage();
    $pdf->setSourceFile(FCPATH.'assets/JOF-BMR-Rev.3-5-719.pdf');
    $jo_form = $pdf->importPage(1);
    $pdf->useTemplate($jo_form);

    if(isset($data['jo_data']['jo_no'])) {
      $pdf->SetFont('Times', 'B', 9);
      $jo_no = str_replace("JOF-BMRS","",$data['jo_data']['jo_no']);
      $pdf->setXY(42.25, 33.25); $pdf->MultiCell(24, 3, utf8_decode($jo_no), $border, 'L');
    }

    if (isset($data['jo_formatted_data']['format_date_submitted'])) {
      $pdf->SetFont('Times', '', 9);
      $pdf->setXY(46, 46); $pdf->MultiCell(57, 3, utf8_decode($data['jo_formatted_data']['format_date_submitted']), $border, 'L');
    }

    if (isset($data['jo_data']['company'])) {
      $pdf->setXY(45.75, 53.5); $pdf->MultiCell(60, 3, utf8_decode($data['jo_data']['company']), $border, 'L');
    }

    if (isset($data['jo_data']['address'])) {
      $pdf->setXY(45.75, 60.5); $pdf->MultiCell(60, 3.5, utf8_decode($data['jo_data']['address']), $border, 'L');
    }

    if (isset($data['jo_data']['applicant'])) {
      $pdf->setXY(45.75, 71.5); $pdf->MultiCell(60, 3, utf8_decode($data['jo_data']['applicant']), $border, 'L');
    }

    if (isset($data['jo_data']['designation'])) {
      $pdf->setXY(45.75, 79); $pdf->MultiCell(60, 3, utf8_decode($data['jo_data']['designation']), $border, 'L');
    }

    if (isset($data['jo_data']['contact_number'])) {
      $pdf->setXY(144, 46); $pdf->MultiCell(44, 3, utf8_decode($data['jo_data']['contact_number']), $border, 'L');
    }

    if (isset($data['jo_data']['email_address'])) {
      $pdf->setXY(144, 53.25); $pdf->MultiCell(44, 3, utf8_decode($data['jo_data']['email_address']), $border, 'L');
    }

    if (isset($data['jo_data']['contact_person'])) {
      $pdf->setXY(106, 64); $pdf->MultiCell(82, 3.5, utf8_decode($data['jo_data']['contact_person']), $border, 'L');
    }

		// APPLICATION DETAILS //

    if (isset($data['jo_data']['sample_type'])) {
      $pdf->setXY(58.5, 91.4); $pdf->MultiCell(47, 3, utf8_decode($data['jo_data']['sample_type']), $border, 'L');
    }

    if (isset($data['jo_data']['packaging_type'])) {
      $pdf->setXY(58.5, 101); $pdf->MultiCell(47, 3, utf8_decode($data['jo_data']['packaging_type']), $border, 'L');
    }

    if (isset($data['jo_item_data'])) {
      $pdf->setXY(58.5, 110.7); $pdf->MultiCell(47, 3, utf8_decode(sizeof($data['jo_item_data'])), $border, 'L');
    }

    if (isset($data['jo_data']['sample_description'])) {
      $pdf->setXY(58.5, 120.6); $pdf->MultiCell(47, 3, utf8_decode($data['jo_data']['sample_description']), $border, 'L');
    }


		// sample y
		$sy[0]['y'] = 130;   $sy[0]['w'] = 4;
		$sy[1]['y'] = 134.8; $sy[1]['w'] = 4;
		$sy[2]['y'] = 139.7; $sy[2]['w'] = 4;
		$sy[3]['y'] = 144.6; $sy[3]['w'] = 4;
		$sy[4]['y'] = 149.5; $sy[4]['w'] = 3.5;
		$sy[5]['y'] = 153.2; $sy[5]['w'] = 3.4;
		$sy[6]['y'] = 157;   $sy[6]['w'] = 3.4;
		$sy[7]['y'] = 160.8; $sy[7]['w'] = 3.4;
		$sy[8]['y'] = 164.4; $sy[8]['w'] = 3.4;
		$sy[9]['y'] = 168;   $sy[9]['w'] = 3;

		$cnt=0; $sample_cost = 0;
		for($i=0; $i < sizeof($data['jo_item_data']); $i++) {
			$stringWidth = $pdf->GetStringWidth($data['jo_item_data'][$i]['item_description']);
			$pdf->setXY(27, $sy[$cnt]['y']); $pdf->Cell(32, $sy[$cnt]['w'], utf8_decode($data['jo_item_data'][$i]['pnri_code']), $border, 0, 'C');
			if ($stringWidth > 46) { //hanggang 46 lang string width, pag lumagpas, next line na, palagpasin natin ng unti haha
				$pdf->setXY(58.4, $sy[$cnt]['y']); $pdf->MultiCell(45, $sy[$cnt]['w'], utf8_decode($data['jo_item_data'][$i]['item_description']), $border, 'L');
				$cnt+=2;
			} else {
				$pdf->setXY(58.4, $sy[$cnt]['y']); $pdf->Cell(45, $sy[$cnt]['w'], utf8_decode($data['jo_item_data'][$i]['item_description']), $border, 0);
				$cnt+=1;
			}

			$sample_cost += $data['jo_item_data'][$i]['amount'];
		}

    if (isset($data['jo_data']['analysis_requested'])) {
      if ($data['jo_data']['analysis_requested'] == 'APC') {
        $pdf->setXY(107, 95.8); $pdf->Cell(4, 4, "X", $border, 0);
      } else if ($data['jo_data']['analysis_requested'] == 'MYC') {
        $pdf->setXY(107, 100.6); $pdf->Cell(4, 4, "X", $border, 0);
      } else if ($data['jo_data']['analysis_requested'] == 'BIO') {
        $pdf->setXY(107, 105.4); $pdf->Cell(4, 4, "X", $border, 0);
      } else if ($data['jo_data']['analysis_requested'] == 'STT') {
        $pdf->setXY(107, 110.2); $pdf->Cell(4, 4, "X", $border, 0);
      } else if ($data['jo_data']['analysis_requested'] == 'PTC') {
        $pdf->setXY(107, 115); $pdf->Cell(4, 4, "X", $border, 0);
      } else {
        $pdf->setXY(107, 119.8); $pdf->Cell(4, 4, "X", $border, 0);
        $pdf->setXY(112.7, 120.2); $pdf->MultiCell(75, 4.4, "                                        ".$data['jo_data']['analysis_requested'], $border, 'L');
      }
    }

    if (isset($data['jo_data']['purpose_of_analysis'])) {
      if ($data['jo_data']['purpose_of_analysis'] == 'export') {
        $pdf->setXY(107, 134.5); $pdf->Cell(4, 4, "X", $border, 0);
      } else if ($data['jo_data']['purpose_of_analysis'] == 'regulatory') {
        $pdf->setXY(107, 139.3); $pdf->Cell(4, 4, "X", $border, 0);
      } else if ($data['jo_data']['purpose_of_analysis'] == 'research') {
        $pdf->setXY(107, 144.1); $pdf->Cell(4, 4, "X", $border, 0);
      } else if ($data['jo_data']['purpose_of_analysis'] == 'local market') {
        $pdf->setXY(145.8, 134.5); $pdf->Cell(4, 4, "X", $border, 0);
      } else {
        $pdf->setXY(107, 148.9); $pdf->Cell(4, 4, "X", $border, 0);
        $pdf->setXY(112.7, 149.3); $pdf->MultiCell(75, 3.8, "                                        ".$data['jo_data']['purpose_of_analysis'], $border, 'L');
      }
    }

    if (isset($data['jo_data']['samples_returned'])) {
      if($data['jo_data']['samples_returned'] == 0) {
        $pdf->setXY(158.3, 160); $pdf->Cell(4, 4, "X", $border, 0);
      } else if($data['jo_data']['samples_returned'] == 1) {
        $pdf->setXY(145.8, 160); $pdf->Cell(4, 4, "X", $border, 0);
      }
    }

		// TERMS and CONDITIONS //

		if (isset($data['jo_formatted_data']['format_release_date'])) {
			$pdf->setXY(80, 181); $pdf->MultiCell(21, 3, utf8_decode($data['jo_formatted_data']['format_release_date']), $border, 'C');
		}

		if (isset($data['jo_formatted_data']['format_signed_date'])) {
			$pdf->setXY(110, 207.3); $pdf->MultiCell(21, 3, utf8_decode($data['jo_formatted_data']['format_signed_date']), $border, 'C');
		}

		if (isset($data['jo_formatted_data']['format_release_date'])) {
			$pdf->setXY(110, 226); $pdf->MultiCell(21, 3, utf8_decode($data['jo_formatted_data']['format_date_approved']), $border, 'C');
		}

		// FOOTER //

		$pdf->setXY(57, 251.5); $pdf->Cell(50, 3, $this->get_initials(utf8_decode($data['jo_data']['received_by_name'])), $border, 0);
		$pdf->setXY(57, 259.1); $pdf->Cell(50, 3, $this->get_initials(utf8_decode($data['jo_data']['encoded_by_name'])), $border, 0);

		$pdf->setXY(147, 248); $pdf->Cell(4, 3, "P", $border, 0);
		$pdf->setXY(151, 248); $pdf->Cell(33, 3, $sample_cost, $border, 0, 'R');

		$pdf->setXY(147, 251.4); $pdf->Cell(4, 3, "P", $border, 0);
		$pdf->setXY(151, 251.4); $pdf->Cell(33, 3, $data['jo_data']['additional_costs'], $border, 0, 'R');

		$pdf->setXY(147, 255.1); $pdf->Cell(4, 3, "P", $border, 0);
		$pdf->setXY(151, 255.1); $pdf->Cell(33, 3, $data['jo_data']['total_cost'], $border, 0, 'R');


    $pdf->Output();
  }

}
