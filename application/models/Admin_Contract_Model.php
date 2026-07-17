<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Contract_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // --- CONTRACT TYPES ---
    public function get_contract_types() {
        $this->db->select('c.*, p.Title as PropertyTypeTitle');
        $this->db->from('tbl_properties_contracts_type c');
        $this->db->join('tbl_properties_types p', 'c.PropertyTypeId = p.TypeId', 'left');
        $this->db->where('c.IsDeleted', 0);
        $this->db->order_by('c.TypeId', 'DESC');
        return $this->db->get()->result();
    }

    public function save_contract_type($data, $id = null) {
        if ($id) {
            $this->db->where('TypeId', $id)->update('tbl_properties_contracts_type', $data);
            return $id;
        } else {
            $this->db->insert('tbl_properties_contracts_type', $data);
            return $this->db->insert_id();
        }
    }

    // --- CONTRACT TEMPLATES ---
    public function get_contract_templates() {
        $this->db->select('t.*, c.Title as TypeTitle');
        $this->db->from('tbl_contract_templates t');
        $this->db->join('tbl_properties_contracts_type c', 't.ContractTypeId = c.TypeId', 'left');
        $this->db->where('t.Status !=', 'Archived');
        $this->db->where('t.IsDeleted', 0);
        $this->db->order_by('t.TemplateId', 'DESC');
        return $this->db->get()->result();
    }

    public function get_template($id) {
        return $this->db->where('TemplateId', $id)->get('tbl_contract_templates')->row();
    }

    public function save_contract_template($data, $id = null) {
        if ($id) {
            $this->db->where('TemplateId', $id)->update('tbl_contract_templates', $data);
            return $id;
        } else {
            $this->db->insert('tbl_contract_templates', $data);
            return $this->db->insert_id();
        }
    }

    // --- LEGAL CLAUSES ---
    public function get_legal_clauses() {
        $this->db->where('IsDeleted', 0);
        $this->db->order_by('ClauseId', 'DESC');
        return $this->db->get('tbl_contract_clauses')->result();
    }

    public function get_clause($id) {
        return $this->db->where('ClauseId', $id)->get('tbl_contract_clauses')->row();
    }

    public function save_legal_clause($data, $id = null) {
        if ($id) {
            $this->db->where('ClauseId', $id)->update('tbl_contract_clauses', $data);
            return $id;
        } else {
            $this->db->insert('tbl_contract_clauses', $data);
            return $this->db->insert_id();
        }
    }

    // --- GENERATED CONTRACTS ---
    public function get_generated_contracts() {
        $this->db->select('c.*, t.Title as TypeTitle, b.ClientName as BuyerName, s.ClientName as SellerName, p.PropertyTitle');
        $this->db->from('tbl_properties_contracts c');
        $this->db->join('tbl_properties_contracts_type t', 'c.ContractTypeId = t.TypeId', 'left');
        $this->db->join('tbl_clients b', 'c.BuyerId = b.ClientId', 'left');
        $this->db->join('tbl_clients s', 'c.SellerId = s.ClientId', 'left');
        $this->db->join('tbl_properties p', 'c.PropertyId = p.PropertyId', 'left');
        $this->db->order_by('c.ContractId', 'DESC');
        return $this->db->get()->result();
    }

    public function get_contract($id) {
        $this->db->select('c.*, t.Title as TypeTitle, b.ClientName as BuyerName, s.ClientName as SellerName, p.PropertyTitle');
        $this->db->from('tbl_properties_contracts c');
        $this->db->join('tbl_properties_contracts_type t', 'c.ContractTypeId = t.TypeId', 'left');
        $this->db->join('tbl_clients b', 'c.BuyerId = b.ClientId', 'left');
        $this->db->join('tbl_clients s', 'c.SellerId = s.ClientId', 'left');
        $this->db->join('tbl_properties p', 'c.PropertyId = p.PropertyId', 'left');
        $this->db->where('c.ContractId', $id);
        return $this->db->get()->row();
    }

    public function update_contract_status($id, $status) {
        $this->db->where('ContractId', $id)->update('tbl_properties_contracts', ['ContractStatus' => $status, 'UpdatedOn' => date('Y-m-d H:i:s')]);
    }

    // --- ANALYTICS ---
    public function get_analytics() {
        $stats = [];
        $stats['total'] = $this->db->count_all_results('tbl_properties_contracts');
        $stats['this_month'] = $this->db->where('MONTH(AddedOn)', date('m'))->where('YEAR(AddedOn)', date('Y'))->count_all_results('tbl_properties_contracts');
        $stats['completed'] = $this->db->where('ContractStatus', 'Completed')->count_all_results('tbl_properties_contracts');
        $stats['pending'] = $this->db->where_in('ContractStatus', ['Pending', 'Draft'])->count_all_results('tbl_properties_contracts');
        $stats['cancelled'] = $this->db->where_in('ContractStatus', ['Cancelled', 'Terminated', 'Expired', 'Rejected'])->count_all_results('tbl_properties_contracts');
        
        $this->db->select_sum('TotalAmount');
        $this->db->where('ContractStatus', 'Completed');
        $query = $this->db->get('tbl_properties_contracts')->row();
        $stats['value'] = $query->TotalAmount ? $query->TotalAmount : 0;

        // Charts data
        $this->db->select('t.Title as TypeTitle, COUNT(c.ContractId) as Count');
        $this->db->from('tbl_properties_contracts c');
        $this->db->join('tbl_properties_contracts_type t', 'c.ContractTypeId = t.TypeId', 'left');
        $this->db->group_by('c.ContractTypeId');
        $stats['chart_types'] = $this->db->get()->result();

        return $stats;
    }
    // --- CONTRACT VARIABLES ---
    public function get_contract_variables() {
        $this->db->order_by('VarId', 'ASC');
        return $this->db->get('tbl_contract_variables')->result();
    }

    public function save_contract_variable($data) {
        $this->db->insert('tbl_contract_variables', $data);
        return $this->db->insert_id();
    }
}
