<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use DB;

class add_menuController extends Controller
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

     

    // 食材購入画面
    public function add_menu()
    {
        $food = Food::select('food.*')
        ->orderby('created_at','DESC')
        ->get();


        
       return view('add_menu',compact("food"));  
    }

    public function add_menu_register(Request $request)
    {
        $posts=$request->all();
        dd($posts);
        $menu_id=Menu::create(
            [
                'name' => $posts['menu_name'] , 
                'user_id' => \Auth::id()
            ]
        );
        FoodMenu::create(
            [
                'menu_id' => $menu_id ,
                // food_amount => 
            ]
            );
       return redirect(route('menu'));  
    }
}


