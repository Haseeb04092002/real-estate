<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Ads_Model extends CI_Model {

    public function get_all_ads($status = null) {
        $this->db->select('*');
        $this->db->from('tbl_ads');
        if ($status) {
            $this->db->where('Status', $status);
        }
        $this->db->order_by('AdId', 'DESC');
        return $this->db->get()->result();
    }

    public function get_ads_stats() {
        return [
            'total_active' => $this->db->where('Status', 'Active')->count_all_results('tbl_ads'),
            'total_impressions' => $this->db->select_sum('Impressions')->get('tbl_ads')->row()->Impressions ?? 0,
            'total_clicks' => $this->db->select_sum('Clicks')->get('tbl_ads')->row()->Clicks ?? 0
        ];
    }

    public function create_ad($data) {
        return $this->db->insert('tbl_ads', $data);
    }

    public function update_ad($ad_id, $data) {
        $this->db->where('AdId', $ad_id);
        return $this->db->update('tbl_ads', $data);
    }

    public function update_ad_status($ad_id, $status) {
        $this->db->where('AdId', $ad_id);
        return $this->db->update('tbl_ads', ['Status' => $status, 'UpdatedOn' => date('Y-m-d H:i:s')]);
    }

    public function delete_ad($ad_id) {
        $this->db->where('AdId', $ad_id);
        return $this->db->delete('tbl_ads');
    }
}
