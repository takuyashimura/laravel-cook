<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\FoodMenu;
use App\Models\User;
use App\Models\ShoppingItem;
use DB;

class buyController extends Controller
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
    public function buy()
    {
        $food = Food::select('food.*')
        ->orderby('created_at','DESC')
        ->get()
        ->keyby('id');
        $food_array = $food->pluck('id')->toArray();

        $stocks = Stock::select('food_id')
        ->selectRaw('SUM(amount) AS total_amount')
        ->groupBy('food_id')
        ->get();
        $stocks_array = $stocks->pluck('food_id')->toArray();
        
        $array= array_diff($food_array,$stocks_array);


        return view('buy',compact('food','stocks','array'));  
    }
    public function add_buy_list(Request $request)
    {
        
        $posts = $request->all();
        // dd($posts);
        
        $menu_id = $posts["menu_id"];
        // dd($menu_id);

        $food = Food::select('food.*')
        ->orderby('created_at','DESC')
        ->get()
        ->keyby("id");

         // food_menusテーブルのfood_idを取得
         $food_menus = FoodMenu::select("food_menus.*")
         ->where("menu_id", "=" , $menu_id)
         ->orderby('food_id','DESC')
         ->get();
 
         
         $stocks = Stock::select('food_id')
         ->selectRaw('SUM(amount) AS total_amount')
         ->groupBy('food_id')
         ->get()
         ->keyby("food_id");

        // dd($result);
        foreach($food_menus as $food_menu){
            if($stocks[$food_menu->food_id]["total_amount"] < $food_menu->food_amount){
                $shopping_items=ShoppingItem::create([
                    'user_id' => \Auth::id(),
                    'food_id' => $food[$food_menu->food_id]['id'],
                    "amount" => $food_menu->food_amount - $stocks[$food_menu->food_id]['total_amount']
                    ])
                    ->get();
            }
            else{
                continue;
            }
        }        

        return redirect(route('buy_list'));  
    }

    public function buy_list()
    {
        $shopping_items = ShoppingItem::select("food_id")
        ->selectRaw('SUM(amount) AS total_amount')
        ->groupBy('food_id')
        ->get();
       

        $food = Food::select('food.*')
        ->where('user_id', '=' , \Auth::id())
        ->orderby('created_at','DESC')
        ->get()
        ->keyby("id");
        return view('add_buy_list',compact("shopping_items","food"));  
    }

    
    public function edit_buy_list()
    {
        $shopping_items = ShoppingItem::select("food_id")
        ->selectRaw('SUM(amount) AS total_amount')
        ->groupBy('food_id')
        ->get()
        ->keyby('food_id');
        // dd($shopping_items);
        $food = Food::select('food.*')
        ->where('user_id', '=' , \Auth::id())
        ->orderby('created_at','DESC')
        ->get()
        ->keyby("id");

        return view('edit_buy_list',compact("shopping_items","food"));
    }

    public function reply_buy_list(Request $request)
    {
        $posts= $request->all();
        return redirect(route('buy_list'));  
    }
    

   
}