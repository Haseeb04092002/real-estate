<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_Property_Docs extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Admin_Property_Docs_Model');
    }

    private function check_auth() {
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('Admin/login');
        }
    }

    public function index() {
        redirect('Admin_Property_Docs/analytics');
    }

    public function analytics() {
        $this->check_auth();
        $data['page_title'] = 'Property Documents Analytics';
        $data['active_tab'] = 'analytics';
        $data['analytics'] = $this->Admin_Property_Docs_Model->get_analytics();
        $this->load->view('admin/property_docs/analytics', $data);
    }

    public function types() {
        $this->check_auth();
        $data['page_title'] = 'Document Types Management';
        $data['active_tab'] = 'types';
        $data['types'] = $this->Admin_Property_Docs_Model->get_document_types();
        $this->load->view('admin/property_docs/types', $data);
    }

    public function queue() {
        $this->check_auth();
        $data['page_title'] = 'Document Review Queue';
        $data['active_tab'] = 'queue';
        $data['queue'] = $this->Admin_Property_Docs_Model->get_review_queue();
        $this->load->view('admin/property_docs/queue', $data);
    }

    // --- API ENDPOINTS ---
    public function api_save_type() {
        $this->check_auth();
        $id = $this->input->post('DocTypeId');
        $data = [
            'DocumentTitle' => $this->input->post('DocumentTitle'),
            'PropertyType' => $this->input->post('PropertyType'),
            'IsMandatory' => $this->input->post('IsMandatory') ? 1 : 0,
            'RequiresExpiryTracking' => $this->input->post('RequiresExpiryTracking') ? 1 : 0
        ];
        
        $this->Admin_Property_Docs_Model->save_document_type($data, $id);
        redirect('Admin_Property_Docs/types');
    }

    public function api_delete_type($id) {
        $this->check_auth();
        if ($id) {
            $this->Admin_Property_Docs_Model->delete_document_type($id);
        }
        redirect('Admin_Property_Docs/types');
    }

    public function api_update_status() {
        $this->check_auth();
        $id = $this->input->post('DocumentId');
        $status = $this->input->post('VerificationStatus');
        $notes = $this->input->post('AdminNotes');
        
        if ($id && $status) {
            $this->Admin_Property_Docs_Model->update_document_status($id, $status, $notes);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid inputs']);
        }
    }
}
