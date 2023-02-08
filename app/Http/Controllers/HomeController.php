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
    public function home()
    {
        //ここで食材名を取得する
        $foods = Food::select('food.*')
        ->whereNull('deleted_at')
        ->orderby('created_at','DESC')
        ->get();

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
        


        return view('create' ,compact('food','stocks','array'));
    }

   


    // 食材追加画面→既存の食材以外に新規の食材を追加する時のみ必要→user_idと紐づける食材を作る方向性になってから作成する
    public function add_food()
    {
        $food = Food::select('food.*')
        ->whereNull('deleted_at')
        ->orderby('created_at','DESC')
        ->get();


       return view('add_food');  
    }



    //食材を追加した時の処理
    public function add(Request $request)
    {
        $posts=$request->all();

          
        Food::create(['name' => $posts['name'] ]);
        // Stock::create(['amount' => $posts['amount']]);

        // 食材名に何も記載していなかった際にエラーではなく、画面に止まる処理をするコードを書く

        return redirect( route('home') );  
    }

    

   
}


