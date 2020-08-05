<?php

class Sessions extends CI_Controller {

	public function index() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view("sessions", array(
				'adminID' => $adminID
			));
		} else {
			header("Location: http://localhost/sa/login");
		}
	}

	public function get_by_id() {
		$id = intval($this->input->post('id'));
		$this->db->where('id', $id);
		$session = $this->db->get('sessions')->row_array();
		$userID = intval($session['user_id']);
		$this->db->where('id', $userID);
		$user = $this->db->get('users')->row_array();
		$session['user_name'] = $user['first_name'] . " " . $user['last_name'];
		echo json_encode($session);
	}

	public function get_by_uuid() {
		$uuid = $this->input->post('uuid');
		$this->db->where('uuid', $uuid);
		$session = $this->db->get('sessions')->row_array();
		$userID = intval($session['user_id']);
		$this->db->where('id', $userID);
		$user = $this->db->get('users')->row_array();
		$session['user_name'] = $user['first_name'] . " " . $user['last_name'];
		echo json_encode($session);
	}

	public function get_by_user_id() {
		$userID = intval($this->input->post('user_id'));
		$this->db->from('sessions');
		$this->db->where('user_id', $userID);
		$this->db->order_by('name', 'asc');
		$sessions = $this->db->get()->result_array();
		for ($i=0; $i<sizeof($sessions); $i++) {
			$session = $sessions[$i];
			$userID = intval($session['user_id']);
			$this->db->where('id', $userID);
			$user = $this->db->get('users')->row_array();
			$sessions[$i]['user_name'] = $user['first_name'] . " " . $user['last_name'];
		}
		echo json_encode($sessions);
	}

	public function add() {
		if ($this->session->logged_in == 1) {
			$this->load->view("sessions/add", array(
				'adminID' => $this->session->user_id
			));
		} else {
			header("Location: http://localhost/sa/login");
		}
	}

	public function edit() {
		if ($this->session->logged_in == 1) {
			$uuid = $this->input->post('uuid');
			$this->load->view("sessions/edit", array(
				'sessionUUID' => $uuid,
				'adminID' => $this->session->user_id
			));
		} else {
			header("Location: http://localhost/sa/login");
		}
	}

	public function delete_by_uuid() {
		$uuid = $this->input->post('uuid');
		$this->db->where('uuid', $uuid);
		$this->db->delete('sessions');
		echo $uuid;
	}

	public function add_session() {
		$uuid = $this->input->post('uuid');
		$name = $this->input->post('name');
		$userID = intval($this->input->post('user_id'));
		$patientUUID = $this->input->post('patient_uuid');
		$date = $this->input->post('date');
		$this->db->insert('sessions', array(
			'uuid' => $uuid,
			'user_id' => $userID,
			'name' => $name,
			'patient_uuid' => $patientUUID,
			'date' => $date
		));
	}
	
	public function update_session() {
		$uuid = $this->input->post('uuid');
		$name = $this->input->post('name');
		$userID = intval($this->input->post('user_id'));
		$patientUUID = $this->input->post('patient_uuid');
		$date = $this->input->post('date');
		$this->db->where('uuid', $uuid);
		$this->db->update('sessions', array(
			'user_id' => $userID,
			'name' => $name,
			'patient_uuid' => $patientUUID,
			'date' => $date
		));
	}
}
