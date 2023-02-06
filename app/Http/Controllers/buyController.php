<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
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

        $stocks = Stock::select('food_id')
        ->selectRaw('SUM(amount) AS total_amount')
        ->groupBy('food_id')
        ->get();

        $array = $stocks->pluck('food_id');
        return view('buy',compact('food','stocks','array'));  
    }
}


