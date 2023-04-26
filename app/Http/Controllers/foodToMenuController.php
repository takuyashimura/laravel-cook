<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\FoodMenu;
use DB;

class foodToMenuController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     

     //メニュー画面 メニューコントローラを作成し追加する
     public function foodToMenu(Request $request)//済み
     {
        $posts =$request->all();

        $menu = FoodMenu::whereNull("food_menus.deleted_at")
        ->where("user_id" ,"=",$posts["userId"])
        ->where("food_id","=",$posts["food_stock"]['id'])
        ->leftjoin("menus","food_menus.menu_id" ,"=","menus.id")
        ->select("menus.*")
        ->get();
        
        return [$posts["food_stock"]["name"],$menu];
        }
    
}