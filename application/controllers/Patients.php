<?php

class Patients extends CI_Controller {

	public function index() {
		$userID = intval($this->input->post('id'));
		if ($this->session->logged_in == 1) {
			$this->load->view('patients', array(
				'adminID' => intval($this->session->user_id),
				'userID' => $userID
			));
		} else {
			header("Location: http://skinmed.id/sa/login");
		}
	}

	public function get() {
		echo json_encode($this->db->get('patients')->result_array());
	}
	
	public function get_by_uuid() {
		$uuid = $this->input->post('uuid');
		$this->db->where('uuid', $uuid);
		echo json_encode($this->db->get('patients')->row_array());
	}

	public function get_by_user_id() {
		$userID = intval($this->input->post('user_id'));
		$this->db->where('user_id', $userID);
		echo json_encode($this->db->get('patients')->result_array());
	}

	public function add() {
		if ($this->session->logged_in == 1) {
			$userID = intval($this->input->post('id'));
			$this->load->view("patients/add", array(
				'id' => $userID
			));
		} else {
			header("Location: http://skinmed.id/sa/patients/add");
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
			header("Location: http://skinmed.id/sa/patients/edit");
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
		$gender = $this->input->post('gender');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$this->db->insert('patients', array(
			'uuid' => $uuid,
			'user_id' => $userID,
			'name' => $name,
			'address' => $address,
			'city' => $city,
			'province' => $province,
			'birthday' => $birthday,
			'gender' => $gender,
			'email' => $email,
			'phone' => $phone
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
