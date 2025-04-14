<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    protected $table = 'users';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Lấy tất cả user
    public function get_all() {
        return $this->db->get($this->table)->result();
    }

    // Lấy user theo ID
    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function get_by_email($email) {
        return $this->db->get_where($this->table, ['email' => $email])->row();
    }

    // Thêm user mới
    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    // Cập nhật user
    public function update($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    // Xóa user
    public function delete($id) {
        return $this->db->delete($this->table, ['id' => $id]);
    }
}
