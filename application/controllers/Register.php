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
		if($UserId > 0 )
		{
			redirect('Properties/signin');
		}
		elseif ($UserId <= 0) {
			echo 'error';
		}
	}


	public function Register()
	{
		$PostData = $this->input->post();
		$UserId = $this->Login_model->register_user($PostData);
		//$this->load->view('dashboard');
		if($UserId > 0 )
		{
			redirect('Properties/signin');
		}
		elseif ($UserId <= 0) {
			echo 'error';
		}
	}

}
