<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\FoodMenu;
use App\Models\ShoppingItem;
use App\Models\CookingList;
use DB;

class deleteController extends Controller
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

     
    public function food_menu_food_delet($food_menu_id,$menu_id )
    {

        FoodMenu::select("food_menus.*")
        ->where("id","=",$food_menu_id)
        ->forceDelete();

        //menuテーブルから$menu_idに格納されてる番号がid_のデータを取得
        $menu_name = Menu::find($menu_id);

        //foodテーブルのデータをidをキーとし、配列して取得
        $food = Food::select('food.*')
        ->orderby('created_at','DESC')
        ->get()
        ->keyby("id");


        //名前が表示されてるメニューで使用される食材の使用量を取得
        $food_menus = FoodMenu::select("food_menus.*")
        ->where("menu_id", "=" , $menu_id)
        ->whereNull('deleted_at')
        ->orderby('food_id','DESC')
        ->get();

        $food_menus_amount = FoodMenu::select("food_id")
        ->where("menu_id", "=" , $menu_id)
        ->whereNull('deleted_at')
        ->selectRaw('SUM(food_amount) AS total_amount')
        ->groupBy('food_id')        
        ->get()
        ->keyby("food_id");
        // dd($food_menus_amount);

        // 食材の在庫をキーをfood_idとし、配列にして取得
        $stocks = Stock::select('food_id')
        ->selectRaw('SUM(amount) AS total_amount')
        ->groupBy('food_id')
        ->get()
        ->keyby("food_id");
        // dd($stocks);

        $shopping_items = ShoppingItem::select("shopping_items.*")
        ->get()
        ->keyby("food_id");
        
        return view('menu_cook',compact("menu_name","food_menus","food","food_menus_amount","menu_id"));
    }

    public function menu_delete(Request $request ) //済み
    {
        $posts = $request->all();
        $menu_id = $posts["deleteMenu"]['id'];
        // return $menu_id;
    
         if(FoodMenu::where('menu_id', '=', $menu_id)->exists()) {
            FoodMenu::where('menu_id', '=', $menu_id)
            ->forceDelete();
        }

        if(CookingList::where('menu_id', '=', $menu_id)->exists()) {
            CookingList::where('menu_id', '=', $menu_id)
            ->forceDelete();
        }
        
        Menu::where("id","=",$menu_id)
        ->forceDelete();

       
        return "削除完了";

    }
    
    public function food_delete(Request $request ) //確認済み
    {
        $posts = $request ->all();

        if(Stock::where("food_id","=",$posts["modaldata"]['id'])->exists()){
            Stock::where("food_id","=",$posts["modaldata"]['id'])->forceDelete();
        }
    
        Food::where("id","=",$posts["modaldata"]['id'])
        ->forceDelete();


        return "削除完了";
    }

}