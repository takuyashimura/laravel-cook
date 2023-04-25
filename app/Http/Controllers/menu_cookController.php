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

class menu_cookController extends Controller
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

     

    // メニュー確定画面
    public function menu_cook(Request $request) //確認済み
    {
        $posts = $request->all();

        // 使用する材料
        $menu_food_data = FoodMenu::whereNull("food_menus.deleted_at")
        ->where("food_menus.menu_id" ,"=",$posts['menu']['id'])
        ->leftjoin("food","food_menus.food_id",'=','food.id')
        ->select('food.name',"food_menus.food_id","food_menus.food_amount")
        ->get();
        // return $menu_food_data;

        $stocks = Stock::select('food_id')
        ->selectRaw('SUM(amount) AS total_amount')
        ->groupBy('food_id')
        ->get()
        ->keyby("food_id");
       

        $post_data=[];

        foreach($menu_food_data as $i){
            // return $i;
            if(Stock::select("stocks.food_id")->whereNull("deleted_at")->where("food_id",'=',$i['food_id'])->exists() !== true){
                // return $i;
                 $post_data [] = $i;
                //  return $post_data;
            }else{
                // return $i["food_amount"];
                if($i["food_amount"]>$stocks[$i["food_id"]]["total_amount"]){
                    $post_data[] = [
                    "name"=>$i["name"],
                    "food_id"=>$i["food_id"],
                    "food_amount"=>$i["food_amount"]-$stocks[$i["food_id"]]["total_amount"]
                ];
            }

            }
        }


        return [$post_data,$posts ['menu'], $menu_food_data];
        // ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑



  }
}