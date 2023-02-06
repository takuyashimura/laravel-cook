@extends('layouts.finely')

@section('content')
    <div>

        @foreach($stocks as $stock) 
            <div class='blue_elea d-flex justify-content-between '>
                <p>{{ $food[$stock->food_id]->name }}</p>
                <p>{{ $stock['total_amount'] }}</p>
                <input type="number" name='amount' min='0' max='100'>
            </div>
        @endforeach 
        {{$array = $stocks->pluck('food_id')}}
        @foreach($food as $food)
        @if(in_array((array)$food["id"] ,(array)$food["id"])))
                @continue
            @else
                <p>{{ $food->id }}</p>
            @endif
        @endforeach
      
    </div>
        <div class='text-center'>
                <button  type='submit'>新しい食材を<br>追加</button>
        </div>
@endsection
