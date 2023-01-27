@extends('layouts.finely')

@section('content')
    <form action="登録ボタンを押した時にメニュー名と使用する食材を登録できるようにする">
    @csrf
        <div>
            <input type="text" name="menu_name" placeholder="登録する食材名">
        </div>
        <div>
            <p>
                使用する食材
            </p>
            @foreach($food as $food)
                <div class="d-flex justify-content-between">        
                    <p>
                        {{$food->name}}
                    </p>
                    <input type="number" name='amount' min='0' max='100'>
                </div>    
            @endforeach
            <div>
                <button style="display: block; margin: auto;" type='submit'>メニューを追加</button>
            </div>
        </div>
    </form>
        

@endsection
    