@extends('layouts.finely')

@section('content')
    <form action="{{route('reply_buy_list')}}" id="hoge" method="POST">
    @csrf
        @foreach($shopping_items as $shopping_item)
            <div>
                <p>{{$food[$shopping_item->food_id]->name}}</p>
                <input type="number" name="{{$shopping_item->food_id}}"value="{{$shopping_item->total_amount}}">
            </div>
        @endforeach
        <button type="submit" from="hoge">購入リストを修正する</button>
        <a href="">食材を追加する</a>
    </form>
@endsection

