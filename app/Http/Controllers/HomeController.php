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
    public function home()
    {
    //     // ここで食材名を取得する
    //     $foods = Food::select('food.*')
    //         ->whereNull('deleted_at')
    //         ->orderby('id', 'DESC')
    //         ->get()
    //         ->toArray();
    
    //     $food = Food::select('food.*')
    //         ->orderby('created_at', 'DESC')
    //         ->get()
    //         ->keyby('id');
    //     $food_array = $food->pluck('id')->toArray();

    //     $stocks = Stock::select('food_id')
    //         ->selectRaw('SUM(amount) AS total_amount')
    //         ->groupBy('food_id')
    //         ->get();
    //     $stocks_array = $stocks->pluck('food_id')->toArray();

    //     $array = array_diff($food_array, $stocks_array);

    //     return view('create',compact('foods',"food","food_array","food_array","stocks","stocks_array","array"));
    // }



        // // return view('create', compact('food', 'stocks', 'array'));
        // //json形式で渡す
        // return response()->json([
        //     "foods" => $foods,
        //     "food" => $food,
        //     "stocks" => $stocks,
        //     "food_array" => $food_array,
        //     "stocks_array" => $stocks_array,
        //     "array" => $array,
        //     JSON_UNESCAPED_UNICODE //文字化け対策

        // ]);



        return response()->json([
        
                "post" => [
                    [
                        "id" => 1,
                        "title" => "タイトルです",
                        "content" => "投稿内容です投稿内容です投稿内容です投稿内容です投稿内容です。"
                    ],
                    [
                        "id" => 2,
                        "title" => "タイトルです",
                        "content" => "投稿内容です投稿内容です投稿内容です投稿内容です投稿内容です。"
                    ],
                    [
                        "id" => 3,
                        "title" => "タイトルです",
                        "content" => "投稿内容です投稿内容です投稿内容です投稿内容です投稿内容です。"
                    ],
                ]
            ],
            200,
            [],
            JSON_UNESCAPED_UNICODE //文字化け対策
        );
    }
}