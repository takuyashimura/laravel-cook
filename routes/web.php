<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\buyController;
use App\Http\Controllers\menu_cookController;
use App\Http\Controllers\menuController;
use App\Http\Controllers\add_menuController;
use App\Http\Controllers\cookingController;
use App\Http\Controllers\cookingListController;
use App\Http\Controllers\textController;
use App\Http\Controllers\menuEditController;
use App\Http\Controllers\deleteController;
use App\Http\Controllers\addMenuEditController;
use App\Http\Controllers\addMenuFoodController;
use App\Http\Controllers\foodToMenuController;
use App\Http\Controllers\stockController;
use App\Http\Controllers\boughtFoodController;
use App\Http\Controllers\cookingListFoodAmountController;
use App\Http\Controllers\cookingListdeleteController;
use App\Http\Controllers\addBuyListByCoookingListController;


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

//  Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/{any}', function () {
    return view('index');
})->where('any', '.*');


Auth::routes();
// コントローラー、URLには基本的に_を使用しないので編集して無くす
// Route::get('/home', [HomeController::class, 'home'])->name('home'); //済み
// Route::get('/menu', [menuController::class, 'menu'])->name('menu'); //済み
// Route::post('/add', [stockController::class, 'add'])->name('add'); //確認済み
// Route::post('/menu_cook', [menu_cookController::class, 'menu_cook'])->name('menu_cook'); //確認済み
// Route::get('/add_menu', [add_menuController::class, 'add_menu'])->name('add_menu');//済み 
// Route::post('/add_menu_register', [add_menuController::class, 'add_menu_register'])->name('add_menu_register'); 
// Route::post('/add_buy_list', [buyController::class, 'add_buy_list'])->name('add_buy_list');//済み
// Route::get('/buy_list', [buyController::class, 'buy_list'])->name('buy_list');//済み
// Route::get('/edit_buy_list', [buyController::class, 'edit_buy_list'])->name('edit_buy_list');//済み
// Route::post('/reply_buy_list', [buyController::class, 'reply_buy_list'])->name('reply_buy_list');
// Route::get('/cooking_list', [cookingListController::class, 'cooking_list'])->name('cooking_list');//済み
// Route::post('/add_cooking_list', [cookingListController::class, 'add_cooking_list'])->name('add_cooking_list'); //済み
// Route::post('/text', [textController::class, 'text'])->name('text'); //済み
// Route::post('/menu_edit', [menuEditController::class, 'menu_edit'])->name('menu_edit');//済み
// Route::post('/menu_delete', [deleteController::class, 'menu_delete'])->name('menu_delete');//済み
// Route::post('/add_menu_edit', [addMenuEditController::class, 'add_menu_edit'])->name('add_menu_edit');//済み
// Route::post('/foodToMenu', [foodToMenuController::class, 'foodToMenu'])->name('foodToMenu');//済み
// Route::post('/boughtFood', [boughtFoodController::class, 'boughtFood'])->name('boughtFood');//済み
// Route::post('/addBuyListByCoookingList', [addBuyListByCoookingListController::class, 'addBuyListByCoookingList'])->name('addBuyListByCoookingList');//済み
// Route::post('/cooking', [cookingController::class, 'cooking'])->name('cooking');//済み
// Route::post('/food_delete', [deleteController::class, 'food_delete'])->name('food_delete'); //確認済み
// Route::post('/foodCheck', [foodCheckController::class, 'foodCheck'])->name('foodCheck');//済み
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::post('register', [AuthController::class, 'register']);
// Route::post('login', [AuthController::class, 'login']);
// Route::middleware('auth:sanctum')->group(function() {
//     Route::post('logout', [AuthController::class, 'logout']);
// });