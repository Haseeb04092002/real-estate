<?php
class Admin_Blogs_Model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_all_blogs() {
        $this->db->order_by('CreatedAt', 'DESC');
        $query = $this->db->get('tbl_blogs');
        return $query->result();
    }

    public function get_blog_by_id($id) {
        $query = $this->db->get_where('tbl_blogs', array('BlogId' => $id));
        return $query->row();
    }

    public function insert_blog($data) {
        $this->db->insert('tbl_blogs', $data);
        return $this->db->insert_id();
    }

    public function update_blog($id, $data) {
        $this->db->where('BlogId', $id);
        return $this->db->update('tbl_blogs', $data);
    }

    public function update_status($id, $status) {
        $this->db->where('BlogId', $id);
        return $this->db->update('tbl_blogs', array('Status' => $status));
    }

    public function delete_blog($id) {
        // First get the image name to delete it from server
        $blog = $this->get_blog_by_id($id);
        if ($blog && $blog->ImageName) {
            $image_path = FCPATH . 'uploads/blogs/' . $blog->ImageName;
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
        $this->db->where('BlogId', $id);
        return $this->db->delete('tbl_blogs');
    }

}
?>
