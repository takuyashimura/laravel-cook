<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\FoodMenu;
use DB;

class add_menuController extends Controller
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

     

    // 食材購入画面
    public function add_menu(Request $request , $id) //済み
    {
        $food = Food::select('food.*')
        ->whereNull("deleted_at")
        ->where("user_id","=",$id)
        ->orderby('created_at','DESC')
        ->get();


        
       return response()->json([
        "food" => $food,
        ],
        200,
        [],
        JSON_UNESCAPED_UNICODE //文字化け対策
        );

    }

    public function add_menu_register(Request $request)  //済み
    {
        $posts=$request->all();
        // メニュー名の存在確認
        $exists = Menu::where("name", "=", $posts["postData"][0])
        ->whereNull("deleted_at")
        ->exists();
        $post = $posts["postData"][1];

        if($exists === true){

        return "このメニューは既に登録されています。";

        }else{
            $menu_id = Menu::insertGetId([
                "name" => $posts["postData"][0],
                "user_id" => $posts["userId"]
            ]);
            foreach($post as $value){
                FoodMenu::create([
                    "food_id" => $value["foodId"],
                    "food_amount"=> $value["amount"],
                    "menu_id"=> $menu_id
                ]);
            };
            return"登録完了";
        }

    }
}