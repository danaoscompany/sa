<?php

class Common extends CI_Controller {

	public function index() {
		if ($this->session->logged_in == 1) {
			$userID = $this->session->user_id;
			echo "Logged in, user ID: " . $userID . "<br/>";
			/*$this->load->view('common', array(
				'userID' => $userID
			));*/
		} else {
			//header("Location: http://skinmed.id/sa/devices");
			echo "Not logged in";
		}
	}
}
