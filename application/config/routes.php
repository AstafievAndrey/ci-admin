<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'main';
$route['address'] = 'main/address';
$route['otzyvy'] = 'main/otzyvy';
$route['statya/(:any)'] = 'main/statya/$1';
$route['stati'] = 'main/stati';
$route['stati/(:num)'] = 'main/stati/$1';
$route['divan/(:any)'] = 'main/divan/$1';
$route['katalog'] = 'main/katalog';
$route['katalog/(:any)'] = 'main/katalog/$1';
$route['katalog/(:any)/(:num)'] = 'main/katalog/$1/$2';

//роутинг для админки
$route['admin'] = 'admin/index';
$route['admin/pages'] = 'admin/pages';
$route['admin/pages/(:num)'] = 'admin/pages/index/$1';
$route['admin/products'] = 'admin/products';
$route['admin/products/(:num)'] = 'admin/products/index/$1';
$route['admin/files'] = 'admin/files';
$route['admin/files/(:num)'] = 'admin/files/index/$1';
$route['auth'] = 'auth';
//

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
