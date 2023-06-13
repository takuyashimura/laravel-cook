<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\Category;
use App\Models\User;


class stockController extends Controller
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

    //食材を追加した時の処理
    public function add(Request $request) //確認済み
    {
        

        $post =$request->all();
        // return $post;
        $foodName = $post["foodData"];
        $userId = $post["userId"];
        $categoryName = $post["postCategory"];

            
        if (Food::whereNUll("deleted_at")->where("name", "=", $foodName)->where("user_id",'=',$userId)->exists()) {
            return "この食材はすでに登録されています。";
        } else {
            if($categoryName=="null"){
                Food::create([
                "user_id"=>$userId,
                "name"=>$foodName,
                ]);
            }else{
                $categoryId = Category::where("user_id",'=',$userId)->where("name","=",$categoryName)->select("categories.id")->get();
                Food::create([
                "user_id"=>$userId,
                "name"=>$foodName,
                "category_id"=>$categoryId[0]["id"]
                ]);

            }
            return "登録完了";            
        }
    }
    public function changeCategory(Request $request) //確認済み
    {

        $post =$request->all();
        if(Food::where("id","=",$post["categoryEditFood"]["id"])->where("category_id","=",$post["value"])->exists() ){
            return "already";
        }
        if($post["value"]==="null"){ Food::where("id","=",$post["categoryEditFood"]["id"])->update([
            "category_id"=>null
        ]);}
        else if($post["value"]!=="null"){ Food::where("id","=",$post["categoryEditFood"]["id"])->update([
            "category_id"=>$post["value"]
        ]);}
       
        return "ok";
        
    }
}