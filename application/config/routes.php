<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

//login routes
$route['default_controller'] = 'login';
$route['authenticate'] = 'login/authenticate';
$route['starter'] = 'starter/index';

//customer routes
$route['customers'] = 'customers';
$route['addcustomer'] = 'customers/addcustomer';
$route['savecustomerform'] = 'customers/savecustomerform';
$route['editcustomer/(:any)'] = 'customers/editcustomer/$1';
$route['updatecustomer'] = 'customers/updatecustomer';
$route['deletecustomer/(:any)'] = 'customers/deletecustomer/$1';

//quotation routes
$route['quotation'] = 'quotation';
$route['quotationspage'] = 'quotation/quotationspage';
$route['addquotation'] = 'quotation/addquotation';
$route['save_quotation'] = 'quotation/save_quotation';
$route['viewquotation/(:num)'] = 'quotation/viewquotation/$1';
$route['editquotation/(:num)'] = 'quotation/editquotation/$1';
$route['deletequotation/(:num)'] = 'quotation/deletequotation/$1';
$route['convert/(:num)'] = 'quotation/convert_to_invoice/$1';

//Invoice Routes
$route['invoicespage'] = 'invoice';
$route['addinvoice'] = 'invoice/addinvoice';
$route['viewinvoice/(:num)'] = 'invoice/viewinvoice/$1';
$route['editinvoice/(:num)'] = 'invoice/editinvoice/$1';
$route['deleteinvoice/(:num)'] = 'invoice/deleteinvoice/$1';
$route['save_payment'] = 'invoice/save_payment';
$route['viewstatment/(:num)'] = 'invoice/viewstatment/$1';

//Email
$route['sendmail/(:num)'] = 'emailcontroler/sendmail/$1';


//error routes
$route['404_override'] = 'errors/Custom404';
$route['translate_uri_dashes'] = FALSE;
