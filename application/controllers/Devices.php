<?php

class Devices extends CI_Controller {

	public function index() {
		$userID = $this->input->post('id');
		if ($this->session->logged_in == 1) {
			$this->load->view('devices', array(
				'userID' => $userID
			));
		} else {
			header("Location: http://skinmed.id/sa/devices");
		}
	}

	public function add() {
		$userID = $this->input->get('id');
		$this->load->view('devices/add', array(
			'userID' => $userID
		));
	}

	public function edit() {
		$userID = $this->input->get('id');
		$uuid = $this->input->get('uuid');
		$this->load->view('devices/edit', array(
			'userID' => $userID,
			'uuid' => $uuid
		));
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