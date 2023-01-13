@extends('layouts.app')

@section('content')
        <div class='blue_elea rounded-pill w-25' style='text-align:center'>
        メニュー追加
        </div>
        @foreach ($menus as $menu)
        <div class='blue_elea'>
            <p class='text-center'>{{ $menu['name']}}</p>
            <div class='d-flex justify-content-end'>
                <p class='bg-secondary text-white' style='margin:0px 5px 0px'>削除</p>
                <p class='bg-secondary text-white' style='margin:0px 5px 0px'>調理</p>
                <p class='bg-secondary text-white' style='margin:0px 5px 0px'>編集</p>
            </div>
        @endforeach
@endsection
