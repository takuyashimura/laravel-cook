<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\FoodMenu;
use App\Models\User;
use App\Models\ShoppingItem;
use App\Models\Text;
use DB;

class buyController extends Controller
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

     

   
    public function add_buy_list(Request $request)//済み
    {
        $posts = $request->all();
        $food = $posts["choiceMenu"][0];
        $userId = $posts["userId"];

        foreach($food as $f){
            if(ShoppingItem::select("shopping_items.*")->whereNull("deleted_at")->where("user_id","=",$userId)->where("food_id",'='.$f["food_id"])->exists()){
                ShoppingItem::whereNull("deleted_at")->where("food_id",'='.$f["food_id"])->increment("amount",$f["food_amount"]);
            }else{
                ShoppingItem::create([
                    "food_id"=> $f['food_id'],
                    "amount"=> $f["food_amount"],
                    "user_id"=>$userId
                ]);
            }
        }
        return "購入リストへ追加完了";

        
        }

    

    public function buy_list(Request $request,$id) //済み
    {
        $shopping_items = ShoppingItem::whereNull("shopping_items.deleted_at")
        ->where("shopping_items.amount","!=",0)
        ->where("shopping_items.user_id","=",$id)
        ->leftjoin("food","shopping_items.food_id" ,"=" ,"food.id")
        ->select("shopping_items.food_id","food.name")
        ->selectRaw('SUM(amount) AS total_amount')
        ->groupBy("shopping_items.food_id","food.name")
        ->get();
       
        $texts = Text::select("texts.text")
        ->where("user_id" , "=" , $id)
        ->get();

        
        return response()->json([
            "shopping_items"=>$shopping_items,
            "texts"=>$texts
        ],
        200,
        [],
        JSON_UNESCAPED_UNICODE //文字化け対策
        );


    }

    
    public function edit_buy_list(Request $request,$id)//済み
    {
        //
        $shopping_items = ShoppingItem::where("user_id","=",$id)
        ->select("food_id")
        ->selectRaw('SUM(amount) AS total_amount')
        ->groupBy('food_id')
        ->whereNull("deleted_at")
        ->get();

        $shopping_item = ShoppingItem::whereNull("shopping_items.deleted_at")
        ->where("shopping_items.user_id","=",$id)
        ->leftjoin("food","shopping_items.food_id" ,"=" ,"food.id")
        ->select("shopping_items.food_id","food.name","shopping_items.amount")
        ->get();

        

        $food = Food::select('food.*')
        ->whereNull("deleted_at")
        ->where('user_id', '=' ,$id)
        ->orderby('created_at','DESC')
        ->get();

        //$shopping_lists内にない食材を抽出するために
        // $foodのidの配列を取得し
        $foods_id = $food
        ->pluck('id')
        ->toArray();
        // $shopping_listsのfood_idの配列を取得し
        $shopping_items_food_id = $shopping_items
        ->pluck("food_id")
        ->toArray();
        // array_diffで重複していない＝$shopping_listsにない食材のidのみの配列を作成する
        $non_food = array_diff($foods_id,$shopping_items_food_id);

        $nonFood=[];
        foreach($non_food as $id){
            $nonFood[] = Food::select("food.name","food.id")
            ->whereNull("deleted_at")
            // ->where("user_id" ,"=" \Auth::id()
            ->where("id",'=',$id)
            ->get(); 
        }

        return response()->json([
            "shopping_item"=>$shopping_item,            
            "food"=>$food,            
            "nonFood"=>$nonFood,            
        ],
        200,
        [],
        JSON_UNESCAPED_UNICODE //文字化け対策
        );
        // dd($non_food);

    }

    public function reply_buy_list(Request $request)
    {
        $posts= $request->all();
     
        foreach($posts["nonFood"] as $i ){
            if($i["amount"]>0){
                ShoppingItem::create([
                    "user_id" => $posts["userId"],
                    "food_id" => $i["id"],
                    "name" => $i["name"],
                    'amount' => $i["amount"]
                ]);
            }
        }

            


        return $posts;


    }

    public function reply_buy_list1(Request $request){

        $posts = $request ->all();
        // return $posts;

        $count = 0;

        foreach($posts["upDataShoppingItems"] as $post){
            $data=ShoppingItem::whereNull("deleted_at")
            ->where("food_id","=",$post["food_id"])
            ->get("amount");

            if($post["total_amount"]===0){
                ShoppingItem::whereNull("deleted_at")->where("food_id","=",$post["food_id"])->delete();
                $count ++;
                continue;
            }

       

            if($data[0]["amount"] != $post["total_amount"]){
                ShoppingItem::whereNull("deleted_at")->where("food_id","=",$post["food_id"])->update([
                    "amount" => $post["total_amount"]
                ]);
           
            }

        }
        
        if($count>0){
            return 0;
        }

        return $posts;

    }
    
   
   
}