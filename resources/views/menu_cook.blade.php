@extends('layouts.app')

@section('content')
<div class='row'>
    <div class='col-4 border d-flex d-flex align-items-center justify-content-center' style='background-color:powderblue;'>
        メニュー
    </div>
    <div class='col-4 border d-flex d-flex align-items-center justify-content-center' style='background-color:powderblue;'>
        今回使用する<br>食材の編集
    </div>
    <div class='col-4 border d-flex d-flex align-items-center justify-content-center' style='background-color:powderblue;'>
        不足している<br>食材を買い物<br>リストに追加する
    </div>
</div>
<div>
    <div class='row'>
        <div class='col d-flex d-flex align-items-center justify-content-center'>食材名</div>
        <div class='col d-flex d-flex align-items-center justify-content-center'>不足数</div>
    </div>
    <div>
        不足している食材が羅列される
    </div>
</div>
<div>
@foreach($menus as $menu)
    <div class='row blue_elea mt-1'>
        <div class='col '>
                <p>{{$menu->name}} </p> 
        </div>
        <div class='col'>

        </div>
    </div>
    @endforeach 


</div>
@endsection
