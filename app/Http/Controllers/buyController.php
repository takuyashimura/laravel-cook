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
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     

    // 食材購入画面
    public function buy()
    {
        $food = Food::select('food.*')
        ->orderby('created_at','DESC')
        ->get()
        ->keyby('id');
        $food_array = $food->pluck('id')->toArray();

        $stocks = Stock::select('food_id')
        ->selectRaw('SUM(amount) AS total_amount')
        ->groupBy('food_id')
        ->get();
        $stocks_array = $stocks->pluck('food_id')->toArray();
        
        $array= array_diff($food_array,$stocks_array);


        return view('buy',compact('food','stocks','array'));  
    }
    public function add_buy_list(Request $request)
    {
        $posts = $request->all();

        $menu_id = $posts["menu_id"];

        $food = Food::select('food.*')
        ->orderby('created_at','DESC')
        ->get()
        ->keyby("id");

         // food_menusテーブルのfood_idを取得
        $food_menus = FoodMenu::select("food_menus.*")
        ->where("menu_id", "=" , $menu_id)
        ->orderby('food_id','DESC')
        ->get();
 
        // stocksテーブルを取得。amountを合計し、キーをfood_idに指定した配列作成した
        $stocks = Stock::select('food_id')
        ->selectRaw('SUM(amount) AS total_amount')
        ->groupBy('food_id')
        ->get()
        ->keyby("food_id");


        $shopping_items=ShoppingItem::select("shopping_items.*")
        ->whereNull("deleted_at")
        ->get()
        ->keyby("food_id");

        $shopping_item=$shopping_items
        ->pluck("food_id")
        ->toArray();
        // dd($shopping_items);
        
        foreach($food_menus as $food_menu){
            //もし$stocks[$food_menu->food_id]で値が返ってきたら→在庫の登録があれば
            if(isset($stocks[$food_menu->food_id])){
                  //もし$stocksテーブルにメニューで使用する食材のデータがないか、在庫数よりメニューに使用する食材の方が多い＝在庫不足なら
                if($stocks[$food_menu->food_id]["total_amoumt"]< $food_menu->food_amount){
                    //$food[$food_menu->food_id]['id']の配列内に$shppping_itemがあれば
                    if(in_array($food[$food_menu->food_id]['id'], $shopping_item)){
                        //$food_amount＝メニューに使うその食材の総数ーその食材の在庫数＝不足数
                        $food_amount=$food_menu->food_amount - $stocks[$food_menu->food_id]["total_amoumt"];
                        ShoppingItem::where("food_id", "=", $food[$food_menu->food_id]['id'])
                        ->update([                        
                            "amount" => $shopping_items[$food_menu->food_id]->amount += $food_amount
                        ]);
                    }
                    else{ 
                        ShoppingItem::create([
                        'user_id' => \Auth::id(),
                        'food_id' => $food[$food_menu->food_id]->id,
                        "amount" => $food_menu->food_amount - $stocks[$food_menu->food_id]["total_amoumt"]
                        ]);
                    }
                    }
                else{
                    continue;
                }
            //在庫の登録がなければ
            }else{
                //$food[$food_menu->food_id]['id']の配列内に$shppping_itemがあれば
                if(in_array($food[$food_menu->food_id]['id'], $shopping_item)){
                    ShoppingItem::where("food_id", "=", $food[$food_menu->food_id]['id'])
                        ->update([                        
                            "amount" => $shopping_items[$food_menu->food_id]->amount += $food_menu->food_amount
                        ]);
                }else{ 
                    ShoppingItem::create([
                    'user_id' => \Auth::id(),
                    'food_id' => $food[$food_menu->food_id]->id,
                    "amount" => $food_menu->food_amount
                    ]);

                }

            }
        }

        return redirect()->route('buy_list');
    }

    public function buy_list()
    {
        $shopping_items = ShoppingItem::select("food_id")
        ->selectRaw('SUM(amount) AS total_amount')
        ->whereNull("deleted_at")
        ->groupBy('food_id')
        ->get();
       

        $food = Food::select('food.*')
        ->where('user_id', '=' , \Auth::id())
        ->orderby('created_at','DESC')
        ->get()
        ->keyby("id");

        $texts = Text::select("texts.*")
        ->where("user_id" , "=" , \Auth::id())
        ->orderby("created_at","DESC") 
        ->get()
        ->toArray();

        return view('add_buy_list',compact("shopping_items","food","texts",));  
    }

    
    public function edit_buy_list()
    {
        $shopping_items = ShoppingItem::select("food_id")
        ->selectRaw('SUM(amount) AS total_amount')
        ->groupBy('food_id')
        ->whereNull("deleted_at")
        ->get();

        $food = Food::select('food.*')
        ->where('user_id', '=' , \Auth::id())
        ->orderby('created_at','DESC')
        ->get()
        ->keyby("id");

        //$shopping_lists内にない食材を抽出するために
        // $foodのidの配列を取得し
        $foods_id = Food::select("id")
        ->whereNull("deleted_at")
        ->orderby("id","DESC")
        ->get()
        ->pluck('id')
        ->toArray();
            // dd($foods_id);
        // $shopping_listsのfood_idの配列を取得し
        $shopping_items_food_id = ShoppingItem::select("food_id")
        ->whereNull("deleted_at")
        ->orderby("food_id","DESC")
        ->get()
        ->pluck("food_id")
        ->toArray();
            // dd($shopping_items_food_id);
        // array_diffで重複していない＝$shopping_listsにない食材のidのみの配列を作成する
        $food_non = array_diff($foods_id,$shopping_items_food_id);
        // dd($food_non);

        return view('edit_buy_list',compact("shopping_items","food","food_non"));
    }

    public function reply_buy_list(Request $request)
    {
        $posts= $request->all();
        $post = array_filter($posts, function($key) {
            return is_int($key);
        }, ARRAY_FILTER_USE_KEY);
        // dd($post);
        // dd($posts);
        //if文で$shopping_itemsにないfood_idの食材は新しくDBをcreateするコーディングをする
        $shopping_items = ShoppingItem::select("food_id")
        ->where("user_id","=",\Auth::id())
        ->whereNull("deleted_at")
        ->get()
        ->pluck("food_id")
        ->toArray();
        // dd($shopping_items);
        
        // dd($non_shoppning_items);

        foreach($post as $key => $value){
            // もしshopping_itemのfood_idに$keyがあれば
            if(in_array($key,$shopping_items) && $value != 0){
                ShoppingItem::where("food_id", "=", $key)
                ->update([
                    "amount" => $value
                ]);
            // なければ
            }elseif($value == 0){
                ShoppingItem::where("food_id","=", $key)
                ->update([
                    "deleted_at" => now()
                ]);
            }
            else{
                ShoppingItem::create([
                    "user_id"=>\Auth::id(),
                    "food_id"=>$key,
                    "amount"=>$value
                ]);
            }

        }
        return redirect(route('buy_list'));  
    }
    
   
   
}