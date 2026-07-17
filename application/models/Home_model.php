<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model
{
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        // $this->load->model('Getlist_model');
    }
	
	function Insert($PostData)
	{
		$FirstName 		= $PostData['FirstName'];
		$LastName 		= $PostData['LastName'];
		$EmailAddress 	= $PostData['UserEmail'];
		$Password 		= $PostData['UserPass1'];
		$Password2 		= $PostData['UserPass2'];
		$PhoneNumber	= $PostData['UserPhone'];

		if($FirstName && $LastName && $EmailAddress && $PhoneNumber && $Password && $Password == $Password2)
		{
			$data['FirstName'] = $FirstName;
			$data['LastName'] = $LastName;
			$data['EmailAddress'] = $EmailAddress;
			$data['Password'] = $Password;
			$data['PhoneNumber'] = $PhoneNumber;
			$this->db->insert('tbl_employees',$data);

			if($this->db->affected_rows() > 0)
			{
				echo '<br>UserId = '.$UserId = $this->db->insert_id();
			}

		}

		echo '<br>';
		print_r($this->db->last_query());
	}

	function Get_Property_Details($PropertyId)
	{
		
        $this->db->select('*');
	    $this->db->from('tbl_properties'); 
	    $this->db->join('tbl_properties_features', 'tbl_properties_features.PropertyId = tbl_properties.PropertyId', 'inner');
	    $this->db->where('tbl_properties.PropertyId', $PropertyId);
	    $query = $this->db->get();

	    return $query->row_array();
	}

}



?>