<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\buyController;
use App\Http\Controllers\menu_cookController;
use App\Http\Controllers\menuController;
use App\Http\Controllers\add_menuController;
use App\Http\Controllers\cookingController;


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
Route::get('/menu', [menuController::class, 'menu'])->name('menu');//②
Route::get('/add_food', [HomeController::class, 'add_food'])->name('add_food');//③
Route::post('/add', [HomeController::class, 'add'])->name('add');//④
Route::get('/menu_cook/{menu_id}', [menu_cookController::class, 'menu_cook'])->name('menu_cook');//⑤
Route::get('/buy', [buyController::class, 'buy'])->name('buy');//⑥
Route::get('/add_menu', [add_menuController::class, 'add_menu'])->name('add_menu');//⑦
Route::post('/add_menu_register', [add_menuController::class, 'add_menu_register'])->name('add_menu_register');//⑦
Route::post('/cooking_lists', [cookingController::class, 'cooking_lists'])->name('cooking_lists');//⑧
Route::post('/add_buy_list', [buyController::class, 'add_buy_list'])->name('add_buy_list');
Route::get('/buy_list', [buyController::class, 'buy_list'])->name('buy_list');
Route::get('/edit_buy_list', [buyController::class, 'edit_buy_list'])->name('edit_buy_list');
Route::post('/reply_buy_list', [buyController::class, 'reply_buy_list'])->name('reply_buy_list');



