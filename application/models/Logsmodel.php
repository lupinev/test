<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class LogsModel extends CI_Model
{

  function log($description, $user_id = -1, $ip_address = '') {
    if ($user_id == -1) {
      $user_id = $this->session->userdata('user_id');
    }

    if ($ip_address == '') {
      $ip_address = $_SERVER['REMOTE_ADDR'];
    }

    $this->db->query("INSERT INTO `logs` (`description`, `user_id`, `ip_address`) VALUES ('$description', $user_id, '$ip_address')");
  }

}
?>
