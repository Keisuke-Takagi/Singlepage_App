
  <div class="json_main">
    <h1> 新規登録</h1>
    <div class="error_box"></div>
    <p class="header_logout">ログアウトかり</p>

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
      <button id='user_create_button' type='button' class='btn btn-success btn-lg'>新規登録</button>
    </form>
  </div>


