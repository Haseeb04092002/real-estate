<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	
	function __construct()
	{
		parent::__construct();
        $this->load->model('Login_model');
        $this->load->library('form_validation');
        $this->load->library('encryption');
		$this->load->helper('form');
	}


	public function RegisterUser()
	{
		$PostData = $this->input->post();
		$UserId = $this->Login_model->register_user($PostData);
		//$this->load->view('dashboard');
		if(is_numeric($UserId) && $UserId > 0 )
		{
			redirect('Properties/signin');
		}
		else {
			echo 'error: ' . $UserId;
		}
	}


	public function Register()
	{
		$PostData = $this->input->post();
		$UserId = $this->Login_model->register_user($PostData);
		//$this->load->view('dashboard');
		if(is_numeric($UserId) && $UserId > 0 )
		{
			redirect('Properties/signin');
		}
		else {
			echo 'error: ' . $UserId;
		}
	}

	public function alter_db()
	{
		$sql1 = "ALTER TABLE tbl_clients MODIFY ClientId INT NOT NULL AUTO_INCREMENT PRIMARY KEY";
		$sql2 = "ALTER TABLE tbl_properties MODIFY PropertyId INT NOT NULL AUTO_INCREMENT PRIMARY KEY";
		
		if($this->db->query($sql1) && $this->db->query($sql2)) {
			echo "Success: ClientId and PropertyId are now Primary Keys and Auto Increment.";
		} else {
			echo "Error: " . $this->db->error()['message'];
		}
	}

    public function check_prop_zero() {
        $this->load->database();
        $q = $this->db->query("SELECT * FROM tbl_properties WHERE PropertyId = 0");
        if($q->num_rows() > 0) {
            echo "Property 0 exists! Title: " . $q->row()->PropertyTitle;
        } else {
            echo "Property 0 does NOT exist.";
        }
    }

}
