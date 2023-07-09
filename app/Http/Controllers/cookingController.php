<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\CookingList;
use App\Models\Foodmenu;
use DB;

class cookingController extends Controller
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
    public function cooking(Request $request)//済み
    {
        $posts = $request->all();

        //調理されたメニューのlast_cook_atカラムに調理した日時を記録
        foreach($posts["nameCount"] as $i){
            Menu::where("id","=",$i["menu_id"])->update([
                "last_cook_at"=>now()
            ]);
        }
        
        CookingList::where("user_id",'=',$posts["userId"])->forceDelete();

        foreach($posts["useList"] as $i){
            $remaining_amount = $i["amount"];
            while($remaining_amount != 0){
               $stock = Stock::whereNull("deleted_at")->where("food_id",'=', $i['id'])->orderby("created_at","ASC")->first();
               // 在庫数を充足して消せた場合の処理
                if(isset($stock)){
                    if($stock["amount"] - $remaining_amount >= 0){
                        $stock->decrement('amount', $remaining_amount);
                        $remaining_amount = 0;
                        // 残り必要な数からストックの数を引いて0より大きい場合処理の継続処理
                    } elseif($remaining_amount - $stock["amount"] > 0) {
                        $remaining_amount = $remaining_amount - $stock["amount"];
                        $stock->forceDelete();
                    }
                }else{
                    break;
                }
            }
        }

        return $posts;

    }
}