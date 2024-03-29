<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    //食材画面
    public function home(Request $request,$id)
    {
    $food_stocks = Food::whereNull("food.deleted_at")
    ->where("food.user_id","=",$id)
    ->leftjoin("stocks","food.id","=","stocks.food_id")
    ->select("food.id","food.name","food.category_id")
    ->selectRaw('SUM(amount) AS total_amount')
    ->groupBy('food.id',"food.name")
    ->get()
    ->toArray();

 
        return response()->json([
            "food_stocks" => $food_stocks,
        ],
        200,
        [],
        JSON_UNESCAPED_UNICODE //文字化け対策
        );



        
    }
}