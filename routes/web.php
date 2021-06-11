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

Route::get('/pagar', 'PagSeguroController@pagar')->name('tela-pagar');
Route::post('/finalizar', 'PagSeguroController@finalizar')->name('concluir');
Route::get('/teste', 'PagSeguroController@teste');
Route::get('/', function () {
    return view('welcome');
});
Route::get('export/', 'excelController@export')->name("exportar");
Route::get('/painel', 'PagSeguroController@painel');