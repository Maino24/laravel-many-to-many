<?php

use App\Http\Controllers\Admin\PostsController;
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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

//Creare un modo per gestire le rotte sotto autenticazione
Route::middleware('auth')
    ->namespace('Admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function(){
    Route::get('/', 'HomeController@index')->name('index');
    //Aggiungo controller CRUD nella sezione admin
    Route::resource('/posts', PostController::class);
});

//Creare un modo per gestire le rotte che non usano autenticazione
Route::get('{any?}', function(){
    return view('guest.home');
})->where('any', ".*");

//Route::get('/home', 'HomeController@index')->name('home');
