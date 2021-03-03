<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class AccessModel extends CI_Model
{

	function validatecredentials($input) {
		$sql = "SELECT `id`, `username`, `password`, `role`
			FROM `users`
			WHERE `username` = ? AND `password` = ?";
		$query_result = $this->db->query($sql, array($input['username'], md5($input['password'])));
		if ($query_result->num_rows() > 0) {
			foreach ($query_result->result() as $row) {
				$this->session->set_userdata (
					array (
	          'user_id'  => $row->id,
	          'user_name' => $row->username,
	          'user_role' => $row->role
          )
				);
				$this->logsmodel->log('User has logged in.');
			}
			$result['IsError'] = 0;
		}
		else {
			$result['IsError'] = 1;
		}
		return $result;
	}

	function logout() {
		$result['IsError'] = 0;
		$this->logsmodel->log('User has logged out.');
		return $result;
	}

  // Unused
	function changepassword($input) {
		$oldpasshashed = md5($input['oldpass']);
		if ($this->db->query("SELECT COUNT(`password`) AS 'COUNT' FROM `users` WHERE `password`= ? AND `id` = ?", array($oldpasshashed, $this->session->userdata('user_id')) )->row_array()['COUNT'] == '1') {
			$status = array(
				'password' => md5($input['newpass'])
			);
			$this->db->where('id', $this->session->userdata('user_id') );
			$this->db->update('users', $status);
			if($this->db->affected_rows() > 0) {
				$this->logsmodel->log('User changed password.');
				$this->session->sess_destroy();
				return "Success";
			} else return "Fail";
		} else {
			return "Wrong Old Password";
		}

	}

	function get_all_personnel() {
		$sql = "SELECT * FROM `users` WHERE `active` = 1 AND `role` <> 'system'";
		$result = $this->db->query($sql)->result_array();
		$first_name = ''; $middle_initial = ''; $last_name = ''; $name_extension = '';

		for ($i = 0; count($result) > $i; $i++) {
			if (trim($result[$i]['first_name']) != "") $first_name = trim($result[$i]['first_name']) . ' ';
			if (trim($result[$i]['middle_initial']) != "") $middle_initial = trim($result[$i]['middle_initial']) . ', ';
			if (trim($result[$i]['last_name']) != "") $last_name = trim($result[$i]['last_name']) . ' ';
			if (trim($result[$i]['name_extension']) != "") $name_extension = trim($result[$i]['name_extension']);
			$result[$i]['full_name'] = trim($first_name.$middle_initial.$last_name.$name_extension);
		}

		return $result;
	}

	function get_personnel_details_via_id($id) {
		if ($id) {
			$sql = "SELECT * FROM `users` WHERE `id` = $id";
			$result = $this->db->query($sql)->row_array();
			$first_name = ''; $middle_initial = ''; $last_name = ''; $name_extension = '';

			if($result) {
				if (trim($result['first_name']) != "") $first_name = trim($result['first_name']) . ' ';
				if (trim($result['middle_initial']) != "") $middle_initial = trim($result['middle_initial']) . ', ';
				if (trim($result['last_name']) != "") $last_name = trim($result['last_name']) . ' ';
				if (trim($result['name_extension']) != "") $name_extension = trim($result['name_extension']);
				$result['full_name'] = trim($first_name.$middle_initial.$last_name.$name_extension);
			}
			return $result;
		} else return 0;



	}

}
?>
