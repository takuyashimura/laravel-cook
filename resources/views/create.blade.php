@extends('layouts.app')

@section('content')
    <div>
        <div class='blue_elea' style='text-align:center rounded-pill'>新しい食材を<br>追加</div>
        @foreach($food as $food)
            @foreach($food -> stocks as $stock)
            
                <div class='blue_elea '>
                    <!-- 食材名をクリックするとその食材を使用するメニューを表示したい -->
                     <a class="d-flex justify-content-between" href=""> 
                        <p>
                            {{ $food['name']}}
                        </p>
                        
                        <p>
                            {{ $stock->amount }}
                        </p>
                        <!-- stocksにデータがなかった場合、在庫数０と表記するコードを書く -->
                    </a>
                </div>
            @endforeach
        @endforeach

    </div>
@endsection
