<?php

class Login_model extends CI_Model {

 
	public $tableName;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->library('encryption');
    }

    function user_login_old()
    {
        $post_user_name 	= $this->input->post('UserEmail');   
        $post_user_pass  	= $this->input->post('Password');

        $this->db->where('EmailAddress', $post_user_name);
        $query = $this->db->get('tbl_clients');

        if ($query->num_rows() > 0) {
            $user = $query->row();
            if ($user->Password === $post_user_pass) {
                return true; 
            }
            else
            {
            	return false;
            }
        }
    }

    function user_login()
    {
	 	$encKey = $this->config->item('encryption_key');
        $post_user_name 	= $this->input->post('txtUserEmail');   
        $post_user_pass  	= $this->input->post('txtUserPassword');

    	$UserData = ($post_user_name)?$this->getlist_model->getFieldsMultipleConditions('tbl_clients','*'," WHERE EmailAddress = '$post_user_name'",2):'';

		if($UserData)
		{
			$user_id  			= isset($UserData->ClientId) ? $UserData->ClientId : (isset($UserData->id) ? $UserData->id : '');
			$user_name			= isset($UserData->ClientName) ? $UserData->ClientName : '';
		    $user_email     	= isset($UserData->EmailAddress) ? $UserData->EmailAddress : '';
		    $user_password     	= isset($UserData->Password) ? $UserData->Password : '';
			$client_id			= $user_id;
			$client_name		= $user_name;
			$user_company		= isset($UserData->CompanyId) ? $UserData->CompanyId : '';
			$user_station		= isset($UserData->StationId) ? $UserData->StationId : '';
			$user_thumb     	= '';
			$parent_station 	= isset($UserData->StationParentId) ? $UserData->StationParentId : '';
			$logo				= '';
		}

		if($UserData)
		{
			$AuthLDAP = false;//$this->auth_ldap_login($post_user_name, $post_user_pass);
			$saved_user_pass = ($AuthLDAP == true)?$post_user_pass:$this->encryption->decrypt($UserData->Password);
			if($post_user_pass==$saved_user_pass)
			{
				$newdata = array(
			   'user_id'  			=> $user_id,
			   'user_email'     	=> $user_email,
			   'user_password'     	=> $user_password,
			   'user_name'     		=> $user_name,
			   'user_thumb'     	=> $user_thumb,
			   'client_id'  		=> $client_id,
			   'client_name'  		=> $client_name,
			   'parent_station'    	=> $parent_station,
			   'active_station'    	=> $user_station,
			   'user_station'     	=> $user_station,
			   'user_company'     	=> $user_company,
			   'is_active'     		=> time(),
			   'logo' 				=> $logo,
			   'login_time'			=> date("d-M-Y H:i:s"),
			   'logged_in' 			=> true
				   );
	
				$this->session->set_userdata($newdata);
				$uservalid  =   true;
			}
			else
			{
				$uservalid  =   false;
			}
		}
		else
		{
				$uservalid  =   false;
		}   

    	return $uservalid;
    }

    function register_user($PostData='')
	{
		$PostData 		= $this->input->post();

	 	$encKey = $this->config->item('encryption_key');
		$ClientName		= $PostData['FullName'];
		$EmailAddress 	= $PostData['UserEmail'];
		$Password 		= $PostData['UserPass1'];
		$Password2 		= $PostData['UserPass2'];
		$PhoneNumber	= $PostData['UserPhone'];
		// $UserId = false;
		if($ClientName && $EmailAddress && $PhoneNumber && $Password)
		{
			$data['ClientName'] = $ClientName;
			$data['EmailAddress'] = $EmailAddress;
			$data['Password'] = $this->encryption->encrypt($Password);
			$data['StationId'] = '1';
			$data['PhoneNumber'] = $PhoneNumber;
			$this->db->insert('tbl_clients',$data);

			if($this->db->affected_rows() > 0)
			{
				$UserId = $this->db->insert_id();
				// $UserId = true;
				return $UserId;
			} else {
                return $this->db->error()['message'];
            }

		}
        return 'Validation failed';
	}
	
	
	function get_client_ip() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    } 
	
	
	
	
	
	

}
 ?>