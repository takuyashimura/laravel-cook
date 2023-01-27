<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\buyController;
use App\Http\Controllers\menu_cookController;


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

Route::get('/home', [HomeController::class, 'home'])->name('home');//①
Route::get('/menu', [HomeController::class, 'menu'])->name('menu');//②
Route::get('/add_food', [HomeController::class, 'add_food'])->name('add_food');//③
Route::post('/add', [HomeController::class, 'add'])->name('add');//④
Route::get('/menu_cook', [menu_cookController::class, 'menu_cook'])->name('menu_cook');//⑤
Route::get('/buy', [buyController::class, 'buy'])->name('buy');//⑥


