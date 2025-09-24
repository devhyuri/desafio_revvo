<?php
declare(strict_types=1);
session_start();

require __DIR__ . '/../app/Helpers/helpers.php';
spl_autoload_register(function($class){
  $base = __DIR__ . '/../';
  $rel  = str_replace('\\','/',$class) . '.php';

  // tenta caminho "App/..."
  $path = $base . $rel;

  // fallback para pasta "app/..." (minúscula)
  if (!file_exists($path)) {
    $rel = preg_replace('#^App/#', 'app/', $rel);
    $path = $base . $rel;
  }

  if (file_exists($path)) require $path;
});

$config = require __DIR__ . '/../config/app.php';

use App\Core\Router;
use App\Core\DB;

DB::init($config['db']);

$router = new Router($config['app']['base_url']);

$router->get('/',                   'App\\Controllers\\HomeController@index');
$router->get('/courses',            'App\\Controllers\\CourseController@index');
$router->get('/courses/create',     'App\\Controllers\\CourseController@create');
$router->post('/courses',           'App\\Controllers\\CourseController@store');
$router->get('/courses/{id}/edit',  'App\\Controllers\\CourseController@edit');
$router->post('/courses/{id}',      'App\\Controllers\\CourseController@update');
$router->post('/courses/{id}/del',  'App\\Controllers\\CourseController@destroy');

$router->get('/slides',             'App\\Controllers\\SlideController@index');
$router->get('/slides/create',      'App\\Controllers\\SlideController@create');
$router->post('/slides',            'App\\Controllers\\SlideController@store');
$router->get('/slides/{id}/edit',   'App\\Controllers\\SlideController@edit');
$router->post('/slides/{id}',       'App\\Controllers\\SlideController@update');
$router->post('/slides/{id}/del',   'App\\Controllers\\SlideController@destroy');

$router->dispatch();
