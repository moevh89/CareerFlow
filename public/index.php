<?php
session_start();

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

use App\Core\Migrator;
Migrator::migrate();

use Bramus\Router\Router;

$router = new Router();

$router->get('/', function() {
    echo file_get_contents(__DIR__ . '/index.html');
});

$router->mount('/api', function() use ($router) {
    // Auth
    $router->get('/csrf-token', 'App\Controllers\AuthController@getCSRFToken');
    $router->post('/register', 'App\Controllers\AuthController@register');
    $router->post('/login', 'App\Controllers\AuthController@login');
    $router->post('/logout', 'App\Controllers\AuthController@logout');
    $router->get('/me', 'App\Controllers\AuthController@me');
    $router->post('/forgot-password', 'App\Controllers\AuthController@forgotPassword');

    // Companies
    $router->get('/companies', 'App\Controllers\CompanyController@index');
    $router->post('/companies', 'App\Controllers\CompanyController@store');
    $router->get('/companies/(\d+)', 'App\Controllers\CompanyController@show');

    // Contacts
    $router->get('/contacts', 'App\Controllers\ContactController@index');
    $router->post('/contacts', 'App\Controllers\ContactController@store');

    // Applications
    $router->get('/applications', 'App\Controllers\ApplicationController@index');
    $router->post('/applications', 'App\Controllers\ApplicationController@store');
    $router->patch('/applications/(\d+)/status', 'App\Controllers\ApplicationController@updateStatus');

    // Dashboard
    $router->get('/dashboard', 'App\Controllers\DashboardController@index');
});

$router->run();
