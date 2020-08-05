<?php

class Image extends CI_Controller {

	public function index() {
		if ($this->session->logged_in == 1) {
			$this->load->view('image');
		} else {
			header("Location: http://localhost/sa/login");
		}
	}

	public function view_image() {
		$uuid = $this->input->post('uuid');
		if ($this->session->logged_in == 1) {
			$this->load->view('image/view', array(
				'uuid' => $uuid
			));
		} else {
			header("Location: http://localhost/sa/login");
		}
	}

	public function get_images() {
		$userID = intval($this->input->post('user_id'));
		$sessionUUID = $this->input->post('session_uuid');
		echo json_encode($this->db->query("SELECT * FROM `bucket_images` WHERE `user_id`=" . $userID . " AND `session_uuid`='" . $sessionUUID . "' ORDER BY `date`")->result_array());
	}

	public function get_by_uuid() {
		$uuid = $this->input->post('uuid');
		echo json_encode($this->db->query("SELECT * FROM `bucket_images` WHERE `uuid`='" . $uuid . "'")->row_array());
	}
}
