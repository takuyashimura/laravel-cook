<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\CookingList;
use App\Models\FoodMenu;
use DB;

class cookingListController extends Controller
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
    public function cooking_list(Request $request,$id) //済み
    {
        $cooking_list = CookingList::whereNull("cooking_lists.deleted_at")
        ->where("cooking_lists.user_id","=",$id)
        ->leftjoin("menus","cooking_lists.menu_id" ,"=", "menus.id")
        ->select("menus.id","menus.name","cooking_lists.id")
        ->orderby("cooking_lists.id","DESC")
        ->get();
        // return $cooking_list;

        $stocks = Stock::select("food_id")
        ->where("user_id","=",$id)
        ->whereNull("deleted_at")
        ->selectRaw('SUM(amount) AS total_amount')
        ->groupBy('food_id')
        ->orderby("food_id","DESC")
        ->get()
        ->keyby("food_id");
        // return $stocks;
        
        $cooking_list_food_array =CookingList::whereNull("cooking_lists.deleted_at")
        ->where("cooking_lists.user_id","=",$id)
        ->leftjoin("food_menus","cooking_lists.menu_id" ,"=", "food_menus.menu_id")
        ->leftjoin("food","food_menus.food_id","=","food.id")
        ->select("food_menus.menu_id","food_menus.food_id","cooking_lists.id","food_menus.deleted_at","food_menus.food_amount","food.name")
        ->whereNull("food_menus.deleted_at")
        ->select("food_menus.food_id")
        ->selectRaw('SUM(food_menus.food_amount) AS total_amount')
        ->groupBy('food_menus.food_id')
        ->orderby("food_menus.food_id","DESC");
        // return $cooking_list_food_array;

        $cooking_list_food_data = $cooking_list_food_array
        ->get()
        ->keyby("food_id");
        // return $cooking_list_food_data;

        $cooking_list_food_name=$cooking_list_food_array
        ->select("food_menus.food_id","food.name")
        ->get()
        ->keyby("food_id");

        // cooking_listで使う食材の名前、数量を取得し、表示する  →  DBを作成した方がいいか↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        $cooking_list_food_name_amount=[];
        foreach($cooking_list_food_data as $i){
            $cooking_list_food_name_amount[]=[
                "id"=>$i["food_id"],
                "food_name"=>$cooking_list_food_name[$i["food_id"]]["name"],
                "amount"=>$i["total_amount"]
            ];
        }
        // ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
     
        // cooking_listにあるメニューで使用する食材がstocksテーブルにあるか判断する↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        $stocks_id = $stocks->pluck("food_id")->toArray();
        // dd($stocks_id);
        $cooking_list_food_data_id = $cooking_list_food_data->pluck("food_id")->toArray();
        // dd($cooking_list_food_data_id);
            // stockテーブルにある食材
        $on_stocks_id_data=array_intersect($stocks_id,$cooking_list_food_data_id);
            // stocksテーブルにない食材
        $non_stocks_id_data = array_diff($cooking_list_food_data_id,$stocks_id);
      
        // ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
        //stocksテーブルにデータのない食材の不足分を描画する配列を作成↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        $non_stocks_data =[];
        foreach($non_stocks_id_data as $id){
            $non_stocks_data []= [
                "id"=>$id,
                "food_name"=>$cooking_list_food_name[$id]->name,
                "amount"=>$cooking_list_food_data[$id]->total_amount
            ];
        }
        // dd($non_stocks_data);
        // ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

        //stocksテーブルにデータがある食材のうち、在庫不足の食材で配列を作成↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        $on_stocks_data=[];
        foreach($on_stocks_id_data as $id){
            if($stocks[$id]["total_amount"] < $cooking_list_food_data[$id]["total_amount"])
            $on_stocks_data []=[
                "id"=>$id,
                "food_name"=>$cooking_list_food_name[$id]->name,
                "amount"=>$cooking_list_food_data[$id]->total_amount - $stocks[$id]["total_amount"]
            ];
        }
        // dd($on_stocks_data);
        
        //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

        //cooking_listに何人前登録したか調査する ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        $cooking_list_name_array = $cooking_list->pluck('name')->toArray();
        // return $cooking_list_name_array;
        $how_many_food=array_count_values($cooking_list_name_array);
        

        $cooking_list_name_counts=[];
        foreach($how_many_food as $key => $value){
            $cooking_list_name_counts []=[
                "name"=> $key,
                "count"=>$value
            ];
        }
        $cooking_list_name_count = array_unique($cooking_list_name_counts,SORT_REGULAR);
        
        
        // ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
        
        
        
        return response()->json([
            "cooking_list_name_count"=>$cooking_list_name_count,//作るメニューと数量
            "cooking_list"=>$cooking_list,            
            "non_stocks_data"=>$non_stocks_data,            
            "on_stocks_data"=>$on_stocks_data,            
            "cooking_list_food_name_amount"=>$cooking_list_food_name_amount,            
        ],
        200,
        [],
        JSON_UNESCAPED_UNICODE //文字化け対策
        );

       

    }


    public function add_cooking_list(Request $request) //済み
    {
        $posts=$request->all();
       
        Cookinglist::create([
            "menu_id" => $posts["choiceMenu"]["id"],
            "user_id" => $posts["userId"],
        ]);

        return "調理リストへ登録完了";


        return redirect( route('cooking_list') );  
    }

   


}    