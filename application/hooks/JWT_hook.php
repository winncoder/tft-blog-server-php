<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JwtHook {

    public function protect() {
        $CI =& get_instance();

        // Only protect controllers under /api except Auth
        $controller = $CI->router->fetch_class();
        if ($CI->router->fetch_directory() !== 'api/' 
            || $controller === 'Auth') {
            return;
        }

        // Get Authorization header
        $hdrs = $CI->input->get_request_header('Authorization');
        if (!preg_match('/Bearer\s(\S+)/', $hdrs, $m)) {
            show_error('Unauthorized', 401);
        }

        $token = $m[1];
        $user  = jwt_decode($token);  // from our helper
        if (!$user) {
            show_error('Invalid or expired token', 401);
        }

        // Make user data available in controllers
        $CI->user = $user;
    }
}
