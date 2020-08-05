<?php

class Admin extends CI_Controller {

	public function index() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('admin', array(
				'adminID' => $adminID
			));
		} else {
			header("Location: http://skinmed.id/sa/login");
		}
	}

	public function get_sessions() {
		$sessions = $this->db->query("SELECT * FROM `sessions` ORDER BY `user_id`")->result_array();
		for ($i=0; $i<sizeof($sessions); $i++) {
			$session = $sessions[$i];
			$user = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $session['user_id'])->row_array();
			$sessions[$i]['user_name'] = $user['first_name'] . " " . $user['last_name'];
		}
		echo json_encode($sessions);
	}

	public function get_sessions_by_user_id() {
		$userID = intval($this->input->post('user_id'));
		$sessions = $this->db->query("SELECT * FROM `sessions` WHERE `user_id`=" . $userID)->result_array();
		for ($i=0; $i<sizeof($sessions); $i++) {
			$session = $sessions[$i];
			$user = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $session['user_id'])->row_array();
			$sessions[$i]['user_name'] = $user['first_name'] . " " . $user['last_name'];
		}
		echo json_encode($sessions);
	}

	public function add() {
		if ($this->session->logged_in == 1) {
			$this->load->view('admin/add');
		} else {
			header("Location: http://skinmed.id/sa/login");
		}
	}

	public function logout() {
		$this->session->unset_userdata("logged_in");
		header("Location: http://skinmed.id/sa/login");
	}

	public function edit() {
		$id = intval($this->input->get("id"));
		if ($this->session->logged_in == 1) {
			$this->load->view("admin/edit", array('id' => $id));
		} else {
			header("Location: http://skinmed.id/sa/login");
		}
	}

	public static function __callStatic($name, $arguments)
	{
		// TODO: Implement __callStatic() method.
	}

	public function add_user() {
		$uuid = $this->input->post('uuid');
		$isAdmin = intval($this->input->post('is_admin'));
		$premium = intval($this->input->post('premium'));
		$premiumStart = $this->input->post('premium_start');
		$firstName = $this->input->post('first_name');
		$lastName = $this->input->post('last_name');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$address = $this->input->post('address');
		$phone = $this->input->post('phone');
		$city = $this->input->post('city');
		$province = $this->input->post('province');
		$companyName = $this->input->post('company_name');
		$companyCity = $this->input->post('company_city');
		$companyCountry = $this->input->post('company_country');
		$companyStreet = $this->input->post('company_street');
		$companyZIP = $this->input->post('company_zip');
		$companyState = $this->input->post('company_state');
		$companyPhone = $this->input->post('company_phone');
		$this->db->where('email', $email);
		$users = $this->db->get('users')->result_array();
		if (sizeof($users) > 0) {
			echo json_encode(array(
				'response_code' => -1
			));
			return;
		}
		$this->db->where('phone', $phone);
		$users = $this->db->get('users')->result_array();
		if (sizeof($users) > 0) {
			echo json_encode(array(
				'response_code' => -2
			));
			return;
		}
		$this->db->insert('users', array(
			'uuid' => $uuid,
			'is_admin' => $isAdmin,
			'first_name' => $firstName,
			'last_name' => $lastName,
			'email' => $email,
			'phone' => $phone,
			'password' => $password,
			'address' => $address,
			'city' => $city,
			'province' => $province,
			'premium' => $premium,
			'premium_start' => $premiumStart,
			'company_name' => $companyName,
			'company_city' => $companyCity,
			'company_country' => $companyCountry,
			'company_street' => $companyStreet,
			'company_zip_code' => $companyZIP,
			'company_state' => $companyState,
			'company_phone' => $companyPhone
		));
		echo json_encode(array(
			'response_code' => 1
		));
	}

	public function update_user() {
		$id = intval($this->input->post('id'));
		$uuid = $this->input->post('uuid');
		$isAdmin = intval($this->input->post('is_admin'));
		$premium = intval($this->input->post('premium'));
		$premiumStart = $this->input->post('premium_start');
		$firstName = $this->input->post('first_name');
		$lastName = $this->input->post('last_name');
		$email = $this->input->post('email');
		$emailChanged = intval($this->input->post('email_changed'));
		$password = $this->input->post('password');
		$address = $this->input->post('address');
		$phone = $this->input->post('phone');
		$phoneChanged = intval($this->input->post('phone_changed'));
		$city = $this->input->post('city');
		$province = $this->input->post('province');
		$companyName = $this->input->post('company_name');
		$companyCity = $this->input->post('company_city');
		$companyCountry = $this->input->post('company_country');
		$companyStreet = $this->input->post('company_street');
		$companyZIP = $this->input->post('company_zip');
		$companyState = $this->input->post('company_state');
		$companyPhone = $this->input->post('company_phone');
		if ($emailChanged == 1) {
			$this->db->where('email', $email);
			$users = $this->db->get('users')->result_array();
			if (sizeof($users) > 0) {
				echo json_encode(array(
					'response_code' => -1
				));
				return;
			}
		}
		if ($phoneChanged == 1) {
			$this->db->where('phone', $phone);
			$users = $this->db->get('users')->result_array();
			if (sizeof($users) > 0) {
				echo json_encode(array(
					'response_code' => -2
				));
				return;
			}
		}
		$this->db->where('id', $id);
		$this->db->update('users', array(
			'uuid' => $uuid,
			'is_admin' => $isAdmin,
			'first_name' => $firstName,
			'last_name' => $lastName,
			'email' => $email,
			'phone' => $phone,
			'password' => $password,
			'address' => $address,
			'city' => $city,
			'province' => $province,
			'premium' => $premium,
			'premium_start' => $premiumStart,
			'company_name' => $companyName,
			'company_city' => $companyCity,
			'company_country' => $companyCountry,
			'company_street' => $companyStreet,
			'company_zip_code' => $companyZIP,
			'company_state' => $companyState,
			'company_phone' => $companyPhone
		));
		echo json_encode(array(
			'response_code' => 1
		));
	}

	public function edit_user() {
		$id = intval($this->input->post('id'));
		$firstName = $this->input->post('first_name');
		$lastName = $this->input->post('last_name');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$address = $this->input->post('address');
		$phone = $this->input->post('phone');
		$city = $this->input->post('city');
		$province = $this->input->post('province');
		$this->db->where('email', $email)->where('phone', $phone);
		$users = $this->db->get('users')->result_array();
		if (sizeof($users) > 0) {
			echo json_encode(array(
				'response_code' => -1
			));
			return;
		}
		$this->db->where('id', $id);
		$this->db->update('users', array(
			'first_name' => $firstName,
			'last_name' => $lastName,
			'email' => $email,
			'phone' => $phone,
			'password' => $password,
			'address' => $address,
			'city' => $city,
			'province' => $province
		));
		echo json_encode(array(
			'response_code' => 1
		));
	}

	public function login() {
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$admins = $this->db->query("SELECT * FROM `admins` WHERE `email`='" . $email . "' AND `password`='" . $password . "'")->result_array();
		if (sizeof($admins) > 0) {
			$admin = $admins[0];
			echo json_encode(array(
				'response_code' => 1,
				'user_id' => intval($admin['id'])
			));
			$this->session->set_userdata(array(
				"logged_in" => true,
				"user_id" => intval($admin['id'])
			));
		} else {
			echo json_encode(array(
				'response_code' => -1
			));
		}
	}
	
	public function add_admin() {
		$email = $_POST['email'];
		$password = $_POST['password'];
		if (sizeof($this->db->query("SELECT * FROM `admins` WHERE `email`='" . $email . "'")->result_array()) > 0) {
			echo -1;
		} else {
			$this->db->insert('admins', array(
				'email' => $email,
				'password' => $password
			));
			echo 1;
		}
	}

	public function get() {
		$this->db->from("admins");
		$this->db->order_by("email", "asc");
		echo json_encode($this->db->get()->result_array());
	}

	public function get_settings() {
		echo json_encode($this->db->get('settings')->result_array());
	}

	public function update_settings() {
		$premiumPrice = doubleval($this->input->post('premium_price'));
		$this->db->update('settings', array(
			'premium_price' => $premiumPrice
		));
	}

	public function edit_admin() {
		$id = intval($_POST['id']);
		$email = $_POST['email'];
		$password = $_POST['password'];
		$emailChanged = intval($_POST['email_changed']);
		if ($emailChanged == 1) {
			if (sizeof($this->db->query("SELECT * FROM `admins` WHERE `email`='" . $email . "'")->result_array()) > 0) {
				echo -1;
			} else {
				$this->db->where('id', $id);
				$this->db->update('admins', array(
					'email' => $email,
					'password' => $password
				));
				echo 1;
			}
		} else if ($emailChanged == 0) {
			$this->db->where('id', $id);
			$this->db->update('admins', array(
				'email' => $email,
				'password' => $password
			));
			echo 1;
		}
	}

	public function get_by_id() {
		$adminID = intval($this->input->post('id'));
		echo json_encode($this->db->query("SELECT * FROM `admins` WHERE `id`=" . $adminID)->row_array());
	}

	public function get_user_by_id() {
		$userID = intval($this->input->post('id'));
		echo json_encode($this->db->query("SELECT * FROM `users` WHERE `id`=" . $userID)->row_array());
	}

	public function get_users() {
		$adminID = intval($this->input->post('admin_id'));
		$start = intval($this->input->post('start'));
		$length = intval($this->input->post('length'));
		$users = $this->db->query("SELECT * FROM `user` WHERE `admin_id`=" . $adminID . " ORDER BY `first_name` ASC LIMIT " . $start . "," . $length)->result_array();
		for ($i=0; $i<sizeof($users); $i++) {
		}
		echo json_encode($users);
	}

	public function get_all_users() {
		echo json_encode($this->db->query("SELECT * FROM `users` ORDER BY `first_name`")->result_array());
	}
	
	public function get_all_users_with_length() {
		$start = intval($this->input->post('start'));
		$length = intval($this->input->post('length'));
		if ($length == -1) {
			echo json_encode($this->db->query("SELECT * FROM `users` ORDER BY `first_name`")->result_array());
			return;
		}
		$users = $this->db->query("SELECT * FROM `user` ORDER BY `first_name` ASC LIMIT " . $start . "," . $length)->result_array();
		for ($i=0; $i<sizeof($users); $i++) {
		}
		echo json_encode($users);
	}

	public function get_admins() {
		$start = intval($this->input->post('start'));
		$length = intval($this->input->post('length'));
		$admins = $this->db->query("SELECT * FROM `admins` ORDER BY `email` ASC LIMIT " . $start . "," . $length)->result_array();
		for ($i=0; $i<sizeof($admins); $i++) {
		}
		echo json_encode($admins);
	}
}
