@extends('layouts.finely')

@section('content')
    @foreach($food_menus as $food_menu)
        @if(isset($menus["$food_menu->menu_id"]))
            <div class='blue_elea mt-1'>
                <p>{{$menus["$food_menu->menu_id"]->name}}</p>
            </div>
        @else
            @continue
        @endif
    @endforeach
@endsection

