<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\FoodMenu;
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
        ->get();

        // food_menusテーブルのfood_idを取得
        $food_ids = FoodMenu::select("food_id")
        ->where("menu_id", "=" , $menu_id)
        ->get();

        $stocks = Stock::select("stocks.*")
        ->orderby("created_at", "DESC")
        ->get();
        
        return view('menu_cook',compact('menu_name',"food","food_ids","stocks"));
    }
}


