<?php

class Patients extends CI_Controller {

	public function index() {
		$userID = intval($this->input->get('id'));
		if ($this->session->logged_in == 1) {
			$this->load->view('patients', array(
				'id' => $userID
			));
		} else {
			header("Location: http://localhost/sa/login");
		}
	}

	public function add() {
		if ($this->session->logged_in == 1) {
			$userID = intval($this->input->get('id'));
			$this->load->view("patients/add", array(
				'id' => $userID
			));
		} else {
			header("Location: http://localhost/sa/patients/add");
		}
	}

	public function edit() {
		if ($this->session->logged_in == 1) {
			$userID = intval($this->input->get('id'));
			$uuid = $this->input->get('uuid');
			$this->load->view("patients/edit", array(
				'id' => $userID,
				'uuid' => $uuid
			));
		} else {
			header("Location: http://localhost/sa/patients/edit");
		}
	}

	public function add_patient() {
		$userID = intval($this->input->post('user_id'));
		$uuid = $this->input->post('uuid');
		$name = $this->input->post('name');
		$address = $this->input->post('address');
		$city = $this->input->post('city');
		$province = $this->input->post('province');
		$birthday = $this->input->post('birthday');
		$this->db->insert('patients', array(
			'uuid' => $uuid,
			'user_id' => $userID,
			'name' => $name,
			'address' => $address,
			'city' => $city,
			'province' => $province,
			'birthday' => $birthday
		));
	}

	public function edit_patient() {
		$uuid = $this->input->post('uuid');
		$name = $this->input->post('name');
		$address = $this->input->post('address');
		$city = $this->input->post('city');
		$province = $this->input->post('province');
		$birthday = $this->input->post('birthday');
		$this->db->where('uuid', $uuid);
		$this->db->update('patients', array(
			'name' => $name,
			'address' => $address,
			'city' => $city,
			'province' => $province,
			'birthday' => $birthday
		));
	}
}
