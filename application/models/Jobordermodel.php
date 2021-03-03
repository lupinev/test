<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class JobOrderModel extends CI_Model
{ // TODO (AAA) Add Logs

  function create_update($input) {

    $data = array(
      'date_submitted' => $input['date_submitted'],
      'company' => $input['company'],
      'address' => $input['address'],
      'applicant' => $input['applicant'],
      'designation' => $input['designation'],
      'contact_number' => $input['contact_number'],
      'email_address' => $input['email_address'],
      'contact_person' => $input['contact_person'],
      'sample_type' => $input['sample_type'],
      'packaging_type' => $input['packaging_type'],
      'sample_description' => $input['sample_description'],
      'analysis_requested' => $input['custom_analysis_requested'],
      'analysis_requested_two' => ( isset($input['analysis_requested_two']) ? $input['analysis_requested_two'] : '') ,
      'purpose_of_analysis' => $input['custom_purpose_of_analysis'],
      'samples_returned' => $input['samples_returned'],
      'signed_date' => $input['date_submitted'],
      'additional_costs' => $input['additional_costs'],
      'total_cost' => $input['total_cost']
    );

    if(isset($input['jo_no'])) $data = array_merge( $data, array('jo_no' => $input['jo_no']) );
    if(isset($input['jo_status'])) $data = array_merge( $data, array('status' => $input['jo_status'] ) );

    if(isset($input['release_date'])) $data = array_merge( $data, array('release_date' => $input['release_date']) );
    if(isset($input['date_approved'])) $data = array_merge( $data, array('date_approved' => $input['date_approved']) );
    if(isset($input['approved_by_id'])) $data = array_merge( $data, array('approved_by_id' => $input['approved_by_id']) );
    if(isset($input['approved_by_name'])) $data = array_merge( $data, array('approved_by_name' => $input['approved_by_name']) );
    if(isset($input['approved_by_position'])) $data = array_merge( $data, array('approved_by_position' => $input['approved_by_position']) );
    if(isset($input['received_by_id'])) $data = array_merge( $data, array('received_by_id' => $input['received_by_id']) );
    if(isset($input['received_by_name'])) $data = array_merge( $data, array('received_by_name' => $input['received_by_name']) );
    if(isset($input['encoded_by_id'])) $data = array_merge( $data, array('encoded_by_id' => $input['encoded_by_id']) );
    if(isset($input['encoded_by_name'])) $data = array_merge( $data, array('encoded_by_name' => $input['encoded_by_name']) );

    if(!isset($input['jo_id'])) {
			$this->db->insert('job_order_request', $data);
			$jo_id = $this->db->insert_id();
		} else {
			$this->db->where('id', $input['jo_id']);
			$this->db->update('job_order_request', $data);
			$jo_id = $input['jo_id'];
		}
		if($this->db->affected_rows() > 0) $result['jo'] = true;
		else $result['jo'] = false;

    $result['items'] = true;
    for( $i=0; $i<count($input['jo_item_id']); $i++ ) {
      $item_data = array (
        'jo_id' => $jo_id,
        'pnri_code' => $input['pnri_code'][$i],
        'item_description' => $input['item_description'][$i],
        'amount' => $input['amount'][$i]
      );

			if ($input['jo_item_id'][$i] == '0' )
      	$this->db->insert('job_order_items', $item_data);
			else {
				$this->db->where('id', $input['jo_item_id'][$i]);
				$this->db->update('job_order_items', $item_data);
			}

      if($this->db->affected_rows() > 0) { }
      else $result['items'] = false;
    }

    return array_merge($result, $input);

  }

  function read($selectedType) {
    $result = array();

    $sql = "SELECT `id`, `jo_no`, `company`, `applicant`, `analysis_requested`, DATE_FORMAT(`release_date`,'%b %d, %Y') `release_date_f`
    FROM `job_order_request` WHERE `status` = ?";
    $query_result = $this->db->query($sql, $selectedType);

    if($query_result->num_rows() > 0) {
      foreach($query_result->result() as $rows) {
        $action = ''; $samples = '';

        $sql2 = "SELECT `pnri_code` FROM `job_order_items` WHERE `jo_id` = ? AND `status` = 'active'";
        $query_result_2 = $this->db->query($sql2, $rows->id)->result_array();
        for($i=0;$i<count($query_result_2);$i++){
          $samples.= $query_result_2[$i]['pnri_code']."<br>";
        }

        // Status Start
        $selectedType;
        if ($selectedType == "pending") {
          $status_gui = "<button type='button' class='btn btn-circle btn-xs red-pink'>For Approval</button>";
        } else if ($selectedType == "active") {
          $status_gui = "<button type='button' class='btn btn-circle btn-xs blue-madison'>Pending</button>";
        }
        // Status End

        // Action Start
        $action.= '<button onclick="retrieve_JO('.$rows->id.')" class="btn btn-circle btn-sm blue-madison tags" glose="Edit"><i class="fa fa-edit"></i></button>';
        if ($selectedType == "pending") {
          $action.= '<button onclick="reject_JO('.$rows->id.')" class="btn btn-circle btn-sm red-thunderbird tags" glose="Reject"><i class="fa fa-times"></i></button>';
        }
        if ($selectedType == "active") {
          $link = base_url('export/jo').'/'.$rows->id;
          $action.= '<button onclick="preview_JO('.$rows->id.')" class="btn btn-circle btn-sm tags" target="_blank" glose="Preview"><i class="fa fa-print"></i></button>';
        }
        // Action End

        if ($selectedType == "active") {
          $result[] = array(
            $rows->jo_no,
            $rows->company,
            $rows->applicant,
            $rows->analysis_requested,
            $samples,
            $rows->release_date_f,
            $status_gui,
            $action
          );
        } else if ($selectedType == "pending") {
          $result[] = array(
            $rows->company,
            $rows->applicant,
            $rows->analysis_requested,
            $status_gui,
            $action
          );
        }

      }
    }

    return $result;
  }

  function read_selected_id($selected_jo_id) {
    $sql = "SELECT * FROM `job_order_request` WHERE `id` = ? ";
    $data = $this->db->query($sql, $selected_jo_id)->row_array();
    $sql2 = "SELECT * FROM `job_order_items` WHERE `jo_id` = ? ";
    $item_data = $this->db->query($sql2, $selected_jo_id)->result_array();

    $sql3 = "SELECT DATE_FORMAT(`date_submitted`,'%b %d, %Y') 'format_date_submitted',
      DATE_FORMAT(`release_date`,'%b %d, %Y') 'format_release_date',
      DATE_FORMAT(`signed_date`,'%b %d, %Y') 'format_signed_date',
      DATE_FORMAT(`date_approved`,'%b %d, %Y') 'format_date_approved'
      FROM `job_order_request` WHERE `id` = ? ";
    $formatted_data = $this->db->query($sql3, $selected_jo_id)->row_array();

    $result['jo_data'] = $data;
    $result['jo_item_data'] = $item_data;
    $result['jo_formatted_data'] = $formatted_data;

    return $result;
  }

  function reject_selected_jo_id($jo_recect_id) {
    $data = array( 'status' => 'rejected' );
    $this->db->where('id', $jo_recect_id);
    $this->db->update('job_order_request', $data);

    if($this->db->affected_rows() > 0) {
      $result['operation'] = true;
    } else {
      $result['operation'] = false;
    }

    return $result;
  }

  function check_duplicate_JO($jo_no) {
    $sql = "SELECT COUNT(`jo_no`) AS 'duplicate' FROM `job_order_request` WHERE `jo_no` = ? ";
    $query = $this->db->query($sql, $jo_no)->row_array()["duplicate"];
    return $query > 0 ? $query["duplicate"] : array();
  }

  function check_duplicate_pnri_code($pnri_code) {
    $sql = "SELECT COUNT(`joi`.`pnri_code`) AS 'duplicate'
      FROM `job_order_items` AS `joi`
      INNER JOIN `job_order_request` AS `jor`
      ON `jor`.`id` = `joi`.`jo_id`
      AND `jor`.`status` = 'active'
      WHERE `joi`.`pnri_code` = ? ";
    $query = $this->db->query($sql, $pnri_code)->row_array()["duplicate"];
    return $query > 0 ? $query["duplicate"] : array();
  }

  function remove_this_line ($jo_item_id) {
    $id = array ( 'id' => $jo_item_id );
    $this->db->delete('job_order_items', $id);

    if($this->db->affected_rows() > 0) { $result['result'] = true; }
    else $result['result'] = false;
    return $result;
  }

  function get_companies() {
    $sql = "SELECT DISTINCT `company` FROM `job_order_request`";
    $query = $this->db->query($sql)->result_array();
    return $query > 0 ? $query : array();
  }

  function get_specific_address($company) {
    $sql = "SELECT DISTINCT `address` FROM `job_order_request` WHERE `company` = ?";
    $query = $this->db->query($sql, $company)->result_array();
    return $query > 0 ? $query : array();
  }

  function get_specific_applicant($company) {
    $sql = "SELECT DISTINCT `applicant` FROM `job_order_request` WHERE `company` = ?";
    $query = $this->db->query($sql, $company)->result_array();
    return $query > 0 ? $query : array();
  }

  function get_specific_designation($company) {
    $sql = "SELECT DISTINCT `designation` FROM `job_order_request` WHERE `company` = ?";
    $query = $this->db->query($sql, $company)->result_array();
    return $query > 0 ? $query : array();
  }

  function get_specific_contact_number($company) {
    $sql = "SELECT DISTINCT `contact_number` FROM `job_order_request` WHERE `company` = ?";
    $query = $this->db->query($sql, $company)->result_array();
    return $query > 0 ? $query : array();
  }

  function get_specific_email_address($company) {
    $sql = "SELECT DISTINCT `email_address` FROM `job_order_request` WHERE `company` = ?";
    $query = $this->db->query($sql, $company)->result_array();
    return $query > 0 ? $query : array();
  }

  function get_specific_contact_person($company) {
    $sql = "SELECT DISTINCT `contact_person` FROM `job_order_request` WHERE `company` = ?";
    $query = $this->db->query($sql, $company)->result_array();
    return $query > 0 ? $query : array();
  }

  function change_fee($settings) { $fee = 0;
    if ($settings['ar'] == "APC") {
      $fee = 500;
    } else if ($settings['ar'] == "MYC") {
      $fee = 500;
    } else if ($settings['ar'] == "BIO") {
      if($settings['ar2'] == "big") {
        $fee = 500;
      } else if ($settings['ar2'] == "small") {
        $fee = 500;
      }
    } else if ($settings['ar'] == "STT") {
      if($settings['ar2'] == "big") {
        $fee = 1000;
      } else if ($settings['ar2'] == "small") {
        $fee = 600;
      }
    } else if ($settings['ar'] == "") {

    }

    return $fee;
  }

  function notif_get_pending_jo_count() {
    $query = $this->db->query("SELECT COUNT(*) AS 'count' FROM `job_order_request` WHERE `status` = 'pending'")->row_array();
    return $query > 0 ? $query['count'] : 0;
  }

  public function get_sync_approved_jo_count() {
    $ptl = $this->load->database('portal', TRUE);
    $query = $ptl->query("SELECT COUNT(*) AS 'count' FROM `t_appoint` WHERE `status` = 'Accepted'")->row_array();
    return $query > 0 ? $query['count'] : 0;
  }

  public function get_sync_latest_approved_jo() {
    $ptl = $this->load->database('portal', TRUE);
    $query = $ptl->query("SELECT `ref_no` FROM `t_appoint` WHERE `status` = 'Accepted' ORDER BY `r_id` DESC LIMIT 1")->row_array();
    return $query > 0 ? $query['ref_no'] : "";
  }

}
