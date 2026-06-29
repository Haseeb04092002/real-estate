<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_User_Verifications_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_rules() {
        $this->db->order_by('RuleId', 'DESC');
        return $this->db->get('tbl_user_verification_rules')->result();
    }

    public function save_rule($data, $id = null) {
        if ($id) {
            $data['UpdatedOn'] = date('Y-m-d H:i:s');
            $this->db->where('RuleId', $id)->update('tbl_user_verification_rules', $data);
            return $id;
        } else {
            $data['AddedOn'] = date('Y-m-d H:i:s');
            $this->db->insert('tbl_user_verification_rules', $data);
            return $this->db->insert_id();
        }
    }

    public function delete_rule($id) {
        $this->db->where('RuleId', $id)->delete('tbl_user_verification_rules');
    }
}
