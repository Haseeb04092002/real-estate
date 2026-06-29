<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_User_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_users() {
        $this->db->select('c.ClientId, c.ClientName, c.EmailAddress, c.PhoneNumber, c.UserType, c.AccountStatus, c.RegistrationDate, c.LastLogin, c.ProfilePicture, v.VerificationStatus');
        $this->db->from('tbl_clients c');
        $this->db->join('tbl_user_verifications v', 'c.ClientId = v.ClientId', 'left');
        $this->db->where('c.IsDeleted', 0);
        $this->db->order_by('c.ClientId', 'DESC');
        return $this->db->get()->result();
    }

    public function get_user_details($user_id) {
        // Basic user info
        $this->db->select('c.*, v.EmailVerified, v.PhoneVerified, v.CNICDocument, v.SelfieDocument, v.VerificationStatus');
        $this->db->from('tbl_clients c');
        $this->db->join('tbl_user_verifications v', 'c.ClientId = v.ClientId', 'left');
        $this->db->where('c.ClientId', $user_id);
        $user = $this->db->get()->row();

        if (!$user) return null;

        // Activity Stats
        // Mocking property count for now since tbl_properties might be different
        $stats = [
            'total_properties' => 0,
            'active_listings' => 0,
            'sold_rented' => 0,
            'featured' => 0,
            'total_views' => 0,
            'total_inquiries' => 0,
            'total_favorites' => 0
        ];
        
        // Inquiries
        $this->db->where('BuyerId', $user_id);
        $this->db->or_where('SellerId', $user_id);
        $inquiries = $this->db->get('tbl_inquiries')->result();
        
        // Activity logs
        $this->db->where('ClientId', $user_id);
        $this->db->order_by('CreatedAt', 'DESC');
        $logs = $this->db->get('tbl_user_activity_logs')->result();

        // Documents
        $this->db->where('Reference', 'Client');
        $this->db->where('ReferenceId', $user_id);
        $documents = $this->db->get('tbl_documents')->result();

        // Properties
        $this->db->where('AddedBy', $user_id);
        $this->db->where('IsDeleted', 0);
        $this->db->order_by('PropertyId', 'DESC');
        $properties = $this->db->get('tbl_properties')->result();

        // Verification Rules
        $rules = $this->db->order_by('RuleId', 'ASC')->get('tbl_user_verification_rules')->result();

        return [
            'user' => $user,
            'stats' => $stats,
            'inquiries' => $inquiries,
            'logs' => $logs,
            'documents' => $documents,
            'properties' => $properties,
            'verification_rules' => $rules
        ];
    }

    public function update_user_status($user_id, $status, $reason) {
        $this->db->where('ClientId', $user_id);
        $this->db->update('tbl_clients', ['AccountStatus' => $status]);

        // Log action
        $log_data = [
            'ClientId' => $user_id,
            'Action' => 'Status Changed to ' . $status,
            'Description' => 'Reason: ' . $reason
        ];
        $this->db->insert('tbl_user_activity_logs', $log_data);

        return true;
    }
}
