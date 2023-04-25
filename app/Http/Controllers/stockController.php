<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;


class stockController extends Controller
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

    //食材を追加した時の処理
    public function add(Request $request) //確認済み
    {
        $post =$request->all();
        $foodName = $post[0];

        $food =Food::whereNUll("deleted_at")->where("name", "=", $foodName)->exists();
        if ($food === false) {
            Food::create([
                "user_id"=>1,
                "name"=>$foodName
                ])
            ->save();
            return "登録完了";
        } else {
            return "この食材はすでに登録されています。";
        }
    }
}



       