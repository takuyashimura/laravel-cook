<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use APP\Models\Stock;

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
    public function index()
    {
        //ここで食材名を取得する
        $food = Food::select('food.*')
        ->where('user_id', '=' , \Auth::id())
        ->whereNull('deleted_at')
        ->orderby('created_at','DESC')
        ->get();

        //在庫数を取得
        // $stocks= Stock::select('stock.*')
        // ->where('food_id' , '=' , \Food::id())
        

        return view('create' , compact('food'));
    }

    //メニュー画面
    public function menu()
    {
        //ここでメニュー名を取得
        $menus= Menu::select('menus.*')
        ->where('user_id' , '=' , \Auth::id())
        ->whereNull('deleted_at')
        ->orderby('created_at','DESC')
        ->get();
        

        return view('menu',compact('menus'));
    }
    //メニュー画面
    public function add_food()
    {
       return view('add_food');  
    }
    //食材を追加した時の処理
    public function add(Request $request)
    {
        $posts=$request->all();
        Food::insert(['name' => $posts['name'] , 'user_id' => \Auth::id()]);
        Food::insert(['amount' => $posts['stock'], 'user_id' => \Auth::id()]);

        return redirect( route('home') );  
    }


}


