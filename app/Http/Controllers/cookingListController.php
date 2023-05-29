<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\CookingList;

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
        ->orderby("cooking_lists.menu_id","DESC");

        $stocks = Stock::select("food_id")
        ->where("user_id","=",$id)
        ->whereNull("deleted_at")
        ->selectRaw('SUM(amount) AS total_amount')
        ->groupBy('food_id')
        ->orderby("food_id","DESC")
        ->get()
        ->keyby("food_id");
        
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

        $cooking_list_food_data = $cooking_list_food_array
        ->get()
        ->keyby("food_id");

        $cooking_list_food_name=$cooking_list_food_array
        ->select("food_menus.food_id","food.name")
        ->get()
        ->keyby("food_id");

        // 使用食材と個数 (total_amountがeloquentのselectで取得できないため) ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        $cooking_list_food_name_amount=[];
        foreach($cooking_list_food_data as $i){
            if($i["total_amount"] !== null)
            $cooking_list_food_name_amount[]=[
                "id"=>$i["food_id"],
                "food_name"=>$cooking_list_food_name[$i["food_id"]]["name"],
                "amount"=>$i["total_amount"]
            ];
        }
        
        // ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
     
        // cooking_listにあるメニューで使用する食材がstocksテーブルにあるか判断する↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        $stocks_id = $stocks->pluck("food_id")->toArray();
        $cooking_list_food_data_id = $cooking_list_food_data->pluck("food_id")->toArray();
            // stockテーブルにある食材
            $on_stocks_id_data=array_intersect($stocks_id,$cooking_list_food_data_id);
            // stocksテーブルにない食材
            $non_stocks_id_data = array_diff($cooking_list_food_data_id,$stocks_id);
        
        // ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
        //不足食材名とその数量（stocksテーブルにない）↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        $non_stocks_data =[];
        foreach($non_stocks_id_data as $id){
            if($cooking_list_food_data[$id]->total_amount !== null)
            $non_stocks_data []= [
                "id"=>$id,
                "food_name"=>$cooking_list_food_name[$id]->name,
                "amount"=>$cooking_list_food_data[$id]->total_amount
            ];
        }
        // dd($non_stocks_data);
        // ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

        //不足食材名とその数量（stocksテーブルにある）↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        $on_stocks_data=[];
        foreach($on_stocks_id_data as $id){
            if($stocks[$id]["total_amount"] < $cooking_list_food_data[$id]["total_amount"])
            $on_stocks_data []=[
                "id"=>$id,
                "food_name"=>$cooking_list_food_name[$id]->name,
                "amount"=>$cooking_list_food_data[$id]->total_amount - $stocks[$id]["total_amount"]
            ];
        }        
        //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

        //作るメニューと数量とメニューID ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        $cooking_list_menu_ids = $cooking_list->select("menu_id","name")->get()->toArray();
        $cooking_list_name_array = $cooking_list->get()->pluck("name")->toArray();
        $cooking_list_menu_id = array_unique($cooking_list_menu_ids,SORT_REGULAR);

        $how_many_food=array_count_values($cooking_list_name_array);        

        $cooking_list_name_counts=[];
        foreach($how_many_food as $key => $value){
            foreach($cooking_list_menu_id as $i)
            if($i["name"] === $key)
            $cooking_list_name_counts []=[
                "name"=> $key,
                "count"=>$value,
                "menu_id"=>$i["menu_id"]
            ];
        } 
        // ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
        
        
        
        return response()->json([
            "cooking_list_name_counts"=>$cooking_list_name_counts,//作るメニューと数量とメニューID
            "non_stocks_data"=>$non_stocks_data,//不足食材名とその数量（stocksテーブルにない）            
            "on_stocks_data"=>$on_stocks_data,//不足食材名とその数量（stocksテーブルにある）            
            "cooking_list_food_name_amount"=>$cooking_list_food_name_amount,//使用食材と個数        
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


    }
    public function editCookingList(Request $request) //済み
    {
        $posts=$request->all();
        $menuId = $posts["upDataNameCount"][0]["menu_id"];
        $userId =$posts["userId"];
        // $count = $posts["upDataNameCount"][0]["count"];
        
        if($posts !== null){ 
            CookingList::where("user_id","=", $userId)->forceDelete();
            foreach($posts["upDataNameCount"] as $post){
            for($i=1;$i<=$post["count"];$i++){
                CookingList::create([
                    "menu_id"=> $post["menu_id"],
                    "user_id"=>$userId 
                ]);
            }
        }
        return "変更完了";
    }

       
        
        

    }

   


}    