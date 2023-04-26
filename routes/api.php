<?php

use Illuminate\Http\Request;
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
use App\Http\Controllers\foodToMenuController;
use App\Http\Controllers\stockController;
use App\Http\Controllers\boughtFoodController;
use App\Http\Controllers\cookingListFoodAmountController;
use App\Http\Controllers\cookingListdeleteController;
use App\Http\Controllers\addBuyListByCoookingListController;
use App\Http\Controllers\foodCheckController;

use App\Http\Controllers\API\AuthController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// コントローラー、URLには基本的に_を使用しないので編集して無くす
Route::get('/home/{id}', [HomeController::class, 'home'])->name('home'); //済み ユーザー認証済み
Route::get('/menu/{id}', [menuController::class, 'menu'])->name('menu'); //済み ユーザー認証済み
Route::post('/add', [stockController::class, 'add'])->name('add'); //確認済み ユーザー認証済み
Route::post('/menu_cook', [menu_cookController::class, 'menu_cook'])->name('menu_cook'); //済み ユーザー認証済み
Route::get('/add_menu/{id}', [add_menuController::class, 'add_menu'])->name('add_menu');//済み ユーザー認証済み
Route::post('/add_menu_register', [add_menuController::class, 'add_menu_register'])->name('add_menu_register'); //済み ユーザー認証済み
Route::post('/add_buy_list', [buyController::class, 'add_buy_list'])->name('add_buy_list');//済み ユーザー認証済み
Route::get('/buy_list/{id}', [buyController::class, 'buy_list'])->name('buy_list');//済み ユーザー認証済み
Route::get('/edit_buy_list/{id}', [buyController::class, 'edit_buy_list'])->name('edit_buy_list');//済み ユーザー認証済み
Route::post('/reply_buy_list', [buyController::class, 'reply_buy_list'])->name('reply_buy_list');//済み ユーザ認証済み
Route::get('/cooking_list/{id}', [cookingListController::class, 'cooking_list'])->name('cooking_list');//済み ユーザー認証済み
Route::post('/add_cooking_list', [cookingListController::class, 'add_cooking_list'])->name('add_cooking_list'); //済み ユーザー認証済み
Route::post('/text', [textController::class, 'text'])->name('text'); //済み ユーザー認証済み
Route::post('/menu_edit', [menuEditController::class, 'menu_edit'])->name('menu_edit');//済み ユーザー認証なし
Route::post('/menu_delete', [deleteController::class, 'menu_delete'])->name('menu_delete');//済み ユーザー認証必要なし
Route::post('/add_menu_edit', [addMenuEditController::class, 'add_menu_edit'])->name('add_menu_edit');//済み ユーザー認証なし
Route::post('/foodToMenu', [foodToMenuController::class, 'foodToMenu'])->name('foodToMenu');//済み ユーザー認証済み
Route::post('/boughtFood', [boughtFoodController::class, 'boughtFood'])->name('boughtFood');//済み ユーザー認証済み
Route::post('/addBuyListByCoookingList', [addBuyListByCoookingListController::class, 'addBuyListByCoookingList'])->name('addBuyListByCoookingList');//済み ユーザー認証済み
Route::post('/cooking', [cookingController::class, 'cooking'])->name('cooking');//済み ユーザー認証済み
Route::post('/food_delete', [deleteController::class, 'food_delete'])->name('food_delete'); //済み ユーザー認証なし
Route::post('/foodCheck', [foodCheckController::class, 'foodCheck'])->name('foodCheck');//済み ユーザー認証なし
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function() {
    Route::post('logout', [AuthController::class, 'logout']);
});