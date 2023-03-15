<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;


class stockController extends Controller
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
    public function index()
    {
        //ここで食材名を取得する
        $food = Food::select('food.*')
        ->where('user_id', '=' , \Auth::id())
        ->orderby('created_at','DESC')
        ->get();
        $menus = User::find(1)->get();
        
        return view('create' , compact('food'));
    }

    //メニュー画面 メニューコントローラを作成し追加する
    public function menu()
    {
        //ここでメニュー名を取得
        $menus= Menu::select('menus.*')
        ->where('user_id' , '=' , \Auth::id())
        ->whereNull('deleted_at')
        ->orderby('created_at','DESC')
        ->get();
        

        return view('menu',compact('menus'));
    }
    //メニュー画面 フードコントローラーを作成し追加する
    public function add_food()
    {
       return view('add_food');  
    }
    //食材を追加した時の処理
    public function add(Request $request)
    {
        $post =$request->all();
        dd($post);

        $foods = Food::select('food.*')
        ->whereNull('deleted_at')
        ->orderby('id','DESC')
        ->get();

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


        $posts=$request->all();

        $food_names=Food::select("food.*")
        ->where('user_id','=',\Auth::id())
        ->whereNull("deleted_at")
        ->orderby("id")
        ->get()
        ->keyby("name");
        $food_name=$food_names->pluck("name")->toArray();

        if(in_array($posts["name"],$food_name) || $posts["name"] ==NULL){
            // 今はホーム画面に戻ってしまうが、add_food画面に戻るようにする
            return view('create' ,compact('food','stocks','array'));
        }else{
        Food::create([
            'name' => $posts['name'] ,
            'user_id' => \Auth::id()
        ]);
            if(isset($posts['amount'])){
                Stock::create([
                    "food_id" => $food[$posts['name']]->id,
                    "user_id" => \Auth::id(),
                    "amount" => $posts["amount"]
                ]);
            }
        }
        return redirect( route('home') );  
    }

}