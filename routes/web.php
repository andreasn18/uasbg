<?php

use App\Http\Controllers\JumlahPasienController;
use Illuminate\Support\Facades\Auth;
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
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'JumlahPasienController@index')->name('welcome');
// Route::get('/admin', 'MasterKabupatenController@index')->name('admin')->middleware('auth');

Auth::routes();
Route::resource('dataPasien', 'DataPasienController')->middleware('auth');

Route::get('/home', 'HomeController@index')->name('home');
