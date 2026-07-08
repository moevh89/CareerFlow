<?php
session_start();

// Custom autoloader instead of Composer
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../src/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

App\Core\Dotenv::load(__DIR__ . '/../.env');

// If DB configuration is not present, redirect to setup
if (empty($_ENV['DB_DRIVER']) && !str_contains($_SERVER['REQUEST_URI'], 'setup.php')) {
    header("Location: setup.php");
    die();
}

// Check if tables exist, if not, wait for setup.php
if (!empty($_ENV['DB_DRIVER'])) {
    try {
        $db = App\Core\Database::getInstance()->getConnection();
        $db->query("SELECT 1 FROM users LIMIT 1");
    } catch (\Exception $e) {
        if (!str_contains($_SERVER['REQUEST_URI'], 'setup.php') && !str_contains($_SERVER['REQUEST_URI'], 'api')) {
            header("Location: setup.php");
            die();
        }
    }
}

use App\Core\Router;

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
