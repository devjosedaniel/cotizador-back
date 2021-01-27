<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->get('/prueba', function () {
    return phpinfo();
});

$router->get('usuario', 'UsuarioController@index');
$router->post('usuario', 'UsuarioController@store');
$router->get('usuario/{id}', 'UsuarioController@show');
$router->post('usuario/auth', 'UsuarioController@auth');

$router->get('producto', 'ProductoController@index');
$router->post('producto', 'ProductoController@store');
$router->get('producto/{id}', 'ProductoController@show');
$router->delete('producto/{id}', 'ProductoController@delete');
$router->put('producto/{id}', 'ProductoController@update');
$router->get('producto/all/categoria', 'ProductoController@categoria');

$router->get('categoria', 'CategoriaController@index');
$router->post('categoria', 'CategoriaController@store');
$router->get('categoria/{id}', 'CategoriaController@show');
$router->delete('categoria/{id}', 'CategoriaController@delete');
$router->put('categoria/{id}', 'CategoriaController@update');

$router->post('cliente', 'ClienteController@store');
$router->get('cliente', 'ClienteController@index');
$router->get('cliente/{id}', 'ClienteController@show');
$router->put('cliente/{id}', 'ClienteController@update');
$router->delete('cliente/{id}', 'ClienteController@delete');

$router->post('cotizacion', 'CotizacionController@store');
$router->get('cotizacion', 'CotizacionController@index');
$router->get('cotizacion/{id}', 'CotizacionController@show');
$router->get('cotizacion/{id}/pdf', 'CotizacionController@pdf');
$router->delete('cotizacion/{id}/anular', 'CotizacionController@anular');
