@extends('layouts.app')
@section('content')
  <p>これはbladeファイル</p>
  <?php
  if($_SERVER["REQUEST_METHOD"]  == "POST"){
    echo "postです";
  }

  ?>


  <div class='login-icon'>
            <i class='fa fa-user' id='user-login-icon'  aria-hidden='true'></i>
            <a href='../login/login'>ログイン</a>
          </div>
        </div>
      </div>
    </nav>
  </div>
</header>
<div class='main'>
  <div class="json_main">
    <h1> 新規登録</h1>

    <h2 class="json_text"></h2>


    @if ($errors->any())
    
              @foreach ($errors->all() as $error)

                  <p class="error">{{ $error }}</p>

              @endforeach

    @endif

    <form action='../users' method='post' id='new-user-form'>
    {{ csrf_field() }}
      <td>
        <tr>
          <p>メールアドレス(必須)</p>
          <input type='text' name='email' value="{{old('email') }}" class='form-input'>
        </tr>
        <tr>
          <p>パスワード(必須)</p>
          <input type='text' name='password'  value="{{old('password') }}" class='form-input'>
        </tr>
      </td>
      <button id='user_create_button' type='submit' class='btn btn-success btn-lg'>新規登録</button>
    </form>
  </div>
</div>


@endsection