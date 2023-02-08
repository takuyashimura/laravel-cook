@extends('layouts.app')

@section('content')
<div class='row'>
    <div class='col-4 border d-flex d-flex align-items-center justify-content-center' style='background-color:powderblue;'>
       <p>{{$menu_name['name']}}</p> 
    </div>
    <div class='col-4 border d-flex d-flex align-items-center justify-content-center' style='background-color:powderblue;'>
        今回使用する<br>食材の編集
    </div>
    <div class='col-4 border d-flex d-flex align-items-center justify-content-center' style='background-color:powderblue;'>
        不足している<br>食材を買い物<br>リストに追加する
    </div>
</div>

@csrf
<div>
    <div class='row'>
        <div class='col d-flex d-flex align-items-center justify-content-center'>食材名</div>
        <div class='col d-flex d-flex align-items-center justify-content-center'>不足数</div>
    </div>
    <div>
    <p>不足している食材</p>    
    @foreach($food_menus as $food_menu)
    <form action="http://localhost:8888/cooking_lists" id="hoge" method='POST'>
        @csrf
        @if($stocks[$food_menu->food_id]["total_amount"] < $food_menu->food_amount)
            <div class='row bg-danger mt-1'>
                <div class='col '>
                        <p>{{$food[$food_menu->food_id]["name"]}}</p> 
                        <p>不足数{{$food_menu->food_amount - $stocks[$food_menu->food_id]["total_amount"]}}</p>
                </div>
            </div>
            <input type="hidden" name="{{$food[$food_menu->food_id]['name']}}_name" value="{{$food[$food_menu->food_id]['name']}}">
            <input type="hidden" name="{{$food_menu->food_amount - $stocks[$food_menu->food_id]['total_amount']}}_amount" class="form-control"  value="{{$food_menu->food_amount - $stocks[$food_menu->food_id]['total_amount']}}">
            @else
            @continue
        @endif
        
    </form>
        <div>
        <button type="submit" form="hoge">不足分を購入リストへ</button>
        </div>
    @endforeach


    </div>
</div>
---------
<div>
    <p>在庫のある食材</p>
    @foreach($food_menus as $food_menu)
        @if($stocks[$food_menu->food_id]["total_amount"] > $food_menu->food_amount)
            <div class='row blue_elea mt-1'>
                <div class='col '>
                        <p>{{$food[$food_menu->food_id]["name"]}}</p> 
                        <p>在庫数{{$stocks[$food_menu->food_id]["total_amount"]}}</p>
                        <p>使用数{{$food_menu->food_amount}}</p>
                </div>
            </div>
        @else
            @continue
        @endif
    @endforeach
    <div>調理リストへ</div>
</div>
@endsection
