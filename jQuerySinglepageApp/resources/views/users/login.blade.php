@extends('layouts.header')
@section('content')
              <p class="header_logout">ログアウトかり</p>
              <div class='login-icon'>
              <i class='fa fa-user' id='user-login-icon'  aria-hidden='true'></i>

              <div class="header_right"> 
                <a class="header_registration">新規登録</a>'
              </div>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </header>
<div class="contents_wrapper">

<div class='main'>
<div class="contents_main">
<div class="json_main">
    <h1> ログイン</h1>
    <div class="error_box"></div>

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
        <input type="hidden" name="token" value="{{ csrf_token() }}">

      </td>
      <button id='user_login_button' type='button' class='btn btn-success btn-lg'>ログイン</button>
    </form>
  </div>
  </div>
</div>
@endsection