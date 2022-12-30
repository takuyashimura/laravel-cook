@extends('layouts.app')

@section('content')
        <div class='blue_elea rounded-pill w-25' style='text-align:center'>
        メニュー追加
        </div>
        @foreach ($menus as $menu)
        <div class='blue_elea'>
            <p class='text-center'>{{ $menu['name']}}</p>
            <div class='d-flex justify-content-end'>
                <p>削除</p>
                <p>調理</p>
                <p>編集</p>
            </div>
        @endforeach
        <!-- </div>
        <div class='blue_elea d-flex justify-content-between'>
            <div>メニュー名</div>
            <div>在庫数</div>
        </div>        
        <div class='blue_elea d-flex justify-content-between'>
            <div>メニュー名</div>
            <div>在庫数</div>
        </div>
        <div class='blue_elea d-flex justify-content-between'>
            <div>メニュー名</div>
            <div>在庫数</div>
        </div> -->
@endsection
