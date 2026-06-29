<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_User_Verifications extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Admin_User_Verifications_Model');
    }

    private function check_auth() {
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('Admin/login');
        }
    }

    public function index() {
        redirect('Admin_User_Verifications/rules');
    }

    public function rules() {
        $this->check_auth();
        $data['page_title'] = 'User Verification Rules';
        $data['rules'] = $this->Admin_User_Verifications_Model->get_rules();
        $this->load->view('admin/user_verifications/rules', $data);
    }

    // --- API ENDPOINTS ---
    public function api_save_rule() {
        $this->check_auth();
        $id = $this->input->post('RuleId');
        $data = [
            'DocumentTitle' => $this->input->post('DocumentTitle'),
            'IsMandatory' => $this->input->post('IsMandatory') ? 1 : 0
        ];
        
        $this->Admin_User_Verifications_Model->save_rule($data, $id);
        redirect('Admin_User_Verifications/rules');
    }

    public function api_delete_rule($id) {
        $this->check_auth();
        if ($id) {
            $this->Admin_User_Verifications_Model->delete_rule($id);
        }
        redirect('Admin_User_Verifications/rules');
    }
}
