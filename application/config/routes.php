<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'main';

//роутинг для админки
$route['admin'] = 'admin/index';
$route['admin/pages'] = 'admin/pages';
$route['admin/pages/(:num)'] = 'admin/pages/index/$1';
$route['admin/products'] = 'admin/products';
$route['admin/products/(:num)'] = 'admin/products/index/$1';
$route['admin/categories'] = 'admin/categories';
$route['admin/categories/(:num)'] = 'admin/categories/index/$1';
$route['admin/files'] = 'admin/files';
$route['admin/files/(:num)'] = 'admin/files/index/$1';
$route['auth'] = 'auth';
//

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
