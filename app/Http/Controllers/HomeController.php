<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;

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
    //メニュー画面 フードコントローラーを作成し追加する
    public function add_food()
    {
       return view('add_food');  
    }
    //食材を追加した時の処理
    public function add(Request $request)
    {
        $posts=$request->all();
        Food::create(['name' => $posts['name'] , 'stock' => $posts['amount'],  'user_id' => \Auth::id()]);
        // 

        return redirect( route('home') );  
    }

    public function menu_cook()
    {
        return view('menu_cook');
    }
}


