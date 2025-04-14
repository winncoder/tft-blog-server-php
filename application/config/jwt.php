<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['jwt_key']      = 'your-very-secret-key';
$config['jwt_issuer']   = 'http://yourdomain.com';
$config['jwt_audience'] = 'http://yourdomain.com';
$config['jwt_exp']      = 3600; // seconds
$config['jwt_algorithm'] = 'HS256'; // or RS256