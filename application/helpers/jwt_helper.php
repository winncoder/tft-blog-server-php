<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if (!function_exists('jwt_encode')) {
    function jwt_encode($data) {
        $CI =& get_instance();
        $CI->load->config('jwt');
        $now   = time();
        $exp   = $now + $CI->config->item('jwt_exp');
        $payload = [
            'iss'  => $CI->config->item('jwt_issuer'),
            'aud'  => $CI->config->item('jwt_audience'),
            'iat'  => $now,
            'exp'  => $exp,
            'data' => $data
        ];
        return JWT::encode($payload, $CI->config->item('jwt_key'), 'HS256');
    }
}

if (!function_exists('jwt_decode')) {
    function jwt_decode($token) {
        $CI =& get_instance();
        $CI->load->config('jwt');
        try {
            $decoded = JWT::decode(
                $token,
                new Key($CI->config->item('jwt_key'), 'HS256')
            );
            return $decoded->data;
        } catch (Exception $e) {
            return false;
        }
    }
}
