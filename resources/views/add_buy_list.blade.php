@extends('layouts.finely')

@section('content')
<div>
    <p>購入リスト</p>
    @foreach($shopping_items as $shopping_item)
    <div class="blue_elea d-flex justify-content-between">
        <p>{{$food[$shopping_item->food_id]->name}}</p>
        <p>{{$shopping_item->total_amount}}</p>
    </div>
    @endforeach
    <div>
        <a href="{{route('edit_buy_list')}}">購入する食材を編集する</a>
        <input type="submit" value="購入する">
    </div>
</div>

@endsection

