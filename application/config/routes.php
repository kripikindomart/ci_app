<?php
defined('BASEPATH') or exit('No direct script access allowed');
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['panel'] = 'admin';
$route['dashboard'] = 'admin/dashboard';
// $route['(:any)/stats'] = 'url/stats/$1';
// $route['(:any)'] = 'url/redirect/$1';
