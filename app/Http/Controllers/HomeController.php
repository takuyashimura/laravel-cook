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
        $food = Food::select('food.*')
        ->whereNull('deleted_at')
        ->orderby('created_at','DESC')
        ->get();
        // dd($food);

        // stocksの指定したfood_idのamountカラムを合計する
        // $sum = Stock::select('food_id')
        // ->where('food_id' , '=' , '1')
        // ->sum('amount');
        // dd($sum);

        //メンタリング時作成コード
        // $stocks = Food::find(1)->get();
        // dd($stocks);

        // 参考にするコード $test->food = 'amount';  $food = Stock

        return view('create' , compact('food'));
    }

    //メニュー画面 メニューコントローラを作成し追加する
    public function menu()
    {
        //ここでメニュー名を取得
        $menus= Menu::select('menus.*')
        ->where('user_id' , '=' , \Auth::id())
        ->whereNull('deleted_at')
        ->orderby('created_at','DESC')
        ->get();


        // ここの処理はメンタリング時にindexに記載したもの
        // $menus = User::find(1)->get();
        // dd($menus);
        // $user = Menu::find(1)->user;
        // dd($user);
        

        return view('menu',compact('menus'));
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
        // dd($request);
        $posts=$request->all();

        // DB::trasaction(function() use($posts) {
          
        Food::create(['name' => $posts['name'] ]);
        // Stock::create(['amount' => $posts['amount']]);
        // // 

        return redirect( route('home') );  
    }

    public function menu_cook()
    {
        return view('menu_cook');
    }

   
}


