<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\FoodMenu;
use App\Models\ShoppingItem;
use App\Models\MenuCategory;
use DB;

class menuCategoriesController extends Controller
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

     

    // メニュー確定画面
    public function getMenuCatagories(Request $request,$id) //確認済み
    {
        $menuCategories = MenuCategory::select("id","name")->get();

        return $menuCategories;
    }

    public function addMenuCategory(Request $request) //確認済み
    {
      $posts = $request->all();
      if(MenuCategory::where("user_id","=",$posts["userId"])->where("name","=",$posts["category"])->exists()){
          return "登録済み";
      }else{
        MenuCategory::create([
          "name" => $posts["category"],
          "user_id"=>$posts["userId"]
      ]);
      }
      
      return "成功";
    }
    public function menuCategoryEdit(Request $request) //確認済み
    {
      $posts = $request->all();
      foreach($posts["editCategories"] as $category ){
          if(MenuCategory::where("id","=",$category["id"])->where("name","=",$category["name"])->exists()===false){
            MenuCategory::where("id","=",$category["id"])->update([
                  "name"=>$category["name"]
              ]);
          } 
      }
      return ;
    }
    public function menuCategoryDelete(Request $request) //確認済み
    {
      $posts = $request->all();
      if(Menu::where("user_id","=",$posts["userId"])->where("category_id","=",$posts["categoryId"])->exists()){
        Menu::where("user_id","=",$posts["userId"])->where("category_id","=",$posts["categoryId"])->update([
        "category_id"=>null
        ]);
    }
    
    MenuCategory::where("id","=",$posts["categoryId"])->delete();
    return ;
    }
}