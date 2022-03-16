<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('contacts', 'App\Http\Controllers\ContactsController',['except' => ['edit']]);

Route::resource('addresses', 'App\Http\Controllers\AddressesController',['except' => ['destroy', 'edit']]);

Route::resource('phone', 'App\Http\Controllers\PhoneController',['except' => ['destroy', 'edit']]);
