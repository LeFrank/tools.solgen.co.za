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
$route['income-types/manage'] = 'incomeTypes/manage';
$route['income-types/capture'] = 'incomeTypes/capture';
$route['income-types/edit/(:num)'] = 'incomeTypes/edit/$1';
$route['income-types/delete/(:num)'] = 'incomeTypes/delete/$1';
$route['income-types/update'] = 'incomeTypes/update';
$route['income-types/type/(:num)'] = 'incomeTypes/getincomeTypeById/$1';

$route['income'] = 'income/view';
$route['income/capture'] = 'income/capture';
$route['income/delete/(:num)'] = 'income/delete/$1';
$route['income/edit/(:num)'] = 'income/edit/$1';
$route['income/export'] = 'income/filteredSearchExportTo';
$route['income/filter-search'] = 'income/filteredSearch';
$route['income/forecast'] = 'income/forecast';
$route['income/getincome/(:any)'] = 'income/getincome/$1';
$route['income/history'] = 'income/history';
$route['income/options'] = 'income/options';
$route['income/stats'] = 'income/statistics';
$route['income/import'] = 'income/import';
$route['income/import/do_upload'] = 'income/importUpload';
$route['income/import/capture'] = 'income/importCapture';
$route['income/import/captured'] = 'income/importCaptured';
$route['income/update'] = 'income/update';

$route['income-assets/manage'] = 'incomeAssets/manage';
$route['income-assets/capture'] = 'incomeAssets/capture';
$route['income-assets/edit/(:num)'] = 'incomeAssets/edit/$1';
$route['income-assets/delete/(:num)'] = 'incomeAssets/delete/$1';
$route['income-assets/update'] = 'incomeAssets/update';

$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
$route['attributions'] = 'home/attributions';
$route['terms-and-conditions'] = 'home/termsAndConditions';

$route['resource'] = 'resource/index';
$route['resource/do_upload'] = 'resource/do_upload';
$route['resource/delete/resource/(:num)'] = 'resource/delete/$1';
$route['resource/view/resource/(:num)/(:any)'] = 'resource/view/$1/$2';
$route['resource/download/resource/(:num)/(:any)'] = 'resource/download/$1/$2';
$route['resource/page'] = 'resource/index';
$route['resource/page/(:any)'] = 'resource/index/$1';
$route['resource/stats'] = 'resource/getStats';

$route['wishlist'] = 'wishlist/index';
$route['wishlist/capture'] = 'wishlist/create';
$route['wishlist/(:num)'] = 'wishlist/item/$1';
$route['wishlist/update/(:num)'] = 'wishlist/update/$1';
$route['wishlist/delete/(:num)'] = 'wishlist/delete/$1';
$route['wishlist/history'] = 'wishlist/history';
$route['wishlist/edit/(:num)'] = 'wishlist/edit/$1';
$route['wishlist/filter-search'] = 'wishlist/filteredSearch';


$route['user/(:any)'] = 'user/$1';
$route['user/delete-account'] = 'user/delete';
$route['user/forgotten-password'] = 'user/forgottenPassword';

$route['user/login'] = 'user/login';
$route['user/logout'] = 'user/logout';
$route['user/register'] = 'user/register';
$route['user/resetPassword/(:any)'] = "user/resetPassword";
$route['user/reset-user-password'] = 'user/resetUserPassword';
$route['user/send-reset-password-email'] = 'user/sendResetEmail';
$route['user/settings'] = 'user/settings';
$route['user/email/unsubscribe'] = 'user/unsubscribeEmail';

$route['event-category/capture'] = 'eventCategory/capture';
$route['event-category/edit/(:num)'] = 'eventCategory/edit/$1';

$route['expenses'] = 'expenses/view';
$route['expenses/capture'] = 'expenses/capture';
$route['expenses/delete/(:num)'] = 'expenses/delete/$1';
$route['expenses/edit/(:num)'] = 'expenses/edit/$1';
$route['expenses/export'] = 'expenses/filteredSearchExportTo';
$route['expenses/filter-search'] = 'expenses/filteredSearch';
$route['expenses/forecast'] = 'expenses/forecast';
$route['expenses/getExpenses/(:any)'] = 'expenses/getExpenses/$1';
$route['expenses/history'] = 'expenses/history';
$route['expenses/options'] = 'expenses/options';
$route['expenses/stats'] = 'expenses/statistics';
$route['expenses/import'] = 'expenses/import';
$route['expenses/import/do_upload'] = 'expenses/importUpload';
$route['expenses/import/capture'] = 'expenses/importCapture';
$route['expenses/import/captured'] = 'expenses/importCaptured';


$route['expense-budget/manage'] = 'expenseBudget/manage';
$route['expense-budget/capture'] = 'expenseBudget/capture';
$route['expense-budget/comment/(:num)'] = 'expenseBudget/comment/$1';
$route['expense-budget/edit/(:num)'] = 'expenseBudget/edit/$1';
$route['expense-budget/delete/(:num)'] = 'expenseBudget/delete/$1';
$route['expense-budget/update'] = 'expenseBudget/update/$1';
$route['expense-budget/post-analysis/(:num)'] = 'expenseBudget/postAnalysis/$1';
$route['expense-budget/manage/page'] = 'expenseBudget/manage';
$route['expense-budget/manage/page/(:any)'] = 'expenseBudget/manage/$1';
$route['expense-budget/export/(:num)'] = 'expenseBudget/export/$1';

$route['expense-periods/capture'] = 'expensePeriods/capture';
$route['expense-periods/manage'] = 'expensePeriods/manage';
$route['expense-periods/update'] = 'expensePeriods/update';
$route['expense-periods/edit/(:num)'] = 'expensePeriods/edit/$1';
$route['expense-periods/delete/(:num)'] = 'expensePeriods/delete/$1';
$route['expense-periods/manage/page'] = 'expensePeriods/manage';
$route['expense-periods/manage/page/(:any)'] = 'expensePeriods/manage/$1';

$route['expense-budget-item/comment/(:num)'] = 'expenseBudgetItems/comment/$1';

$route['expense-budget-items/edit/budget/(:num)'] = 'expenseBudgetItems/editItems/$1';
$route['expense-budget-items/items/(:num)'] = 'expenseBudgetItems/manage/$1';
$route['expense-budget-items/get-period-expense/(:num)/(:num)'] = 'expenseBudgetItems/getExpensesPerTypeFromPeriod/$1/$2';
$route['expense-budget-items/capture'] = 'expenseBudgetItems/capture';

$route['expense-types/manage'] = 'expenseTypes/manage';
$route['expense-types/capture'] = 'expenseTypes/capture';
$route['expense-types/edit/(:num)'] = 'expenseTypes/edit/$1';
$route['expense-types/delete/(:num)'] = 'expenseTypes/delete/$1';
$route['expense-types/update'] = 'expenseTypes/update';
$route['expense-types/type/(:num)'] = 'expenseTypes/getExpenseTypeById/$1';

$route['health'] = 'health/index';
$route['health/metrics'] = 'health/metricsView';
$route['health/metric/capture'] = 'health/metricsCapture';
$route['health/metric/edit/(:num)'] = 'health/metricEdit/$1';
$route['health/metric/update'] = 'health/metricUpdate';
$route['health/metric/delete/(:num)'] = 'health/metricDelete/$1';
$route['health/exercise/tracker'] = 'health/exerciseTrackerView';
$route['health/exercise/capture'] = 'health/exerciseCapture';
$route['health/exercise/edit/(:num)'] = 'health/exerciseEdit/$1';
$route['health/exercise/update'] = 'health/exerciseUpdate';
$route['health/exercise/delete/(:num)'] = 'health/exerciseDelete/$1';
$route['health/diet'] = 'health/dietView';
$route['health/diet/capture'] = 'health/dietCapture';
$route['health/diet/edit/(:num)'] = 'health/dietEdit/$1';
$route['health/diet/update'] = 'health/dietUpdate';
$route['health/diet/delete/(:num)'] = 'health/dietDelete/$1';
$route['health/emotion/tracker'] = 'health/emotionTracker';
$route['health/medical/history'] = 'health/medicalhistory';
$route['health/emotion/record/(:num)'] = 'health/emotionCapture/$1';
$route['health/emotion/tracker/description/(:num)'] = 'health/emotionDescriptionCapture/$1';
$route['health/option'] = 'health/options';
$route['health/option/update/(:num)'] = 'health/optionUpdate/$1';
$route['health/option/create/(:any)'] = 'health/optionCreate/$1';
//target_weight

$route['faq'] = 'faq/index';

$route['locations'] = 'location/manage';
$route['locations/page'] = 'location/manage';
$route['locations/page/(:any)'] = 'location/manage/$1';
$route['location/save'] = 'location/save';
$route['location/edit/(:num)'] = 'location/edit/$1';
$route['location/delete/(:num)'] = 'location/delete/$1';
$route['location/get/(:num)'] = 'location/getLocationData/$1';
$route['location/view/(:num)'] = 'location/view/$1';
$route['location/search/json/(:any)'] = 'location/searchJson/$1';
$route['location/search/(:any)'] = 'location/search/$1';

$route['payment-methods/manage'] = 'paymentMethods/manage';
$route['payment-methods/capture'] = 'paymentMethods/capture';
$route['payment-methods/edit/(:num)'] = 'paymentMethods/edit/$1';
$route['payment-methods/delete/(:num)'] = 'paymentMethods/delete/$1';
$route['payment-methods/update'] = 'paymentMethods/update';

$route['test'] = 'pages/test';

$route['notes/templates/update'] = 'notes/templateUpdate';
$route['notes/templates/delete/(:num)'] = 'notes/templateDelete/$1';
$route['notes/templates/edit/(:num)'] = 'notes/templateEdit/$1';
$route['notes/option/update/(:num)'] = 'notes/optionsUpdate/$1';
$route['notes/templates/template/(:num)'] = 'notes/getTemplate/$1';
$route['notes/view-note/(:num)'] = 'notes/viewNote/$1';
$route['notes/history/search'] = 'notes/searchHistorySave';
$route['notes/history/search/(:num)'] = 'notes/searchHistory/$1';
$route['notes/history/search/(:num)/page'] = 'notes/searchHistory/$1';
$route['notes/history/search/(:num)/page/(:any)'] = 'notes/searchHistory/$1/$2';
$route['notes/index'] = 'notes/history';
$route['notes/capture'] = 'notes/capture';
$route['notes/delete/(:num)'] = 'notes/delete/$1';
$route['notes/history'] = 'notes/history';
$route['notes/history/page'] = 'notes/history';
$route['notes/history/page/(:any)'] = 'notes/history/$1';
$route['notes/tags'] = 'notes/tags';
$route['notes/tag/entries'] = 'notes/getTagContentByString';
$route['notes/update'] = 'notes/update';
$route['notes/edit/(:any)'] = 'notes/edit/$1';
$route['notes/delete/(:any)'] = 'notes/delete/$1';
$route['notes/(:any)'] = 'notes/view/$1';
$route['notes'] = 'notes/history';
$route['notes/stats'] = 'notes/viewStats';
$route['notes/options'] = 'notes/options';
$route['notes/templates'] = 'notes/templateIndex';
$route['notes/templates/capture'] = 'notes/templateCreate';

$route['news/create'] = 'news/create';
$route['news/delete/(:any)'] = 'news/delete/$1';
$route['news/(:any)'] = 'news/view/$1';
$route['news'] = 'news';
$route['test'] = 'test/index';
 
$route['tasks/domains/manage'] = 'tasksDomains/manage';
$route['tasks/domains/create'] = 'tasksDomains/create';
$route['tasks/domains/edit/(:num)'] = 'tasksDomains/edit/$1';
$route['tasks/domains/update'] = 'tasksDomains/update';
$route['tasks/domains/delete/(:num)'] = 'tasksDomains/delete/$1';
$route['tasks/domains/view/(:num)'] = 'tasksDomains/view/$1';
$route['tasks'] = 'tasks/index';
$route['tasks/create'] = 'tasks/create';
$route['tasks/edit/(:num)'] = 'tasks/edit/$1';
$route['tasks/update/(:num)'] = 'tasks/update/$1';
$route['tasks/delete/(:num)'] = 'tasks/delete/$1';
$route['tasks/view/(:num)'] = 'tasks/view/$1';
$route['tasks/options'] = 'tasks/options';
$route['tasks/stats'] = 'tasks/stats';
$route['tasks/mark-as-done/(:num)'] = 'tasks/MarkAsDone/$1';
$route['tasks/mark-as-undone/(:num)'] = 'tasks/MarkAsUnDone/$1';
$route['tasks/status/manage'] = 'tasksStatus/manage';
$route['tasks/status/create'] = 'tasksStatus/create';
$route['tasks/status/edit/(:num)'] = 'tasksStatus/edit/$1';
$route['tasks/status/update'] = 'tasksStatus/update';
$route['tasks/status/delete/(:num)'] = 'tasksStatus/delete/$1';
$route['tasks/status/view/(:num)'] = 'tasksStatus/view/$1';



$route['timetable'] = 'timetable/index';
$route['timetable/capture'] = 'timetable/capture';
$route['timetable/delete/(:num)'] = 'timetable/delete/$1';
$route['timetable/view/(:num)'] = 'timetable/view/$1';
$route['timetable/edit/(:num)'] = 'timetable/edit/$1';
$route['timetable/edit/(:num)/nh'] = 'timetable/editNoHeader/$1';
$route['timetable/options'] = 'timetable/options';
$route['timetable/event-categories'] = 'timetable/eventCategories';
$route['timetable/time-period/search'] = 'timetable/timePeriod';
$route['timetable/search'] = 'timetable/search';
$route['timetable/search/filtered'] = 'timetable/filteredSearch';
$route['timetable/event/(:num)'] = 'timetable/getEvent/$1';

$route['timeline'] = 'timeline/index';
$route['timeline/start-date/(:any)/end-date/(:any)'] = 'timeline/index/$1/$2';

$route['weather'] = 'weather/index';
$route['weather/today'] = 'weather/getTodaysWeather';
$route['weather/forecast'] = 'weather/getSevenDaysWeather';
$route['weather/options'] = 'weather/options';
$route['weather/measurement'] = 'weather/saveMeasurement';

$route['rest/user/login'] = 'user/login_post';

$route['lists'] = 'lists/index';






//$route['(:any)'] = 'pages/view/$1';
//$route['default_controller'] = 'pages/view';
$route['default_controller'] = 'home/index';