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

Route::get('/', function () {
    return view('welcome');
});

