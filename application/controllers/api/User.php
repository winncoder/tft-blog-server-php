<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('api/User_model');
        $this->load->helper('url'); // giống như trong hình ảnh bạn gửi
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding, Authorization");
        header("Content-Type: application/json");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }
    }

    // GET: /api/user
    public function get_users() {
        $data = $this->User_model->get_all();
        echo json_encode($data);
    }

    // GET: /api/user/{id}
    public function get_user($id) {
        $user = $this->User_model->get_by_id($id);
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }

    // POST: /api/user
    public function add_user() {
        $input = json_decode(file_get_contents('php://input'), true);
        if ($input) {
            $input['password'] = password_hash($input['password'], PASSWORD_DEFAULT);
            $this->User_model->insert($input);
            echo json_encode(['status' => 'User created successfully']);
        } else {
            echo json_encode(['error' => 'Invalid input']);
        }
    }

    // PUT: /api/user/{id}
    public function update_user($id) {
        $input = json_decode(file_get_contents('php://input'), true);
        if ($input) {
            $this->User_model->update($id, $input);
            echo json_encode(['status' => 'User updated successfully']);
        } else {
            echo json_encode(['error' => 'Invalid input']);
        }
    }

    // DELETE: /api/user/{id}
    public function delete_user($id) {
        $this->User_model->delete($id);
        echo json_encode(['status' => 'User deleted successfully']);
    }
}
