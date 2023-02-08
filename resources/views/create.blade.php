@extends('layouts.app')

@section('content')
    <div>
        <div class='blue_elea' style='text-align:center rounded-pill'>新しい食材を<br>追加</div>
        <!-- aタグのhrefを使って食材をクリックするとその食材を使うメニューが表示されるようにする -->
        @foreach($stocks as $stock) 
            <div class='blue_elea d-flex justify-content-between '>
                <p>{{ $food[$stock->food_id]->name }}</p>
                <p>{{ $stock['total_amount'] }}</p>
            </div>
        @endforeach 

        <!-- stocksテーブルにfood_idがない→在庫がないと判断する -->
        @foreach($array as $array)
        <div class='blue_elea d-flex justify-content-between '>
                <p>{{ $food[$array]->name }}</p>
                <p>0</p>
            </div>
        @endforeach
        
        <!-- stocksターブルにidはあるが在庫数が0の時のコーディングをする -->

    </div>
@endsection
