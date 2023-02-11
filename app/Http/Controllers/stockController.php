<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use APP\Models\Stock;
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
        ->where('user_id', '=' , \Auth::id())
        ->orderby('created_at','DESC')
        ->get();
        $menus = User::find(1)->get();
        
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


