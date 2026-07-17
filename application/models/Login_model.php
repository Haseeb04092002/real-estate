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

    	$UserData = ($post_user_name)?$this->getlist_model->getFieldsMultipleConditions('clients_view','ClientId, CompanyId, StationParentId, StationId, ClientName, Password, EmailAddress'," WHERE EmailAddress = '$post_user_name' AND IsDeleted = '0'",2):'';

		if($UserData)
		{
			$user_id  			= $UserData->ClientId;
			$user_name			= $UserData->ClientName;
		    $user_email     	= $UserData->EmailAddress;
		    $user_password     	= $UserData->Password;
			$client_id			= $UserData->ClientId;
			$client_name		= $UserData->ClientName;
			$user_company		= $UserData->CompanyId;
			$user_station		= $UserData->StationId;
			$user_thumb     	= '';
			$parent_station 	= $UserData->StationParentId;
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
		// $PostData 		= $this->input->post();

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
			}

		}
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