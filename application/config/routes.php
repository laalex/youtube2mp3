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

//Default controller
$route['default_controller'] = "web";

/* Account routes */
$route['register'] = 'auth/register';
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';
/* Application routes */
$route['dashboard'] = 'application';
$route['settings'] = 'application/settings';
$route['playlists/getPlaylists'] = 'application/playlists';
$route['playlists/get/(:num)'] = 'application/view_playlist';
$route['playlists/set_default/(:num)'] = 'application/set_default';
$route['playlists/remove/(:num)'] = 'application/remove_playlist';
$route['invitations/getInvitations'] = 'application/get_invitations';
/** Settings routes */
$route['settings/change_password'] = 'application/change_password';
$route['settings/put_invite'] = 'application/put_invitation';
//$route['application/accept_invite/(:num)'] = 'application/accept_invite';




$route['404_override'] = '';

/* End of file routes.php */
/* Location: ./application/config/routes.php */