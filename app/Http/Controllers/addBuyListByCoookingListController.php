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

class addBuyListByCoookingListController extends Controller
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


    public function addBuyListByCoookingList(Request $request)
    {
        $posts=$request->all();

        $shopping_items_food_id_array = ShoppingItem::select("shopping_items.*")
        ->where("user_id","=",\Auth::id())
        ->whereNull("deleted_at")
        ->pluck("food_id")
        ->toArray();
        // dd($shopping_items_food_id_array);
        //$postの配列から整数のキーのデータのみ抽出する
        $integer_keys_data = [];
        foreach ($posts as $key => $value) {
            if (is_int($key)) {
                $integer_keys_data[$key] = $value;
            }
        }
        
        foreach($integer_keys_data as $key => $value){
            if(in_array($key,$shopping_items_food_id_array)){
                ShoppingItem::where("food_id","=",$key)
                ->where("user_id","=",\Auth::id())
                ->increment("amount",$value);
            }else{
                ShoppingItem::create([
                    "user_id"=>\Auth::id(),
                    "food_id"=>$key,
                    "amount"=>$value
                ]);
            }
            
        }


        
        

       return redirect(route('buy_list'));  
    }
}


