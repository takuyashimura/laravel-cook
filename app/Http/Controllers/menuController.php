<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use DB;

class menuController extends Controller
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

     

     //メニュー画面 メニューコントローラを作成し追加する
     public function menu()
     {
         //ここでメニュー名を取得
         $menus= Menu::orderby('created_at','DESC')
         ->get();
 
 
         // ここの処理はメンタリング時にindexに記載したもの
         // $menus = User::find(1)->get();
         // dd($menus);
         // $user = Menu::find(1)->user;
         // dd($user);
         
 
         return view('menu',compact('menus'));
     }
}


