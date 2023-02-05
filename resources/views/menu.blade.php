@extends('layouts.app')

@section('content')
        <div class='blue_elea rounded-pill w-25' style='text-align:center'>
        <a href="http://localhost:8888/add_menu">
            メニュー追加
        </a>
        </div>
        @foreach ($menus as $menu)
        <div class='blue_elea mt-1'>
            <a href="{{ route('menu_cook', $menu_id = $menu['id']) }}">
                
                 <p class='text-center'>{{ $menu['name']}}</p><!--ここで表示される食材名を次のページに受け渡したい -->
            </a>    
            
            <div class='d-flex justify-content-end'>
                <p class='bg-secondary text-white' style='margin:0px 5px 0px'>削除</p>
                <p class='bg-secondary text-white' style='margin:0px 5px 0px'>編集</p>
            </div>
        </div>
        @endforeach
@endsection
