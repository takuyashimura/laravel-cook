<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\CookingList;
use DB;

class cookingListController extends Controller
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

     //食材画面
    public function cooking_list()
    {
        $cooking_lists = CookingList::select("cooking_lists.*")
        ->orderby("created_at")
        ->get();
        dd($cooking_lists);

        return view('cooking_list',compact("cooking_lists"));
    }
    public function add_cooking_list(Request $request)
    {
        $posts=$request->all();
        $menu_id = $posts["menu"];

        Cookinglist::create([
            "menu_id" => $menu_id,
            "user_id" => \Auth::id(),
        ]);


        return redirect( route('cooking_list') );  
    }

   


}    