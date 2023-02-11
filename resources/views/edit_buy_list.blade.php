@extends('layouts.finely')

@section('content')
    <form action="{{route('reply_buy_list')}}" method="POST">
    @csrf
        @foreach($shopping_items as $shopping_item)
            <div>
                <p>{{$food[$shopping_item->food_id]->name}}</p>
                <input type="number" name="name"value="{{$shopping_item->total_amount}}">
            </div>
        @endforeach
        <input type="submit" value="購入リストを修正する">
        <a href="">食材を追加する</a>
    </form>
@endsection

