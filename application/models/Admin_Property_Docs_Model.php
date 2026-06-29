<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Property_Docs_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // --- DOCUMENT TYPES ---
    public function get_document_types() {
        $this->db->order_by('DocTypeId', 'DESC');
        return $this->db->get('tbl_property_document_types')->result();
    }

    public function save_document_type($data, $id = null) {
        if ($id) {
            $data['UpdatedOn'] = date('Y-m-d H:i:s');
            $this->db->where('DocTypeId', $id)->update('tbl_property_document_types', $data);
            return $id;
        } else {
            $data['AddedOn'] = date('Y-m-d H:i:s');
            $this->db->insert('tbl_property_document_types', $data);
            return $this->db->insert_id();
        }
    }

    public function delete_document_type($id) {
        $this->db->where('DocTypeId', $id)->delete('tbl_property_document_types');
    }

    // --- DOCUMENT QUEUE ---
    public function get_review_queue() {
        $this->db->select('d.*, t.DocumentTitle as TypeTitle, p.PropertyTitle, c.ClientName as SellerName');
        $this->db->from('tbl_property_documents d');
        $this->db->join('tbl_property_document_types t', 'd.DocTypeId = t.DocTypeId', 'left');
        $this->db->join('tbl_properties p', 'd.PropertyId = p.PropertyId', 'left');
        $this->db->join('tbl_clients c', 'd.SellerId = c.ClientId', 'left');
        $this->db->order_by('d.UploadedDate', 'DESC');
        return $this->db->get()->result();
    }

    public function update_document_status($id, $status, $notes) {
        $data = ['VerificationStatus' => $status];
        if ($notes !== null) {
            $data['AdminNotes'] = $notes;
        }
        $this->db->where('DocumentId', $id)->update('tbl_property_documents', $data);
    }

    // --- ANALYTICS ---
    public function get_analytics() {
        $stats = [];
        $stats['total'] = $this->db->count_all_results('tbl_property_documents');
        
        $stats['pending'] = $this->db->where('VerificationStatus', 'Pending')->count_all_results('tbl_property_documents');
        
        $stats['approved'] = $this->db->where('VerificationStatus', 'Approved')->count_all_results('tbl_property_documents');
        
        $stats['rejected'] = $this->db->where_in('VerificationStatus', ['Rejected', 'Re-upload'])->count_all_results('tbl_property_documents');
        
        // Expired count
        $this->db->where('ExpiryDate <', date('Y-m-d'));
        $this->db->where('ExpiryDate IS NOT NULL');
        $stats['expired'] = $this->db->count_all_results('tbl_property_documents');

        // Charts data
        $this->db->select('t.DocumentTitle, COUNT(d.DocumentId) as Count');
        $this->db->from('tbl_property_documents d');
        $this->db->join('tbl_property_document_types t', 'd.DocTypeId = t.DocTypeId', 'left');
        $this->db->group_by('d.DocTypeId');
        $stats['chart_types'] = $this->db->get()->result();

        // Monthly trends
        $this->db->select('MONTH(UploadedDate) as Month, YEAR(UploadedDate) as Year, COUNT(*) as Count');
        $this->db->from('tbl_property_documents');
        $this->db->where('UploadedDate >= DATE_SUB(NOW(), INTERVAL 6 MONTH)');
        $this->db->group_by('Year, Month');
        $this->db->order_by('Year ASC, Month ASC');
        $stats['trends'] = $this->db->get()->result();

        return $stats;
    }
}
