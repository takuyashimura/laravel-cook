<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

Route::get('/home', [HomeController::class, 'home'])->name('home');//
Route::get('/menu', [HomeController::class, 'menu'])->name('menu');
Route::get('/add_food', [HomeController::class, 'add_food'])->name('add_food');
Route::post('/add', [HomeController::class, 'add'])->name('add');
Route::get('/menu_cook', [HomeController::class, 'menu_cook'])->name('menu_cook');
