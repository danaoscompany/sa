<?php

class Devices extends CI_Controller {

	public function index() {
		if ($this->session->logged_in == 1) {
			$userID = $this->input->post('id');
			$adminID = $this->session->user_id;
			$this->load->view('devices', array(
				'userID' => $userID,
				'adminID' => $adminID
			));
		} else {
			header("Location: https://skinmed.id/sa/devices");
		}
	}

	public function add() {
		$userID = $this->input->post('id');
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('devices/add', array(
				'userID' => $userID,
				'adminID' => $adminID
			));
		} else {
			header("Location: https://skinmed.id/sa/devices");
		}
	}

	public function edit() {
		if ($this->session->logged_in == 1) {
			$userID = $this->input->post('id');
			$uuid = $this->input->post('uuid');
			$adminID = $this->session->user_id;
			$this->load->view('devices/edit', array(
				'userID' => $userID,
				'uuid' => $uuid,
				'adminID' => $adminID
			));
		} else {
			header("Location: https://skinmed.id/sa/devices");
		}
	}

	public function delete() {
		$uuid = $this->input->post('uuid');
		$this->db->where('uuid', $uuid);
		$this->db->delete('devices');
	}

	public function get_by_user_id() {
		$userID = intval($this->input->post('user_id'));
		$this->db->where('user_id', $userID);
		echo json_encode($this->db->get('devices')->result_array());
	}

	public function add_device() {
		$userID = intval($this->input->post('user_id'));
		$uuid = $this->input->post('uuid');
		$device = $this->input->post('device');
		$model = $this->input->post('model');
		$type = $this->input->post('type');
		$this->db->insert('devices', array(
			'user_id' => $userID,
			'uuid' => $uuid,
			'device' => $device,
			'model' => $model,
			'type' => $type
		));
	}

	public function edit_device() {
		$uuid = $this->input->post('uuid');
		$device = $this->input->post('device');
		$model = $this->input->post('model');
		$type = $this->input->post('type');
		$this->db->where('uuid', $uuid);
		$this->db->update('devices', array(
			'device' => $device,
			'model' => $model,
			'type' => $type
		));
	}
}
