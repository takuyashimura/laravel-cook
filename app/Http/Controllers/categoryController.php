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
}