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
        ->get();
        
        $stocks = Stock::select('stocks.*')
        ->orderby('created_at','DESC')
        ->get();
        
        $stockArray = array_column($stocks, 'amount',"food_id");
        dd($stockArray);

        // $amount = 0;
        // foreach ($stocks as $stock) {
        //     if ($stock->food_id == $this -> food_id) {
        //       $amount += $stock['amount'];
        //     }
        //     dd($amount);
        // }


       
       return view('buy',compact('food','stockArray'));  
    }
}


