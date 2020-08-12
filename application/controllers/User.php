<?php

include "FCM.php";

class User extends CI_Controller {

	public function index() {
		if ($this->session->logged_in == 1) {
			$userID = intval($this->session->user_id);
			$this->load->view('user', array(
				'id' => $userID
			));
		} else {
			header("Location: http://localhost/sa/login");
		}
	}

	public function get() {
		$this->db->from('users');
		$this->db->order_by('first_name', 'asc');
		echo json_encode($this->db->get()->result_array());
	}

	public function get_by_id() {
		$id = intval($this->input->post('id'));
		$this->db->from('users');
		$this->db->where('id', $id);
		echo json_encode($this->db->get()->row_array());
	}

	public function purchase() {
		$userID = intval($this->input->post('user_id'));
		$externalID = $this->input->post('external_id');
		$type = $this->input->post('type');
		$amount = intval($this->input->post('amount'));
		$date = $this->input->post('date');
		$this->db->where('user_id', $userID)->where('type', $type);
		$results = $this->db->get('pending_payments')->result_array();
		if (sizeof($results) > 0) {
			$this->db->where('user_id', $userID)->where('type', $type);
			$this->db->delete('pending_payments');
		}
		$this->db->insert('pending_payments', array(
			'user_id' => $userID,
			'external_id' => $externalID,
			'type' => $type,
			'amount' => $amount,
			'date' => $date
		));
	}
	
	public function get_premium_price() {
		echo $this->db->get('settings')->row_array()['premium_price'];
	}
	
	public function update_payment_callback() {
		$externalID = $this->input->post('external_id');
		$callback = $this->input->post('callback');
		$this->db->where('external_id', $externalID);
		$this->db->update('pending_payments', array(
			'callback' => $callback
		));
	}
	
	public function update_premium_status() {
		$userID = intval($this->input->post('user_id'));
		$premium = intval($this->input->post('premium'));
		$this->db->where('id', $userID);
		$this->db->update('users', array(
			'premium' => $premium
		));
	}
	
	public function payment_done() {
		$data = json_decode(file_get_contents("php://input"), true);
		write_file('content.txt', json_encode($data));
		$externalID = $data['external_id'];
		$this->db->where('external_id', $externalID);
		$this->db->update('pending_payments', array(
			'status' => 'paid',
			'paid_callback' => json_encode($data)
		));
		$this->db->where('external_id', $externalID);
		$payment = $this->db->get('pending_payments')->row_array();
		$this->db->where('id', intval($payment['id']));
		$this->db->delete('pending_payments');
		$this->db->insert('payment_history', array(
			'user_id' => intval($payment['user_id']),
			'external_id' => $payment['external_id'],
			'amount' => intval($payment['amount']),
			'type' => $payment['type'],
			'date' => $payment['date'],
			'status' => $payment['status'],
			'payment_url' => $payment['payment_url'],
			'callback' => $payment['callback'],
			'paid_callback' => $payment['paid_callback']
		));
		$userID = intval($payment['user_id']);
		$this->db->where('id', $userID);
		$user = $this->db->get('users')->row_array();
		FCM::send_message('Payment sudah Anda lakukan', 'Klik untuk melihat info lebih lanjut', $user['fcm_token'], array(
			'action' => 'payment_done',
			'external_id' => $externalID,
			'callback' => $data,
			'type' => $payment['type'],
			'user_id' => $userID,
			'premium' => 1
		));
		if ($payment['type'] == 'premium_purchase') {
			$date = $data['updated'];
			$date = str_replace("T", " ", $date);
			$date = str_replace("Z", " ", $date);
			$date = substr($date, 0, strpos($date, "."));
			$this->db->where('id', $userID);
			$this->db->update('users', array(
				'premium' => 1,
				'premium_start' => $date
			));
		}
	}
	
	public function get_latest_bucket_image_id() {
		$userID = intval($this->input->post('user_id'));
		$results = $this->db->query("SELECT * FROM `session_images` WHERE `user_id`=" . $userID . " ORDER BY `id` DESC LIMIT 1")->result_array();
		if (sizeof($results) > 0) {
			echo intval($results[0]['photo_num'])+1;
		} else {
			echo 1;
		}
	}
	
	public function update_device_detail() {
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
	
	public function get_latest_photo_num() {
		$sessionUUID = $this->input->post('session_uuid');
		$sessionImage = $this->db->query("SELECT * FROM `session_images` WHERE `session_uuid`='" . $sessionUUID . "' ORDER BY `photo_num` DESC LIMIT 1")->row_array();
		if ($sessionImage != null) {
			echo intval($sessionImage['photo_num'])+1;
		} else {
			echo 1;
		}
	}
	
	public function get_latest_preview_photo_num() {
		$sessionUUID = $this->input->post('session_uuid');
		$sessionImage = $this->db->query("SELECT * FROM `preview_images` WHERE `session_uuid`='" . $sessionUUID . "' ORDER BY `photo_num` DESC LIMIT 1")->row_array();
		if ($sessionImage != null) {
			echo intval($sessionImage['photo_num'])+1;
		} else {
			echo 1;
		}
	}
	
	public function get_premium_status() {
		$userID = intval($this->input->post('user_id'));
		$this->db->where('id', $userID);
		$user = $this->db->get('users')->row_array();
		echo json_encode(array(
			'premium' => intval($user['premium']),
			'premium_start' => $user['premium_start']
		));
	}

	public function add() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('user/add', array(
				'adminID' => $adminID
			));
		} else {
			header("Location: http://localhost/sa/login");
		}
	}

	public function edit() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$userID = intval($this->input->post('user_id'));
			$this->load->view('user/edit', array(
				'adminID' => $adminID,
				'userID' => $userID
			));
		} else {
			header("Location: http://localhost/sa/login");
		}
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
	
	public function update_device_by_uuid() {
		$userID = intval($this->input->post('user_id'));
		$uuid = $this->input->post('uuid');
		$device = $this->input->post('device');
		$model = $this->input->post('model');
		$type = $this->input->post('type');
		$this->db->where('uuid', $uuid);
		$this->db->update('devices', array(
			'user_id' => $userID,
			'device' => $device,
			'model' => $model,
			'type' => $type
		));
	}
	
	public function delete_device_by_uuid() {
		$uuid = $this->input->post('uuid');
		$this->db->where('uuid', $uuid);
		$this->db->delete('devices');
	}
	
	public function get_all_devices() {
		echo json_encode($this->db->query("SELECT * FROM `devices` ORDER BY `device`")->result_array());
	}
	
	public function get_session_by_uuid() {
		$uuid = $this->input->post('uuid');
		$this->db->where('uuid', $uuid);
		echo json_encode($this->db->get('sessions')->row_array());
	}
	
	public function get_patient_by_uuid() {
		$uuid = $this->input->post('uuid');
		$this->db->where('uuid', $uuid);
		echo json_encode($this->db->get('patients')->row_array());
	}
	
	public function get_patients_by_user_id() {
		$userID = intval($this->input->post('user_id'));
		$patients = $this->db->query("SELECT * FROM `patients` WHERE `user_id`=" . $userID)->result_array();
		echo json_encode($patients);
	}

	public function add_patient() {
		$userID = intval($this->input->post('user_id'));
		$uuid = $this->input->post('uuid');
		$name = $this->input->post('name');
		$phone = $this->input->post('phone');
		$address = $this->input->post('address');
		$city = $this->input->post('city');
		$province = $this->input->post('province');
		$birthday = $this->input->post('birthday');
		$this->db->insert('patients', array(
			'user_id' => $userID,
			'uuid' => $uuid,
			'name' => $name,
			'phone' => $phone,
			'address' => $address,
			'city' => $city,
			'province' => $province,
			'birthday' => $birthday
		));
		$id = intval($this->db->insert_id());
		$patient = $this->db->get_where('patients', array('id' => $id))->row_array();
		$patient['response_code'] = 1;
		echo json_encode($patient);
	}

	public function get_sessions() {
		$userID = intval($this->input->post('user_id'));
		$deviceUUID = $this->input->post('device_uuid');
		$sessions = NULL;
		/*if ($deviceUUID == "") {
			$sessions = $this->db->query("SELECT * FROM `sessions` WHERE `user_id`=" . $userID . " ORDER BY `name`")->result_array();
		} else {
			$sessions = $this->db->query("SELECT * FROM `sessions` WHERE `user_id`=" . $userID . " AND `device_uuid`='" . $deviceUUID . "' ORDER BY `name`")->result_array();
		}*/
		$sessions = $this->db->query("SELECT * FROM `sessions` WHERE `user_id`=" . $userID . " ORDER BY `name`")->result_array();
		for ($i=0; $i<sizeof($sessions); $i++) {
			$session = $sessions[$i];
			$sessions[$i]['images'] = $this->db->query("SELECT * FROM `session_images` WHERE `session_uuid`='" . $session['uuid'] . "' LIMIT 5")->result_array();
		}
		echo json_encode($sessions);
	}
	
	public function get_devices() {
		echo json_encode($this->db->query("SELECT * FROM `devices` ORDER BY `device`")->result_array());
	}
	
	public function get_devices_by_user_id() {
		$userID = intval($this->input->post('user_id'));
		$this->db->where('user_id', $userID);
		echo json_encode($this->db->get('devices')->result_array());
	}
	
	public function get_device_by_uuid() {
		$uuid = $this->input->post('uuid');
		$this->db->where('uuid', $uuid);
		echo json_encode($this->db->get('devices')->row_array());
	}

	public function get_session() {
		$uuid = $this->input->post('uuid');
		$session = $this->db->get_where('sessions', array(
			'uuid' => $uuid
		))->row_array();
		$session['images'] = $this->db->get_where('session_images', array(
			'session_uuid' => $uuid
		))->result_array();
		$session['patient_name'] = $this->db->get_where('patients', array(
			'uuid' => $session['patient_uuid']
		))->row_array()['name'];
		echo json_encode($session);
	}
	
	private function get_boolean_value($jsonItem, $name) {
		if (isset($jsonItem[$name])) {
			$value = boolval($jsonItem[$name]);
			if ($value) {
				return 1;
			}
		}
		return 0;
	}
	
	private function get_real_string($array, $indexName) {
		if (isset($array[$indexName])) {
			return $array[$indexName];
		} else {
			return "";
		}
	}
	
	private function get_real_json_array($array, $indexName) {
		if (isset($array[$indexName])) {
			return $array[$indexName];
		} else {
			return json_encode(array());
		}
	}
	
	private function get_real_int($array, $indexName) {
		if (isset($array[$indexName])) {
			return intval($array[$indexName]);
		} else {
			return 0;
		}
	}
	
	public function sync_session_images() {
		$sessionImages = json_decode($this->input->post('session_images'), true);
		for ($i=0; $i<sizeof($sessionImages); $i++) {
			$sessionImage = $sessionImages[$i];
			$imageUUID = $sessionImage['uuid'];
			if ($imageUUID != null) {
				$newImagePath = $_FILES[$imageUUID]['name'];
				move_uploaded_file($_FILES[$imageUUID]['tmp_name'], "userdata/" . $newImagePath);
				if ($this->db->query("SELECT * FROM `session_images` WHERE `uuid`='" . $imageUUID . "'")->num_rows() > 0) {
					$this->db->where("uuid", $this->get_real_string($sessionImage, 'uuid'));
					$this->db->update("session_images", array(
						"user_id" => $this->get_real_int($sessionImage, 'user_id'),
						"uuid" => $this->get_real_string($sessionImage, 'uuid'),
						"device_uuid" => $this->get_real_string($sessionImage, 'device_uuid'),
						"session_uuid" => $this->get_real_string($sessionImage, 'session_uuid'),
						"type" => $this->get_real_int($sessionImage, 'type'),
						"name" => $this->get_real_string($sessionImage, 'name'),
						"path" => $newImagePath,
						"points" => json_encode($this->get_real_json_array($sessionImage, 'points')),
						"note" => $this->get_real_string($sessionImage, 'note'),
						"date" => $this->get_real_string($sessionImage, 'date'),
						"local" => $this->get_boolean_value($sessionImage, 'local')
					));
				} else {
					$this->db->insert("session_images", array(
						"user_id" => $this->get_real_int($sessionImage, 'user_id'),
						"uuid" => $this->get_real_string($sessionImage, 'uuid'),
						"device_uuid" => $this->get_real_string($sessionImage, 'device_uuid'),
						"session_uuid" => $this->get_real_string($sessionImage, 'session_uuid'),
						"type" => $this->get_real_int($sessionImage, 'type'),
						"name" => $this->get_real_string($sessionImage, 'name'),
						"path" => $newImagePath,
						"points" => json_encode($this->get_real_json_array($sessionImage, 'points')),
						"note" => $this->get_real_string($sessionImage, 'note'),
						"date" => $this->get_real_string($sessionImage, 'date'),
						"local" => $this->get_boolean_value($sessionImage, 'local')
					));
				}
			}
		}
		echo json_encode($sessionImages);
	}
	
	public function sync_buckets() {
		$buckets = json_decode($this->input->post('buckets'), true);
		for ($i=0; $i<sizeof($buckets); $i++) {
			$bucket = $buckets[$i];
			if ($this->db->query("SELECT * FROM `sessions` WHERE `uuid`='" . $bucket['uuid'] . "'")->num_rows() > 0) {
				$this->db->where("uuid", $bucket['uuid']);
				$this->db->update("buckets", array(
					"uuid" => $this->get_real_string($bucket, 'uuid'),
					"user_id" => $this->get_real_int($bucket, 'user_id'),
					"session_uuid" => $this->get_real_string($bucket, 'session_uuid'),
					"device_uuid" => $this->get_real_string($bucket, 'device_uuid')
				));
			} else {
				$this->db->insert("buckets", array(
					"uuid" => $this->get_real_string($bucket, 'uuid'),
					"user_id" => $this->get_real_int($bucket, 'user_id'),
					"session_uuid" => $this->get_real_string($bucket, 'session_uuid'),
					"device_uuid" => $this->get_real_string($bucket, 'device_uuid')
				));
			}
			$images = json_decode($this->get_real_json_array($bucket, 'images'), true);
			for ($j=0; $j<sizeof($images); $j++) {
				$image = $images[$j];
				$imageUUID = $this->get_real_string($image, 'uuid');
				if ($imageUUID != "") {
					$newImagePath = $_FILES[$imageUUID]['name'];
					move_uploaded_file($_FILES[$imageUUID]['tmp_name'], "userdata/" . $newImagePath);
					if ($this->db->query("SELECT * FROM `session_images` WHERE `uuid`='" . $imageUUID . "'")->num_rows() > 0) {
						$this->db->where("uuid", $this->get_real_string($image, 'uuid'));
						$this->db->update("session_images", array(
							"user_id" => $this->get_real_int($bucket, 'user_id'),
							"uuid" => $this->get_real_string($image, 'uuid'),
							"bucket_uuid" => $this->get_real_string($image, 'bucket_uuid'),
							"session_uuid" => $this->get_real_string($image, 'session_uuid'),
							"type" => $this->get_real_int($image, 'type'),
							"name" => $this->get_real_string($image, 'name'),
							"path" => $newImagePath,
							"points" => json_encode($this->get_real_json_array($image, 'points')),
							"note" => $this->get_real_string($image, 'note'),
							"date" => $this->get_real_string($image, 'date'),
							"local" => $this->get_boolean_value($image, 'local')
						));
					} else {
						$this->db->insert("session_images", array(
							"user_id" => $this->get_real_int($bucket, 'user_id'),
							"uuid" => $this->get_real_string($image, 'uuid'),
							"bucket_uuid" => $this->get_real_string($image, 'bucket_uuid'),
							"session_uuid" => $this->get_real_string($image, 'session_uuid'),
							"type" => $this->get_real_int($image, 'type'),
							"name" => $this->get_real_string($image, 'name'),
							"path" => $newImagePath,
							"points" => json_encode($this->get_real_json_array($image, 'points')),
							"note" => $this->get_real_string($image, 'note'),
							"date" => $this->get_real_string($image, 'date'),
							"local" => $this->get_boolean_value($image, 'local')
						));
					}
				}
			}
		}
	}
	
	public function sync_devices() {
		$devices = json_decode($this->input->post('devices'), true);
		for ($i=0; $i<sizeof($devices); $i++) {
			$device = $devices[$i];
			if ($this->db->query("SELECT * FROM `devices` WHERE `uuid`='" . $device['uuid'] . "'")->num_rows() > 0) {
				$this->db->where("uuid", $device['uuid']);
				$this->db->update("devices", array(
					"user_id" => $this->get_real_int($device, 'user_id'),
					"uuid" => $this->get_real_string($device, 'uuid'),
					"device" => $this->get_real_string($device, 'device'),
					"model" => $this->get_real_string($device, 'model'),
					"type" => $this->get_real_string($device, 'type')
				));
			} else {
				$this->db->insert("devices", array(
					"user_id" => $this->get_real_int($device, 'user_id'),
					"uuid" => $this->get_real_string($device, 'uuid'),
					"device" => $this->get_real_string($device, 'device'),
					"model" => $this->get_real_string($device, 'model'),
					"type" => $this->get_real_string($device, 'type')
				));
			}
		}
	}
	
	public function sync_patients() {
		$patients = json_decode($this->input->post('patients'), true);
		for ($i=0; $i<sizeof($patients); $i++) {
			$patient = $patients[$i];
			if ($this->db->query("SELECT * FROM `patients` WHERE `uuid`='" . $patient['uuid'] . "'")->num_rows() > 0) {
				$this->db->where("uuid", $patient['uuid']);
				$this->db->update("patients", array(
					"uuid" => $this->get_real_string($patient, 'uuid'),
					"user_id" => $this->get_real_int($patient, 'user_id'),
					"custom_id" => $this->get_real_string($patient, 'custom_id'),
					"name" => $this->get_real_string($patient, 'name'),
					"address" => $this->get_real_string($patient, 'address'),
					"city" => $this->get_real_string($patient, 'city'),
					"province" => $this->get_real_string($patient, 'province'),
					"birthday" => $this->get_real_string($patient, 'birthday'),
					"gender" => $this->get_real_string($patient, 'gender'),
					"email" => $this->get_real_string($patient, 'email'),
					"phone" => $this->get_real_string($patient, 'phone')
				));
			} else {
				$this->db->insert("patients", array(
					"uuid" => $this->get_real_string($patient, 'uuid'),
					"user_id" => $this->get_real_int($patient, 'user_id'),
					"custom_id" => $this->get_real_string($patient, 'custom_id'),
					"name" => $this->get_real_string($patient, 'name'),
					"address" => $this->get_real_string($patient, 'address'),
					"city" => $this->get_real_string($patient, 'city'),
					"province" => $this->get_real_string($patient, 'province'),
					"birthday" => $this->get_real_string($patient, 'birthday'),
					"gender" => $this->get_real_string($patient, 'gender'),
					"email" => $this->get_real_string($patient, 'email'),
					"phone" => $this->get_real_string($patient, 'phone')
				));
			}
		}
	}
	
	public function sync_sessions() {
		$sessions = json_decode($this->input->post('sessions'), true);
		for ($i=0; $i<sizeof($sessions); $i++) {
			$session = $sessions[$i];
			if ($this->db->query("SELECT * FROM `sessions` WHERE `uuid`='" . $session['uuid'] . "'")->num_rows() > 0) {
				$this->db->where("uuid", $session['uuid']);
				$this->db->update("sessions", array(
					"uuid" => $this->get_real_string($session, 'uuid'),
					"user_id" => $this->get_real_int($session, 'user_id'),
					"name" => $this->get_real_string($session, 'name'),
					"date" => $this->get_real_string($session, 'date'),
					"patient_uuid" => $this->get_real_string($session, 'patient_uuid'),
					"device_uuid" => $this->get_real_string($session, 'device_uuid')
				));
			} else {
				$this->db->insert("sessions", array(
					"uuid" => $this->get_real_string($session, 'uuid'),
					"user_id" => $this->get_real_int($session, 'user_id'),
					"name" => $this->get_real_string($session, 'name'),
					"date" => $this->get_real_string($session, 'date'),
					"patient_uuid" => $this->get_real_string($session, 'patient_uuid'),
					"device_uuid" => $this->get_real_string($session, 'device_uuid')
				));
			}
		}
	}
	
	public function delete_bucket() {
		$uuid = $this->input->post('uuid');
		$images = $this->db->query("SELECT * FROM `session_images` WHERE `bucket_uuid`='" . $uuid . "'")->result_array();
		for ($i=0; $i<sizeof($images); $i++) {
			$image = $images[$i];
			unlink("./userdata/" . $image['path']);
			$this->db->query("DELETE FROM `session_images` WHERE `id`=" . $image['id']);
		}
		$this->db->query("DELETE FROM `sessions` WHERE `uuid`='" . $uuid . "'");
	}

	public function sync_devices_with_uuid() {
		$devices = json_decode($this->input->post('devices'), true);
		for ($i=0; $i<sizeof($devices); $i++) {
			$device = $devices[$i];
			$this->db->where('uuid', $device['uuid']);
			$results = $this->db->get('devices');
			if (sizeof($results) <= 0) {
				$this->db->insert('devices', array(
					'user_id' => $device['user_id'],
					'uuid' => $device['uuid'],
					'device' => $device['device'],
					'model' => $device['model'],
					'type' => $device['type']
				));
			} else {
				$this->db->where('uuid', $device['uuid']);
				$this->db->update('devices', array(
					'user_id' => $device['user_id'],
					'device' => $device['device'],
					'model' => $device['model'],
					'type' => $device['type']
				));
			}
		}
	}
	
	public function get_buckets() {
		$userID = intval($this->input->post('user_id'));
		$sessionUUID = $this->input->post('session_uuid');
		$buckets = $this->db->query("SELECT * FROM `sessions` WHERE `user_id`=" . $userID . " AND `session_uuid`='" . $sessionUUID . "'")->result_array();
		for ($i=0; $i<sizeof($buckets); $i++) {
			$bucket = $buckets[$i];
			$images = $this->db->query("SELECT * FROM `session_images` WHERE `bucket_uuid`='" . $bucket['uuid'] . "'")->result_array();
			$buckets[$i]['images'] = $images;
		}
		echo json_encode($buckets);
	}
	
	public function get_images_by_session_uuid() {
		$sessionUUID = $this->input->post('session_uuid');
		$this->db->from('session_images');
		$this->db->where('session_uuid', $sessionUUID);
		$this->db->order_by('date', 'asc');
		$images = $this->db->get()->result_array();
		echo json_encode($images);
	}
	
	public function get_session_image_by_uuid() {
		$uuid = $this->input->post('uuid');
		$this->db->from('session_images');
		$this->db->where('uuid', $uuid);
		$image = $this->db->get()->row_array();
		echo json_encode($image);
	}
	
	public function get_session_images_by_user_id() {
		$userID = intval($this->input->post('user_id'));
		$this->db->from('session_images');
		$this->db->where('user_id', $userID);
		$this->db->order_by('date', 'desc');
		echo json_encode($this->db->get()->result_array());
	}
	
	public function get_bucket_by_uuid() {
		$uuid = $this->input->post('uuid');
		$bucket = $this->db->query("SELECT * FROM `sessions` WHERE `uuid`='" . $uuid . "'")->row_array();
		if ($bucket != null) {
			$bucket['images'] = $this->db->query("SELECT * FROM `session_images` WHERE `bucket_uuid`='" . $uuid . "'")->result_array();
			echo json_encode($bucket);
		}
	}
	
	public function get_latest_bucket() {
		$userID = intval($this->input->post('user_id'));
		$bucket = $this->db->query("SELECT * FROM `sessions` WHERE `user_id`=" . $userID . " ORDER BY `id` DESC LIMIT 1")->row_array();
		if ($bucket != null) {
			$bucket['images'] = $this->db->query("SELECT * FROM `session_images` WHERE `bucket_uuid`='" . $bucket['uuid'] . "'")->result_array();
			echo json_encode($bucket);
		}
	}
	
	public function add_session() {
		$userID = intval($this->input->post('user_id'));
		$uuid = $this->input->post('uuid');
		$name = $this->input->post('name');
		$date = $this->input->post('date');
		$deviceUUID = $this->input->post('device_uuid');
		$patientUUID = $this->input->post('patient_uuid');
		$this->db->insert('sessions', array(
			'user_id' => $userID,
			'uuid' => $uuid,
			'name' => $name,
			'date' => $date,
			'device_uuid' => $deviceUUID,
			'patient_uuid' => $patientUUID
		));
		$sessionID = intval($this->db->insert_id());
		$this->db->where('id', $sessionID);
		echo json_encode($this->db->get('sessions')->row_array());
	}
	
	public function add_bucket() {
		$uuid = $this->input->post('uuid');
		$image1UUID = $this->input->post('image_1_uuid');
		$image2UUID = $this->input->post('image_2_uuid');
		$deviceUUID = $this->input->post('device_uuid');
		$sessionUUID = $this->input->post('session_uuid');
		$userID = intval($this->input->post('user_id'));
		$photoNum = intval($this->input->post('photo_num'));
		$this->db->insert('buckets', array(
			'user_id' => $userID,
			'uuid' => $uuid,
			'session_uuid' => $sessionUUID,
			'device_uuid' => $deviceUUID
		));
		$bucketID = intval($this->db->insert_id());
		$this->db->insert('session_images', array(
			'uuid' => $image1UUID,
			'user_id' => $userID,
			'bucket_uuid' => $uuid,
			'session_uuid' => $sessionUUID,
			'type' => 0,
			'photo_num' => $photoNum,
			'local' => 0
		));
		$this->db->insert('session_images', array(
			'uuid' => $image2UUID,
			'user_id' => $userID,
			'bucket_uuid' => $uuid,
			'session_uuid' => $sessionUUID,
			'type' => 1,
			'photo_num' => $photoNum+1,
			'local' => 0
		));
		echo $bucketID;
	}
	
	public function upload_to_db() {
		$userID = intval($this->input->post('user_id'));
		$uuid = $this->input->post('uuid');
		$deviceUUID = $this->input->post('device_uuid');
		$sessionUUID = $this->input->post('session_uuid');
		$name = $this->input->post('name');
		$note = $this->input->post('note');
		$path = $this->input->post('path');
		$points = $this->input->post('points');
		$type = intval($this->input->post('type'));
		$date = $this->input->post('date');
		$photoNum = intval($this->input->post('photo_num'));
		$type = intval($this->input->post('type'));
		$imageX = doubleval($this->input->post('image_x'));
		$imageY = doubleval($this->input->post('image_y'));
		$imageWidth = doubleval($this->input->post('image_width'));
		$imageHeight = doubleval($this->input->post('image_height'));
		$images = $this->db->query("SELECT * FROM `session_images` WHERE `uuid`='" . $uuid . "'")->result_array();
		$config = array(
	        'upload_path' => './userdata/',
	        'allowed_types' => "*",
	        'overwrite' => TRUE,
	        'max_size' => "2048000", 
	        'max_height' => "8192",
	        'max_width' => "8192"
        );
        $this->load->library('upload', $config);
		if ($this->upload->do_upload('file')) {
        	if (sizeof($images) > 0) {
        		$this->db->where('uuid', $uuid);
	        	$this->db->update('session_images', array(
	        		'user_id' => $userID,
	        		'device_uuid' => $deviceUUID,
	        		'session_uuid' => $sessionUUID,
	        		'name' => $name,
	        		'note' => $note,
	        		'image_x' => $imageX,
	        		'image_y' => $imageY,
	        		'image_width' => $imageWidth,
	        		'image_height' => $imageHeight,
	        		'points' => $points,
	        		'type' => $type,
	        		'date' => $date,
	        		'path' => $this->upload->data('file_name'),
	        		'gd_path' => "",
	        		'db_path' => $path,
	        		'type' => $type,
	        		'photo_num' => $photoNum,
	        		'storage_method' => 'db'
	        	));
        		$this->db->where('uuid', $uuid);
        		echo json_encode($this->db->get('session_images')->row_array());
        	} else {
	        	$this->db->insert('session_images', array(
	        		'user_id' => $userID,
	        		'uuid' => $uuid,
	        		'device_uuid' => $deviceUUID,
	        		'session_uuid' => $sessionUUID,
	        		'name' => $name,
	        		'note' => $note,
	        		'path' => $this->upload->data('file_name'),
	        		'gd_path' => "",
	        		'db_path' => $path,
	        		'image_x' => $imageX,
	        		'image_y' => $imageY,
	        		'image_width' => $imageWidth,
	        		'image_height' => $imageHeight,
	        		'points' => $points,
	        		'type' => $type,
	        		'date' => $date,
	        		'type' => $type,
	        		'photo_num' => $photoNum,
	        		'storage_method' => 'db'
	        	));
        		$this->db->where('uuid', $uuid);
        		echo json_encode($this->db->get('session_images')->row_array());
        	}
        	$id = intval($this->db->insert_id());
        	echo json_encode(array(
        		'id' => $id,
        		'path' => $this->upload->data()['file_name']
        	));
        }
	}
	
	public function get_google_drive_image() {
		$gdFileID = $this->input->post('gd_file_id');
		$this->db->where('gd_file_id', $gdFileID);
		echo json_encode($this->db->get('session_images')->row_array());
	}
	
	public function upload_to_gd() {
		$userID = intval($this->input->post('user_id'));
		$uuid = $this->input->post('uuid');
		$deviceUUID = $this->input->post('device_uuid');
		$sessionUUID = $this->input->post('session_uuid');
		$name = $this->input->post('name');
		$note = $this->input->post('note');
		$path = $this->input->post('path');
		$points = $this->input->post('points');
		$type = intval($this->input->post('type'));
		$date = $this->input->post('date');
		$type = intval($this->input->post('type'));
		$gdFileID = $this->input->post('gd_file_id');
		$imageX = doubleval($this->input->post('image_x'));
		$imageY = doubleval($this->input->post('image_y'));
		$imageWidth = doubleval($this->input->post('image_width'));
		$imageHeight = doubleval($this->input->post('image_height'));
		$photoNum = intval($this->input->post('photo_num'));
		$images = $this->db->query("SELECT * FROM `session_images` WHERE `uuid`='" . $uuid . "'")->result_array();
		$config = array(
	        'upload_path' => './userdata/',
	        'allowed_types' => "*",
	        'overwrite' => TRUE,
	        'max_size' => "2048000", 
	        'max_height' => "8192",
	        'max_width' => "8192"
        );
        $this->load->library('upload', $config);
		if ($this->upload->do_upload('file')) {
        	if (sizeof($images) > 0) {
        		$this->db->where('uuid', $uuid);
	        	$this->db->update('session_images', array(
	        		'user_id' => $userID,
	        		'device_uuid' => $deviceUUID,
	        		'session_uuid' => $sessionUUID,
	        		'name' => $name,
	        		'note' => $note,
	        		'path' => $this->upload->data('file_name'),
	        		'gd_path' => $path,
	        		'db_path' => "",
	        		'gd_file_id' => $gdFileID,
	        		'image_x' => $imageX,
	        		'image_y' => $imageY,
	        		'image_width' => $imageWidth,
	        		'image_height' => $imageHeight,
	        		'points' => $points,
	        		'type' => $type,
	        		'date' => $date,
	        		'type' => $type,
	        		'photo_num' => $photoNum,
	        		'storage_method' => 'gd'
	        	));
        		$this->db->where('uuid', $uuid);
        		echo json_encode($this->db->get('session_images')->row_array());
        	} else {
	        	$this->db->insert('session_images', array(
	        		'user_id' => $userID,
	        		'uuid' => $uuid,
	        		'device_uuid' => $deviceUUID,
	        		'session_uuid' => $sessionUUID,
	        		'gd_file_id' => $gdFileID,
	        		'name' => $name,
	        		'note' => $note,
	        		'path' => $this->upload->data('file_name'),
	        		'gd_path' => $path,
	        		'db_path' => "",
	        		'image_x' => $imageX,
	        		'image_y' => $imageY,
	        		'image_width' => $imageWidth,
	        		'image_height' => $imageHeight,
	        		'points' => $points,
	        		'type' => $type,
	        		'date' => $date,
	        		'type' => $type,
	        		'photo_num' => $photoNum,
	        		'storage_method' => 'gd'
	        	));
        		$this->db->where('uuid', $uuid);
        		echo json_encode($this->db->get('session_images')->row_array());
        	}
        	$id = intval($this->db->insert_id());
        	echo json_encode(array(
        		'id' => $id,
        		'path' => $this->upload->data()['file_name']
        	));
        }
	}
	
	public function delete_image_by_uuid() {
		$uuid = $this->input->post('uuid');
		$this->db->where('uuid', $uuid);
		$this->db->delete('session_images');
	}
	
	public function upload_skin_image() {
		$userID = intval($this->input->post('user_id'));
		$uuid = $this->input->post('uuid');
		$deviceUUID = $this->input->post('device_uuid');
		$sessionUUID = $this->input->post('session_uuid');
		$name = $this->input->post('name');
		$note = $this->input->post('note');
		$points = $this->input->post('points');
		$type = intval($this->input->post('type'));
		$date = $this->input->post('date');
		$type = intval($this->input->post('type'));
		$imageX = doubleval($this->input->post('image_x'));
		$imageY = doubleval($this->input->post('image_y'));
		$imageWidth = doubleval($this->input->post('image_width'));
		$imageHeight = doubleval($this->input->post('image_height'));
		$photoNum = intval($this->input->post('photo_num'));
		$images = $this->db->query("SELECT * FROM `session_images` WHERE `session_uuid`='" . $sessionUUID . "'")->result_array();
		$config = array(
	        'upload_path' => './userdata/',
	        'allowed_types' => "*",
	        'overwrite' => TRUE,
	        'max_size' => "2048000", 
	        'max_height' => "8192",
	        'max_width' => "8192"
        );
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {
        	$images = $this->db->query("SELECT * FROM `session_images` WHERE `uuid`='" . $uuid . "'")->result_array();
        	if (sizeof($images) > 0) {
        		$this->db->where('uuid', $uuid);
	        	$this->db->update('session_images', array(
	        		'user_id' => $userID,
	        		'device_uuid' => $deviceUUID,
	        		'session_uuid' => $sessionUUID,
	        		'path' => $this->upload->data()['file_name'],
	        		'name' => $name,
	        		'note' => $note,
	        		'image_x' => $imageX,
	        		'image_y' => $imageY,
	        		'image_width' => $imageWidth,
	        		'image_height' => $imageHeight,
	        		'points' => $points,
	        		'type' => $type,
	        		'date' => $date,
	        		'type' => $type,
	        		'photo_num' => $photoNum,
	        		'storage_method' => 'my_account'
	        	));
        		$this->db->where('uuid', $uuid);
        		echo json_encode($this->db->get('session_images')->row_array());
        	} else {
	        	$this->db->insert('session_images', array(
	        		'user_id' => $userID,
	        		'uuid' => $uuid,
	        		'device_uuid' => $deviceUUID,
	        		'session_uuid' => $sessionUUID,
	        		'path' => $this->upload->data()['file_name'],
	        		'name' => $name,
	        		'note' => $note,
	        		'image_x' => $imageX,
	        		'image_y' => $imageY,
	        		'image_width' => $imageWidth,
	        		'image_height' => $imageHeight,
	        		'points' => $points,
	        		'type' => $type,
	        		'date' => $date,
	        		'type' => $type,
	        		'photo_num' => $photoNum,
	        		'storage_method' => 'my_account'
	        	));
        		$this->db->where('uuid', $uuid);
        		echo json_encode($this->db->get('session_images')->row_array());
        	}
        	$id = intval($this->db->insert_id());
        	echo json_encode(array(
        		'id' => $id,
        		'path' => $this->upload->data()['file_name']
        	));
        } else {
        	echo json_encode($this->upload->display_errors());
        }
	}
	
	public function update_image_points_and_note() {
		$uuid = $this->input->post('uuid');
		$userID = intval($this->input->post('user_id'));
		$sessionImageUUID = $this->input->post('session_image_uuid');
		$note = $this->input->post('note');
		$sessionUUID = $this->input->post('session_uuid');
		$patientUUID = $this->input->post('patient_uuid');
		$leftPoints = $this->input->post('left_points');
		$frontPoints = $this->input->post('front_points');
		$rightPoints = $this->input->post('right_points');
		$backPoints = $this->input->post('back_points');
		$this->db->where('uuid', $sessionImageUUID);
		$this->db->update('session_images', array(
			'note' => $note
		));
		$this->db->where('session_uuid', $sessionUUID);
		$markings = $this->db->get('marks')->result_array();
		if (sizeof($markings) > 0) {
			$this->db->where('session_uuid', $sessionUUID);
			$this->db->update('marks', array(
				'uuid' => $uuid,
				'user_id' => $userID,
				'patient_uuid' => $patientUUID,
				'left_points' => $leftPoints,
				'front_points' => $frontPoints,
				'right_points' => $rightPoints,
				'back_points' => $backPoints
			));
		} else {
			$this->db->insert('marks', array(
				'uuid' => $uuid,
				'session_uuid' => $sessionUUID,
				'user_id' => $userID,
				'patient_uuid' => $patientUUID,
				'left_points' => $leftPoints,
				'front_points' => $frontPoints,
				'right_points' => $rightPoints,
				'back_points' => $backPoints
			));
		}
	}
	
	public function get_user_by_id() {
		$userID = intval($this->input->post('user_id'));
		$this->db->where('id', $userID);
		echo json_encode($this->db->get('users')->row_array());
	}
	
	public function update_user() {
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$this->db->where('email', $email);
		$this->db->update('users', array(
			'password' => $password
		));
	}
	
	public function update_user_details() {
		$id = intval($this->input->post('id'));
		$uuid = $this->input->post('uuid');
		$firstName = $this->input->post('first_name');
		$lastName = $this->input->post('last_name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$address = $this->input->post('address');
		$city = $this->input->post('city');
		$province = $this->input->post('province');
		$companyName = $this->input->post('company_name');
		$companyCity = $this->input->post('company_city');
		$companyCountry = $this->input->post('company_country');
		$companyStreet = $this->input->post('company_street');
		$companyZIPCode = $this->input->post('company_zip_code');
		$companyState = $this->input->post('company_state');
		$companyPhone = $this->input->post('company_phone');
		$this->db->where('id', $userID);
		$this->db->update('users', array(
			'uuid' => $uuid,
			'first_name' => $firstName,
			'last_name' => $lastName,
			'email' => $email,
			'phone' => $phone,
			'address' => $address,
			'city' => $city,
			'province' => $province,
			'company_name' => $companyName,
			'company_city' => $companyCity,
			'company_country' => $companyCountry,
			'company_street' => $companyStreet,
			'company_zip_code' => $companyZIPCode,
			'company_state' => $companyState,
			'company_phone' => $companyPhone
		));
	}
	
	public function update_fcm_token() {
		$userID = intval($this->input->post('user_id'));
		$fcmToken = $this->input->post('fcm_token');
		$this->db->where('id', $userID);
		$this->db->update('users', array(
			'fcm_token' => $fcmToken
		));
	}
	
	public function update_session() {
		$uuid = $this->input->post('uuid');
		$name = $this->input->post('name');
		$date = $this->input->post('date');
		$selectedPatientUUID = $this->input->post('patient_uuid');
		$this->db->where('uuid', $uuid);
		$this->db->update('sessions', array(
			'name' => $name,
			'date' => $date,
			'patient_uuid' => $selectedPatientUUID
		));
	}
	
	public function delete_session() {
		$uuid = $this->input->post('uuid');
		$this->db->where('uuid', $uuid);
		$this->db->delete('sessions');
	}
	
	public function delete_session_image() {
		$uuid = $this->input->post('uuid');
		$this->db->where('uuid', $uuid);
		$this->db->delete('session_images');
	}
	
	public function check_availability() {
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$this->db->where('email', $email);
		$users = $this->db->get('users')->result_array();
		if (sizeof($users) > 0) {
			echo json_encode(array(
				'response_code' => -1
			));
			return;
		}
		$this->db->where('username', $username);
		$users = $this->db->get('users')->result_array();
		if (sizeof($users) > 0) {
			echo json_encode(array(
				'response_code' => -2
			));
			return;
		}
		$this->db->where('phone', $phone);
		$users = $this->db->get('users')->result_array();
		if (sizeof($users) > 0) {
			echo json_encode(array(
				'response_code' => -3
			));
			return;
		}
		echo json_encode(array(
			'response_code' => 1
		));
	}

	public function send_password_reset_email() {
		$email = $this->input->post('email');
		$code = $this->input->post('code');
		$config = Array(
		    'protocol' => 'smtp',
		    'smtp_host' => 'ssl://smtp.googlemail.com',
		    'smtp_port' => 465,
		    'smtp_user' => 'skinmed.herca@gmail.com',
		    'smtp_pass' => 'rawatkulit123',
		    'mailtype'  => 'html', 
    		'charset'   => 'iso-8859-1'
		);
		$this->load->library('email', $config);
		$this->email->set_mailtype("html");
		$this->email->from('skinmed.herca@gmail.com', 'Skin Analyzer');
		$this->email->to($email);
		$this->email->subject('Atur Ulang Kata Sandi');
		$message = $this->load->view("email_template.php", "", true);
		$message = str_replace("[CODE]", $code, $message);
		$this->email->message($message);
		$this->email->send();
	}

	public function login() {
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		if (strpos($email, '@') !== false) {
			$this->db->where('email', $email)->where('password', $password);
			$users = $this->db->get('users')->result_array();
			if (sizeof($users) > 0) {
				$user = $users[0];
				$user['response_code'] = 1;
				echo json_encode($user);
			} else {
				echo json_encode(array('response_code' => -1));
			}
		} else {
			$username = $email;
			$this->db->where('username', $username)->where('password', $password);
			$users = $this->db->get('users')->result_array();
			if (sizeof($users) > 0) {
				$user = $users[0];
				$user['response_code'] = 1;
				echo json_encode($user);
			} else {
				echo json_encode(array('response_code' => -2));
			}
		}
	}
	
	public function get_markings_by_session_uuid() {
		$sessionUUID = $this->input->post('session_uuid');
		$this->db->where('session_uuid', $sessionUUID);
		echo json_encode($this->db->get('marks')->result_array());
	}

	public function signup() {
		$firstName = $this->input->post('first_name');
		$lastName = $this->input->post('last_name');
		$address = $this->input->post('address');
		$phone = $this->input->post('phone');
		$email = $this->input->post('email');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$isAdmin = intval($this->input->post('is_admin'));
		$this->db->where('phone', $phone);
		$users = $this->db->get('users')->result_array();
		if (sizeof($users) > 0) {
			echo json_encode(array('response_code' => -1));
			return;
		}
		$users = $this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "'")->result_array();
		if (sizeof($users) > 0) {
			echo json_encode(array('response_code' => -2));
			return;
		}
		$this->db->insert('users', array(
			'first_name' => $firstName,
			'last_name' => $lastName,
			'address' => $address,
			'phone' => $phone,
			'email' => $email,
			'username' => $username,
			'password' => $password,
			'is_admin' => $isAdmin
		));
		echo json_encode(array('response_code' => 1, 'user_id' => intval($this->db->insert_id())));
	}

	public function upload_image() {
		$userID = intval($this->input->post('user_id'));
		$deviceID = intval($this->input->post('device_id'));
		$config = array(
	        'upload_path' => './userdata/',
	        'allowed_types' => "*",
	        'overwrite' => TRUE,
	        'max_size' => "10485760", 
	        'max_height' => "8192",
	        'max_width' => "8192"
        );
        $this->load->library('upload', $config);
        if($this->upload->do_upload('file')) {
        	$path = $this->upload->data()['file_name'];
        	$this->db->insert('images', array(
        		'user_id' => $userID,
        		'device_id' => $deviceID,
        		'path' => $path,
        		'storage_method' => 'my_account'
        	));
        	echo json_encode(array('id' => intval($this->db->insert_id()), 'path' => $path));
        } else {
        	echo json_encode(array('error' => $this->upload->display_errors()));
        }
	}
	
	public function add_image() {
		$userID = intval($this->input->post('user_id'));
		$deviceID = intval($this->input->post('device_id'));
		$path = $this->input->post('path');
		$storageMethod = $this->input->post('storage_method');
		$this->db->insert('images', array(
        	'user_id' => $userID,
        	'device_id' => $deviceID,
        	'path' => $path,
        	'storage_method' => $storageMethod
        ));
        echo json_encode(array('id' => intval($this->db->insert_id()), 'path' => $path));
	}
}
