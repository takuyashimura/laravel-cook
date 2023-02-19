@extends('layouts.app')

@section('content')

   @foreach($cooking_lists as $cooking_list)
      <div class='blue_elea ' >   
         <p>メニュー名→{{$menus[$cooking_list->menu_id]->name}}</p>
         <p>削除</p>
      </div>
   @endforeach
@endsection
