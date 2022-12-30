@extends('layouts.app')

@section('content')
    <div>
        <div class='blue_elea' style='text-align:center rounded-pill'>新しい食材を<br>追加</div>
        @foreach($food as $food)
            <div class='blue_elea'>
                <a href="">
                    <p>
                        {{ $food['name']}}
                    </p>
                </a>
                <a href="">
                    <p>
                        在庫数
                    </p>
                </a>
            </div>
        @endforeach
        <!-- <div class='blue_elea'>食材名</div>
        <div class='blue_elea'>食材名</div>
        <div class='blue_elea'>メロン</div> -->
    </div>
@endsection
