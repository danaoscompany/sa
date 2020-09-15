<?php

class Test extends CI_Controller {
	
	public function email() {
		$config = Array(
		    'protocol' => 'smtp',
		    'smtp_host' => 'ssl://smtp.googlemail.com',
		    'smtp_port' => 465,
		    'smtp_user' => 'danaos.apps@gmail.com',
		    'smtp_pass' => 'PublicVoid123',
		    'mailtype'  => 'html', 
    		'charset'   => 'iso-8859-1'
		);
		$this->load->library('email', $config);
		$this->email->set_mailtype("html");
		$this->email->from('danaos.apps@gmail.com', 'danaos.apps@gmail.com');
		$this->email->to('danaoscompany@gmail.com');
		$this->email->subject('Test email from CI and Gmail');
		$message = $this->load->view("email_template.php", "", true);
		$message = str_replace("[CODE]", "123456", $message);
		$this->email->message($message);
		$this->email->send();
	}
	
	public function upload_test() {
		/*$config = array(
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
        	echo json_encode(array('id' => intval($this->db->insert_id()), 'path' => $path));
        } else {
        	echo json_encode(array('error' => $this->upload->display_errors()));
        }*/
        echo "OK";
	}
	
	public function post_test() {
		echo "This is text: " . $this->input->post('text');
	}
	
	public function test2() {
		$date = "2020-08-02T18:56:43.178Z";
		$date = str_replace("T", " ", $date);
		$date = str_replace("Z", " ", $date);
		$date = substr($date, 0, strpos($date, "."));
		echo "Date: " . $date . "\n";
	}

	public function clear() {
		$this->db->query("DELETE FROM `sessions`");
		$this->db->query("DELETE FROM `session_images`");
		$this->db->query("DELETE FROM `images`");
		$this->db->query("DELETE FROM `sessions`");
	}
	
	public function clear_sessions() {
		$this->db->query("DELETE FROM `sessions`");
	}
	
	public function clear_session_images() {
		$this->db->query("DELETE FROM `session_images`");
	}

	public function clear_buckets() {
		$this->db->query("DELETE FROM `sessions`");
		$this->db->query("DELETE FROM `session_images`");
		$this->db->query("DELETE FROM `images`");
		$this->db->query("DELETE FROM `devices`");
		$this->db->query("DELETE FROM `sessions`");
		$this->db->query("DELETE FROM `patients`");
	}
}
