@extends('layouts.finely')

@section('content')
    <form  action='{{ route('add') }} method='POST'>
        @csrf
        <!-- 食材入力部分 -->
        <div class='text-center'>
            <input type="text" class='w-50' name='name' placeholder="登録する食材名">
        </div>
         <!-- 食材を在庫加えるボタン-->
         <div class='text-center'>
            <button  type='submit'>新しい食材を<br>追加</button>
         </div>
        </div>

            
                    
        </div>
        
    </fomr>

@endsection
    