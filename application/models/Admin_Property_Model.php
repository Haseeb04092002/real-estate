<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_Property_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_properties_with_ownership() {
        $this->db->select('
            p.PropertyId,
            p.PropertyTitle,
            p.TotalPrice as Price,
            p.ListType,
            p.PropertyStatus,
            p.AddedOn as CreatedDate,
            p.PropertyTypeId,
            p.CityId,
            p.MailingAddress,
            p.ClientId,
            c.ClientName as OwnerName,
            t.Title as PropertyType,
            city.CityName,
            (SELECT COUNT(*) FROM tbl_properties_analytics pa WHERE pa.PropertyId = p.PropertyId AND pa.UserAction = \'View\') as Views,
            (SELECT COUNT(*) FROM tbl_property_media d WHERE d.PropertyId = p.PropertyId) as DocsCompletion
        ');
        $this->db->from('tbl_properties p');
        $this->db->join('tbl_clients c', 'c.ClientId = p.ClientId', 'left');
        $this->db->join('tbl_properties_types t', 't.TypeId = p.PropertyTypeId', 'left');
        $this->db->join('tbl_cities city', 'city.CityId = p.CityId', 'left');
        
        $this->db->where('p.IsDeleted', 0);
        $this->db->order_by('p.AddedOn', 'DESC');
        
        $query = $this->db->get();
        return $query->result();
    }

    public function update_property_status($property_id, $status) {
        $this->db->where('PropertyId', $property_id);
        return $this->db->update('tbl_properties', ['PropertyStatus' => $status, 'UpdatedOn' => date('Y-m-d H:i:s')]);
    }

    public function delete_property($property_id) {
        $this->db->where('PropertyId', $property_id);
        return $this->db->update('tbl_properties', ['IsDeleted' => 1, 'UpdatedOn' => date('Y-m-d H:i:s')]);
    }

    public function get_property_details($property_id) {
        $this->db->select('
            p.*,
            c.ClientName as OwnerName,
            c.EmailAddress as OwnerEmail,
            c.PhoneNumber as OwnerPhone,
            t.Title as PropertyType,
            city.CityName,
            (SELECT COUNT(*) FROM tbl_properties_analytics pa WHERE pa.PropertyId = p.PropertyId AND pa.UserAction = \'View\') as Views,
            (SELECT COUNT(*) FROM tbl_property_media d WHERE d.PropertyId = p.PropertyId) as DocsCompletion
        ');
        $this->db->from('tbl_properties p');
        $this->db->join('tbl_clients c', 'c.ClientId = p.ClientId', 'left');
        $this->db->join('tbl_properties_types t', 't.TypeId = p.PropertyTypeId', 'left');
        $this->db->join('tbl_cities city', 'city.CityId = p.CityId', 'left');
        $this->db->where('p.PropertyId', $property_id);
        
        $query = $this->db->get();
        return $query->row();
    }

    public function update_property($property_id, $data) {
        $this->db->where('PropertyId', $property_id);
        return $this->db->update('tbl_properties', $data);
    }

    public function get_property_features($property_id) {
        $this->db->where('PropertyId', $property_id);
        $query = $this->db->get('tbl_properties_features');
        $features = $query->row();
        if (!$features) {
            $features = new stdClass();
        }
        return $features;
    }

    public function update_property_features($property_id, $data) {
        $this->db->where('PropertyId', $property_id);
        $exists = $this->db->get('tbl_properties_features')->num_rows();
        if ($exists > 0) {
            $this->db->where('PropertyId', $property_id);
            return $this->db->update('tbl_properties_features', $data);
        } else {
            $data['PropertyId'] = $property_id;
            return $this->db->insert('tbl_properties_features', $data);
        }
    }

    public function get_property_media($property_id) {
        $this->db->where('PropertyId', $property_id);
        return $this->db->get('tbl_property_media')->result();
    }

    public function get_all_property_types() {
        $this->db->select('TypeId, Title');
        $this->db->from('tbl_properties_types');
        $this->db->order_by('Title', 'ASC');
        return $this->db->get()->result();
    }

    public function get_all_cities() {
        $this->db->select('CityId, CityName');
        $this->db->from('tbl_cities');
        $this->db->order_by('CityName', 'ASC');
        return $this->db->get()->result();
    }
}
