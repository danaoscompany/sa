<?php

class Common extends CI_Controller {

	public function index() {
		echo "Halo dunia 123";
		/*if ($this->session->logged_in == 1) {
			$userID = $this->session->user_id;
			$this->load->view('common', array(
				'userID' => $userID
			));
		} else {
			header("Location: http://skinmed.id/sa/devices");
		}*/
	}
}
