<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // load model, helper, etc.
        $this->load->model('api/User_model');
        $this->load->helper('jwt');
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

    // POST /api/auth/register
    public function register() {
        $data = json_decode(file_get_contents('php://input'), true);
        // validate, check existing, hash password...
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->User_model->insert($data);
        echo json_encode(['message'=>'Registered']);
    }

    // POST /api/auth/login
    public function login() {
        $creds = json_decode(file_get_contents('php://input'), true);
        $user = $this->User_model->get_by_email($creds['email']);
        if (!$user || !password_verify($creds['password'], $user->password)) {
            show_error('Invalid credentials', 401);
        }
        // issue JWT
        $token = jwt_encode([
            'id'       => $user->id,
            'username' => $user->username,  // Ensure the 'username' exists in the user data
            'email'    => $user->email
        ]);
        
        echo json_encode(['token'=>$token]);
    }
}
