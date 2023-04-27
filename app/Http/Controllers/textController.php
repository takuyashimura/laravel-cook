<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\Text;
use DB;

class textController extends Controller
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
    public function text(Request $request)
    {
        $posts=$request->all();
        
        if(Text::where("user_id","=",$posts["userId"])->exists()){
            if($posts["text"] ===null){
                Text::where("user_id" ,"=", $posts["userId"])
                ->update([
                    "text" =>""
                ]);  
            }else{
                Text::where("user_id", "=", $posts["userId"])
                ->update([
                "text" =>$posts["text"]
                ]);
            }
            return "textを更新しました";
        }else{
            Text::create([
                "user_id" => $posts["userId"],
                "text" => $posts["text"]
            ]);
            return "textを保存しました。";
        }


    }
}