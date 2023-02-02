<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\FoodMenu;
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
        $menu_id=Menu::insertGetId(
            [
                'name' => $posts['menu_name'] , 
                'user_id' => \Auth::id()
            ]
        );
        foreach($posts["food_ids"] as $food_id => $amount){
            if($amount == Null){
                continue;
            }
            FoodMenu::create(
                [
                    "food_amount" => $amount,
                    "food_id" => $food_id,
                    'menu_id' => $menu_id 
                    
                ]
                );
        }

       return redirect(route('menu'));  
    }
}


