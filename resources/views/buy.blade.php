@extends('layouts.finely')

@section('content')
    <div>
       
        <!-- 以下udemy参考コード -->
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
