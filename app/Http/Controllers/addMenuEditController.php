<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\FoodMenu;
use DB;

class addMenuEditController extends Controller
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

     //食材画面
    public function add_menu_edit($menu_id)
    {
        
        //編集しているメニューに使用する食材のfood_idを配列として取得
        $food_menus=FoodMenu::select("food_id")
        ->where("menu_id", "=", $menu_id)
        ->whereNull("deleted_at")
        ->orderby("food_id", "DESC")
        ->get()
        ->pluck("food_id")
        ->toArray();

        $menus = Menu::select("menus.*")
        ->orderby("id","DESC")
        ->get()
        ->keyby("id");

        //食材のidを配列として取得
        $food_array=Food::select("id")
        ->get()
        ->pluck("id")
        ->toArray();

        $food = Food::select("food.*")
        ->orderby("id","DESC")
        ->get()
        ->keyby("id");

        // 選択されたメニューに使用されていないfood_id
        $results = array_diff($food_array,$food_menus);
        // dd($results);


        return view("add_menu_edit",compact("results","food","menu_id","food_menus","menus"));
    }
    
}


