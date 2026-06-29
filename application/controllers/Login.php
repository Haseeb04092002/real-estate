<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->model('login_model');
        $this->load->library('form_validation');
	}


	public function index_old()
	{

		$this->form_validation->set_rules('txtUserEmail', 'EmailAddress', 'trim|required|valid_email|min_length[5]|max_length[150]|xss_clean');
		
		$this->form_validation->set_rules('txtPassword', 'Password', 'trim|required|min_length[5]|max_length[50]');
		// $test = $this->login_model->user_login();	
		// echo $test;
		// die();
		if ($this->form_validation->run() !== FALSE) // 
		{				
			// echo "login controller";

			if($this->login_model->user_login() == true)
			{
				// if login password is correct then go to home page
				// echo "true";
				redirect('Properties');
			}	
			elseif($this->login_model->user_login() == false)
			{
				// $data['LoginFailed']=true;
				// $data['LoginRequired']=false;
				$this->load->view('login_form');

				// redirect('Login');

				// if login password is not correct then go to login form again
				// echo "false";
				// $this->load->view('Properties/signin');
			}
		}
		else
		{
			echo "form validation FALSE";
		}

		// $this->load->view('information');
	}

	public function index()
	{

		$login_result = $this->login_model->user_login(); 

		// var_dump($login_result);
		// die();

        if ($login_result)
        { 
           redirect('Properties');
        } 
        else
        { 
            redirect('Properties/signin');
        }
    }

    public function Logout()
    {
    	$this->session->unset_userdata('logged_in');
    	$this->session->unset_userdata('user_id');
		$this->session->sess_destroy();
	    redirect('Properties');
    }

}
