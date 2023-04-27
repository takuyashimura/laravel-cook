<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\FoodMenu;
use DB;

class addMenuEditController extends Controller
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
    public function add_menu_edit(Request $request) //確認済み
    {
        $posts = $request->all();
        // return $posts;
        $food_data = $posts['postMenuData'];
        $menu_id =$posts["menuName"]["menu"]["id"];
 

        foreach($food_data as $i){
            if($i['food_amount']!==null){
                if($i['food_amount']===0){
                    FoodMenu::where("menu_id",'=', $menu_id)
                ->where("food_id",'=',$i['id'])
                ->delete();
                }else{              
                if(FoodMenu::where("menu_id",'=', $menu_id)
                    ->where("food_id",'=', $i['id'])->exists()){
                    FoodMenu::where("menu_id",'=', $menu_id)
                    ->where("food_id",'=', $i['id'])
                    ->update([
                        "food_amount"=>$i['food_amount']
                    ]);
                }else{
                    FoodMenu::create([
                        "food_id"=>$i['id'],
                        "food_amount"=>$i['food_amount'],
                        "menu_id"=>$menu_id
                    ]);
                }
                    
            }
                
            }
        }

        return "編集完了";

    }
    
}