<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], 'compras/pagar', 'PagSeguroController@pagar');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});