<?php

class Home extends CI_Controller {

	public function index() {
		if ($this->session->logged_in == 1) {
			$this->load->view('home');
		} else {
			header("Location: http://localhost/sa/login");
		}
	}
}
