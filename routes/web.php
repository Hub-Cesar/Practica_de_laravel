<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'TestController@welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/products/{id}', 'ProductController@show'); // Formulario de edición de productos

Route::post('/cart', 'CartDetailController@store');
Route::delete('/cart', 'CartDetailController@destroy');

Route::post('/order', 'CartController@update');

Route::middleware(['auth', 'admin'])->prefix('admin')->namespace('Admin')->group(function () {
    Route::get('/products', 'ProductController@index'); // Listado de productos (editar o eliminar producto determinado)
    Route::get('/products/create', 'ProductController@create'); // Formulario crear nuevos productos
    Route::post('/products', 'ProductController@store'); // Registrar
    Route::get('/products/{id}/edit', 'ProductController@edit'); // Formulario de edición de productos
    Route::post('/products/{id}/edit', 'ProductController@update'); // Actualizar datos del producto seleccionado
    Route::delete('/products/{id}', 'ProductController@destroy'); // Formulario para eliminar productos

    //GESTIONAR IMAGENES
    Route::get('/products/{id}/images','ImageController@index'); //listado de imagenes segun el producto seleccionado
    Route::post('/products/{id}/images', 'ImageController@store'); // Registrar
    Route::delete('/products/{id}/images', 'ImageController@destroy'); // Formulario para eliminar productos
    Route::get('/products/{id}/images/select/{image}','ImageController@select'); //Destacar una imágen
});

//CR
//UD

//PUT PATCH DELETE