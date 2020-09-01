<?php

use App\Http\Controllers\RecipeController;
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

Route::get('/', function () {
  return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('recipes', 'RecipeController');

Route::post('/recipes/desc', 'OrderController@descending');
Route::post('/recipes', 'OrderController@ascending');

Route::post('/recipes.show', 'RecipeController@vote');
Route::post('/recipe/create', 'RecipeController@store');
