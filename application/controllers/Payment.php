<?php

class Payment extends CI_Controller {

	public function index() {
		$this->unpaid();
	}

	public function unpaid() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('payment/unpaid', array(
				'adminID' => $adminID
			));
		} else {
			header("Location: https://admin.skinmed.id/login");
		}
	}

	public function paid() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('payment/paid', array(
				'adminID' => $adminID
			));
		} else {
			header("Location: https://admin.skinmed.id/login");
		}
	}

	public function get_paid_payments() {
		$userID = intval($this->input->post('user_id'));
		$this->db->where('user_id', $userID);
		$payments = $this->db->get('payment_history')->result_array();
		for ($i=0; $i<sizeof($payments); $i++) {
			$this->db->where('id', intval($payments[$i]['user_id']));
			$user = $this->db->get('users')->row_array();
			$payments[$i]['user'] = $user;
		}
		echo json_encode($payments);
	}

	public function get_unpaid_payments() {
		$userID = intval($this->input->post('user_id'));
		$this->db->where('user_id', $userID);
		$payments = $this->db->get('pending_payments')->result_array();
		for ($i=0; $i<sizeof($payments); $i++) {
			$this->db->where('id', intval($payments[$i]['user_id']));
			$user = $this->db->get('users')->row_array();
			$payments[$i]['user'] = $user;
		}
		echo json_encode($payments);
	}

	public function delete_pending_payments() {
		$id = intval($this->input->post('id'));
		$this->db->where('id', $id);
		$this->db->delete('pending_payments');
	}

	public function delete_payment_history() {
		$id = intval($this->input->post('id'));
		$this->db->where('id', $id);
		$this->db->delete('payment_history');
	}
}
