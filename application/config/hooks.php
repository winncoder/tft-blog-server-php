<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$hook['post_controller_constructor'][] = [
    'class'    => 'JwtHook',
    'function' => 'protect',
    'filename' => 'JwtHook.php',
    'filepath' => 'hooks',
    'params'   => []
];

