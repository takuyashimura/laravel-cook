<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\FoodMenu;
use App\Models\ShoppingItem;
use DB;

class menu_cookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     

    // メニュー確定画面
    public function menu_cook($menu_id)
    {
        $menu_name = Menu::find($menu_id);
        $food = Food::select('food.*')
        ->orderby('created_at','DESC')
        ->get()
        ->keyby("id");


        // food_menusテーブルのfood_idを取得
        $food_menus = FoodMenu::select("food_menus.*")
        ->where("menu_id", "=" , $menu_id)
        ->orderby('food_id','DESC')
        ->get();

        $food_menus_amount = FoodMenu::select("food_id")
        ->selectRaw('SUM(food_amount) AS total_amount')
        ->groupBy('food_id')        
        ->get()
        ->keyby("food_id");

        $stocks = Stock::select('food_id')
        ->selectRaw('SUM(amount) AS total_amount')
        ->groupBy('food_id')
        ->get()
        ->keyby("food_id");

        $shopping_items = ShoppingItem::select("shopping_items.*")
        ->get()
        ->keyby("food_id");
        
        return view('menu_cook',compact('menu_name',"food","food_menus","stocks","menu_id","shopping_items","food_menus_amount"));
    }
}


