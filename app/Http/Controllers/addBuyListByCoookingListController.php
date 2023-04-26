<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\FoodMenu;
use App\Models\ShoppingItem;
use DB;

class addBuyListByCoookingListController extends Controller
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


    public function addBuyListByCoookingList(Request $request)//済み
    {
        $posts=$request->all();

        $post=[];
        //配列を１次元にする
        foreach($posts["toBuyList"] as $I){
            foreach($I as $i)
            $post [] = [
                "id"=> $i["id"],
                "name"=> $i["food_name"],
                "amount"=> $i['amount']
            ];
        }   
        foreach($post as $i){
            if(ShoppingItem::select("shopping_items.*")->whereNull("deleted_at")->where("user_id","=",$posts["userId"])
                ->where("food_id","=",$i["id"])->exists()){
                    ShoppingItem::where("food_id","=",$i["id"])
                    ->increment("amount",$i["amount"]);
            }else{
                ShoppingItem::create([
                    "user_id"=>$posts["userId"],
                    "food_id"=>$i["id"],
                    "amount"=>$i["amount"]
                ]);
            }
            
        }
        return "登録できたよ";
      
      

       
    }
}