<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\CookingList;
use App\Models\FoodMenu;
use DB;

class cookingListController extends Controller
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
    public function cooking_list()
    {
        $cooking_lists = CookingList::select("cooking_lists.*")
        ->orderby("created_at")
        ->get();
        
        $menus = Menu::select("menus.*")
        ->orderby("created_at")
        ->get()
        ->keyby("id");

        $food_menus = FoodMenu::select("menu_id")
        ->selectRaw('SUM(food_amount) AS total_amount')
        ->groupBy('menu_id')        
        ->get()
        ->keyby("menu_id");

        $food_memu_food_id = FoodMenu::select("food_menus.*")
        ->orderby("menu_id","DESC")
        ->get()
        ->keyby("food_id");

        $stocks = Stock::select("stocks.*")
        ->get()
        ->keyby("food_id");

        $food = Food::select("food.*")
        ->get()
        ->keyby("id");

        // 購入リストに表示されているメニューで使用する食材の送料を求める


        return view('cooking_list',compact("cooking_lists","menus","food_menus","stocks","food_memu_food_id","food"));
    }
    public function add_cooking_list(Request $request)
    {
        $posts=$request->all();
        $menu_id = $posts["menu"];

        Cookinglist::create([
            "menu_id" => $menu_id,
            "user_id" => \Auth::id(),
        ]);


        return redirect( route('cooking_list') );  
    }

   


}    