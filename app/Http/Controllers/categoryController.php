<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use DB;

class categoryController extends Controller
{
  

     //食材画面
    public function addCategory(Request $request)
    {
        $posts = $request->all();
        if(Category::where("user_id","=",$posts["userId"])->where("name","=",$posts["category"])->exists()){
            return "登録済み";
        }else{
            Category::create([
            "name" => $posts["category"],
            "user_id"=>$posts["userId"]
        ]);
        }
        
        return "成功";
    }
    public function category(Request $request,$id)
    {
        $categories = Category::select("categories.id","categories.name")->where("user_id","=",$id)->orderby("id","ASC")->get();
 
        return response()->json([
            "categories" => $categories,
        ],
        200,
        [],
        JSON_UNESCAPED_UNICODE //文字化け対策
        );

    }
    public function categoryEdit(Request $request)
    {

        $posts = $request->all();

        foreach($posts["editCategories"] as $category ){
            if(Category::where("id","=",$category["id"])->where("name","=",$category["name"])->exists()===false){
                Category::where("id","=",$category["id"])->update([
                    "name"=>$category["name"]
                ]);
                return $category["name"];
            } 
        }
        return ;
      

    }
}