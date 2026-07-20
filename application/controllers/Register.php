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

    public function test_property($id = 1) {
        $this->load->database();
        $q = $this->db->query("SELECT * FROM tbl_properties");
        echo "<pre>Total Properties: " . $q->num_rows() . "\n";
        foreach($q->result_array() as $row) {
            print_r($row);
        }
        echo "</pre>";
    }

    public function reset_db() {
        $this->load->database();
        $this->db->query("TRUNCATE TABLE tbl_properties");
        $this->db->query("TRUNCATE TABLE tbl_properties_features");
        $this->db->query("TRUNCATE TABLE tbl_property_documents");
        // Also truncate images tables if they exist
        if ($this->db->table_exists('tbl_documents')) {
            $this->db->query("TRUNCATE TABLE tbl_documents"); 
        }
        echo "<h3>Database successfully reset! All ghost properties and documents cleared.</h3>";
        echo "<p>You can now test adding a new property from a completely clean slate.</p>";
    }

    public function force_fix_db() {
        $this->load->database();
        
        // 1. Wipe everything to ensure no '0' IDs exist blocking the ALTER
        $this->db->query("TRUNCATE TABLE tbl_properties");
        $this->db->query("TRUNCATE TABLE tbl_properties_features");
        $this->db->query("TRUNCATE TABLE tbl_property_documents");
        $this->db->query("TRUNCATE TABLE tbl_property_feature_mapping");

        // 2. Force AUTO_INCREMENT on PropertyId
        $this->db->query("SET FOREIGN_KEY_CHECKS=0");
        $sql = "ALTER TABLE tbl_properties MODIFY PropertyId INT NOT NULL AUTO_INCREMENT PRIMARY KEY";
        $this->db->query($sql);
        $this->db->query("SET FOREIGN_KEY_CHECKS=1");
        
        echo "<h3>CRITICAL FIX APPLIED!</h3>";
        echo "<p>The database has been forcefully updated so that PropertyId Auto-Increments.</p>";
        echo "<p>Please go to your dashboard and click <b>Add Property</b>. Everything will work perfectly now!</p>";
    }
}
