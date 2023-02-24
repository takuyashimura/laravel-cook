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

class boughtFoodController extends Controller
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
     public function boughtFood(Request $request)
     {
         $posts=$request->all();
        //  dd($posts);
         $post = array_filter($posts, function ($key) {
            return is_int($key);
        }, ARRAY_FILTER_USE_KEY);
        // dd($post);

         foreach($post as $key => $value){
            Stock::create([
                "food_id" => $key,
                "user_id" => \Auth::id(),
                "amount" => $value
            ]);

            
         }
         ShoppingItem::whereNull("deleted_at")
         ->update(["deleted_at" => now()]);
         
         
 
        return redirect(route('home'));  
     }


}    

