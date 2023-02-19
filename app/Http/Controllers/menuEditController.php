<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\FoodMenu;
use DB;

class menuEditController extends Controller
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
    public function menu_edit($menu_id)
    {
        $menus = Menu::select("menus.*")
        ->orderby("id")
        ->get()
        ->keyby("id");

        $food_menus = FoodMenu::select("food_menus.*")
        ->where("menu_id",$menu_id)
        ->get();
        $food = Food::select("food.*")
        ->get()
        ->keyby("id");



        return view('menu_edit',compact("menus","menu_id","food","food_menus"));
    }

   


    

   
}


