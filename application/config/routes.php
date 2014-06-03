<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
$route['user/(:any)'] = 'user/$1';
$route['user/delete-account'] = 'user/delete';
$route['user/forgotten-password'] = 'user/forgottenPassword';
$route['user/location/manage'] = 'user/manageLocation';
$route['user/location/save'] = 'user/saveLocation';
$route['user/login'] = 'user/login';
$route['user/logout'] = 'user/logout';
$route['user/register'] = 'user/register';
$route['user/resetPassword/(:any)'] = "user/resetPassword";
$route['user/reset-user-password'] = 'user/resetUserPassword';
$route['user/send-reset-password-email'] = 'user/sendResetEmail';
$route['user/settings'] = 'user/settings';
$route['user/email/unsubscribe'] = 'user/unsubscribeEmail';

$route['expenses'] = 'expenses/view';
$route['expenses/capture'] = 'expenses/capture';
$route['expenses/delete/(:num)'] = 'expenses/delete/$1';
$route['expenses/edit/(:num)'] = 'expenses/edit/$1';
$route['expenses/filter-search'] = 'expenses/filteredSearch';
$route['expenses/forecast'] = 'expenses/forecast';
$route['expenses/getExpenses/(:any)'] = 'expenses/getExpenses/$1';
$route['expenses/history'] = 'expenses/history';
$route['expenses/options'] = 'expenses/options';
$route['expenses/stats'] = 'expenses/statistics';



$route['expense-types/manage'] = 'expenseTypes/manage';
$route['expense-types/capture'] = 'expenseTypes/capture';
$route['expense-types/edit/(:num)'] = 'expenseTypes/edit/$1';
$route['expense-types/delete/(:num)'] = 'expenseTypes/delete/$1';
$route['expense-types/update'] = 'expenseTypes/update';


$route['faq'] = 'faq/index';

$route['payment-methods/manage'] = 'paymentMethods/manage';
$route['payment-methods/capture'] = 'paymentMethods/capture';
$route['payment-methods/edit/(:num)'] = 'paymentMethods/edit/$1';
$route['payment-methods/delete/(:num)'] = 'paymentMethods/delete/$1';
$route['payment-methods/update'] = 'paymentMethods/update';

$route['test'] = 'pages/test';

$route['news/create'] = 'news/create';
$route['news/delete/(:any)'] = 'news/delete/$1';
$route['news/(:any)'] = 'news/view/$1';
$route['news'] = 'news';


$route['test'] = 'test/index';

$route['weather'] = 'weather/index';

//$route['(:any)'] = 'pages/view/$1';
//$route['default_controller'] = 'pages/view';
$route['default_controller'] = 'home/index';