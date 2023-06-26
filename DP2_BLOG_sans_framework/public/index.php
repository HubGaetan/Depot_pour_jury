<?php

// importation des classes
// ("use" utilise composer et le fichier de configuration composer.json)
use Router\Router;
use App\Exceptions\NotFoundException;


require '../vendor/autoload.php';

// CONSTANTS
// racine du site
define('HREF_ROOT', 'http://localhost/PHP_SQL/app/EXERCICE/BLOG_ss_frmwk/' );
//racine des fichiers de vue
define('VIEWS', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);
//Contains the current script's path. This is useful for pages which need to point to themselves
define('SCRIPTS', dirname($_SERVER['SCRIPT_NAME']) . DIRECTORY_SEPARATOR); // Code original
//definition des parametres de connexion a la base de données
define('DB_NAME', 'myapp');
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PWD', '');

define('IS_DEBUG' , false);
define('DIR_IMAGES' ,  'images/');

// // // // // // // // // // // // // // // // // // // // // // // // // // // // // // // // // // // // 

// ROUTES
$router = new Router($_GET['url']);

$router->get('/', 'App\Controllers\BlogController@welcome');
$router->get('/posts', 'App\Controllers\BlogController@index');
$router->get('/posts/:id', 'App\Controllers\BlogController@show');
$router->get('/tags/:id', 'App\Controllers\BlogController@tag');

$router->get('/login', 'App\Controllers\UserController@login');
$router->post('/login', 'App\Controllers\UserController@loginPost');
$router->get('/logout', 'App\Controllers\UserController@logout');

$router->get('/admin/posts', 'App\Controllers\Admin\PostController@index');
$router->get('/admin/posts/create', 'App\Controllers\Admin\PostController@create');
$router->post('/admin/posts/create', 'App\Controllers\Admin\PostController@createPost');
$router->post('/admin/posts/delete/:id', 'App\Controllers\Admin\PostController@destroy');
$router->get('/admin/posts/edit/:id', 'App\Controllers\Admin\PostController@edit');
$router->post('/admin/posts/edit/:id', 'App\Controllers\Admin\PostController@update');

$router->get('/admin/tags', 'App\Controllers\Admin\TagController@index');
$router->get('/admin/tags/create', 'App\Controllers\Admin\TagController@create');
$router->post('/admin/tags/create', 'App\Controllers\Admin\TagController@createTag');
$router->post('/admin/tags/delete/:id', 'App\Controllers\Admin\TagController@destroy');
$router->get('/admin/tags/edit/:id', 'App\Controllers\Admin\TagController@edit');
$router->post('/admin/tags/edit/:id', 'App\Controllers\Admin\TagController@update');

$router->get('/admin/medias', 'App\Controllers\Admin\MediaController@index');
$router->get('/admin/medias/create', 'App\Controllers\Admin\MediaController@create');
$router->post('/admin/medias/create', 'App\Controllers\Admin\MediaController@createMedia');
$router->post('/admin/medias/delete/:id', 'App\Controllers\Admin\MediaController@destroy');
$router->get('/admin/medias/edit/:id', 'App\Controllers\Admin\MediaController@edit');
$router->post('/admin/medias/edit/:id', 'App\Controllers\Admin\MediaController@update');

//$router->post('/images', 'App\Controllers\Admin\MediaController@upload');

//
try {
    
    $router->run();
} catch (NotFoundException $e) {
    return $e->error404();
}
