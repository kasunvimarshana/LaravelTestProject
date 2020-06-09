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

Route::group(['middleware' => []], function(){
    Route::get('home', array('uses' => 'UserController@home'))->name('home');
    
    Route::get('money_transfer', array('uses' => 'TransactionController@create'))->name('transaction.create');
    Route::post('money_transfer', array('uses' => 'TransactionController@store'))->name('transaction.store');
    Route::get('transaction_data', array('uses' => 'TransactionController@createDetailView'))->name('transaction_data');
});

Route::group(['middleware' => []], function(){
    Route::get('login', array('uses' => 'LoginController@create'))->name('login.create');
    Route::post('login', array('uses' => 'LoginController@doLogin'))->name('login.do');
    Route::get('logout', array('uses' => 'LoginController@doLogout'))->name('login.doLogout');
    
    Route::get('register', array('uses' => 'UserController@create'))->name('user.create');
    Route::post('register', array('uses' => 'UserController@store'))->name('user.store');
    
    Route::match(['get', 'post'], 'check-valid-user', array('uses' => 'UserController@checkValidUser'))->name('user.checkValidUser');
    Route::match(['get', 'post'], 'get-total-amount', array('uses' => 'UserController@getTotalAmount'))->name('user.getTotalAmount');
});

Route::get('/', function () {
    return redirect()->route('login.create');
});

