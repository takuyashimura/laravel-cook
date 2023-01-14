@extends('layouts.finely')

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
                <input type="number" name='amount' min='0' max='100'><!--stocksのamountに数字を追加-->
             </div>

        @endforeach
        @foreach($food as $food)
            <div class='blue_elea'>
               <p>{{ $food['name'] }}</p>
            </div>
        @endforeach 
        
        <!-- <div class='blue_elea'>食材名</div>
        <div class='blue_elea'>食材名</div>
        <div class='blue_elea'>メロン</div> -->
    </div>
    <div class='text-center'>
            <button  type='submit'>新しい食材を<br>追加</button>
         </div>
@endsection
