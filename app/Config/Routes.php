<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH.'Config/Routes.php')) {
    require SYSTEMPATH.'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router SetupgetAllSites
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Authentication');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// Authentication
$routes->get('/', 'Home::index');

$routes->get('/admin', 'Authentication\AuthenticationController::index');
$routes->get('/register', 'Authentication\AuthenticationController::register');
$routes->post('/user_register', 'Authentication\AuthenticationController::user_register');
$routes->post('/user_login', 'Authentication\AuthenticationController::user_login');
$routes->get('/logout', 'Authentication\AuthenticationController::logout');
$routes->post('/password_recovery', 'Authentication\AuthenticationController::password_recovery');
$routes->post('/getCategorydropdownList', 'BusinessUsers\BusinessUsersController::getCategorydropdownList');
$routes->get('/password_change', 'Authentication\AuthenticationController::password_change');
$routes->post('/set_new_password', 'Authentication\AuthenticationController::set_new_password');
$routes->post('/setting_change_password', 'Authentication\AuthenticationController::setting_change_password');
$routes->get('/recover_password', 'Authentication\AuthenticationController::forgot_password');
$routes->post('/getCountry', 'Authentication\AuthenticationController::getCountry');
$routes->post('/getState', 'Authentication\AuthenticationController::getState');
$routes->post('/getCity', 'Authentication\AuthenticationController::getCity');

$routes->post('api/client-login', 'Api::clientLogin');

$routes->post('api/contact-lists', 'Api::getContactLists');

$routes->post('api/contact-numbers', 'Api::getContactNumbers');

// settion
$routes->post('getProfileList', 'Authentication\AuthenticationController::getProfileList', ['as' => 'getProfileList']);
$routes->post('update_profile', 'Authentication\AuthenticationController::update_profile', ['as' => 'update_profile']);
// Super Admin Authority

$routes->group('/admin', function ($routes) {
    // send notification
    $routes->post('sendnotification', 'Restaurant\restaurantOrderController::sendnotification', ['as' => 'sendnotification']);

    // Dashboard
    $routes->get('dashboard', 'Dashboard\DashboardController::index', ['as' => 'admin_dashboard']);

    // $routes->get('dashboard', 'Dashboard\DashboardController::index', ['as' => 'admin_dashboard','filter' => 'adminLogin']);

    $routes->post('getdashboardCounter', 'Dashboard\DashboardController::getdashboardCounter', ['as' => 'getdashboardCounter']);

    // clients
    $routes->get('clients', 'Clients\ClientsController::clients', ['as' => 'clients']);
    $routes->post('getClientsList', 'Clients\ClientsController::getClientsList', ['as' => 'getClientsList']);
    $routes->post('fetchClient', 'Clients\ClientsController::fetchClient', ['as' => 'fetchClient']);
    $routes->post('addClient', 'Clients\ClientsController::addClient', ['as' => 'addClient']);
    $routes->post('delete_client', 'Clients\ClientsController::delete_client', ['as' => 'delete_client']);
    $routes->get('client-account-details/(:num)', 'Clients\ClientsController::accountDetails/$1');
    $routes->post(
        'create-contact-list',
        'Clients\ClientsController::createContactList'
    );

    $routes->post(
        'delete-contact-list',
        'Clients\ClientsController::deleteContactList'
    );

    $routes->get(
        'contact-list-numbers/(:num)',
        'Clients\ClientsController::contactListNumbers/$1'
    );

    $routes->post(
        'get-contact-list-numbers',
        'Clients\ClientsController::getContactListNumbers'
    );

    $routes->post(
        'delete-selected-numbers',
        'Clients\ClientsController::deleteSelectedNumbers'
    );
    $routes->post(
        'add-contact-numbers',
        'Clients\ClientsController::addContactNumbers'
    );
    $routes->post(
        'admin/delete-contact-number',
        'Clients\ClientsController::deleteContactNumber'
    );

    // users

    $routes->get('users', 'Users\UsersController::users', ['as' => 'users']);
    $routes->post('getUsersList', 'Users\UsersController::getUsersList', ['as' => 'getUsersList']);
    $routes->post('fetchUser', 'Users\UsersController::fetchUser', ['as' => 'fetchUser']);
    $routes->post('deactivate_user', 'Users\UsersController::deactivate_user', ['as' => 'deactivate_user']);
    $routes->get('user_details/(:any)', 'Users\UsersController::user_details/$1', ['as' => 'user_details']);
    $routes->post('getCleHistoryArchiveList', 'Users\UsersController::getCleHistoryArchiveList', ['as' => 'getCleHistoryArchiveList']);
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH.'Config/'.ENVIRONMENT.'/Routes.php')) {
    require APPPATH.'Config/'.ENVIRONMENT.'/Routes.php';
}
