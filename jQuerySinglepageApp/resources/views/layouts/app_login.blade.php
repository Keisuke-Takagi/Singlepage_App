@extends('layouts.header')
  @section('content')

<body>
  <header id="header">
    <div class="app-icons">
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="registration.php">READ-BOOK-RECORDER</a>
            <p class="header_logout">ログアウトかり</p>

            <div class='login-icon'>
            <i class='fa fa-user' id='user-login-icon'  aria-hidden='true'></i>
      
            <div class="header_right"> 
              <a class="header_login">新規登録</a>
              <a class="header_logout">ログアウト(仮) </a>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </div>
</header>
<div class='main'>
  <div class="json_main">
    <h1> ログイン</h1>
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
      <button id='user_create_button' type='button' class='btn btn-success btn-lg'>ログイン</button>
    </form>
  </div>
</div>


  <footer>
      <div id="footermenu" class="inner">
        <ul>
          <li class="title">ホーム</li>
          <li><a href="contact.html" class="footer-link">お問い合わせ</a></li>
          <li><a href="company.html" class="footer-link">会社概要</a></li>
        </ul>
        <ul>
          <li class="title">メニュータイトル01</li>
          <li><a href="#" class="footer-link">メニューサンプル</a></li>
          <li><a href="#" class="footer-link">メニューサンプル</a></li>
          <li><a href="#" class="footer-link">メニューサンプル</a></li>
          <li><a href="#" class="footer-link">メニューサンプル</a></li>
          <li><a href="#" class="footer-link">メニューサンプル</a></li>
        </ul>
        <ul>
          <li class="title">メニュータイトル02</li>
          <li><a href="#" class="footer-link">メニューサンプル</a></li>
          <li><a href="#" class="footer-link">メニューサンプル</a></li>
          <li><a href="#" class="footer-link">メニューサンプル</a></li>
          <li><a href="#" class="footer-link">メニューサンプル</a></li>
          <li><a href="#" class="footer-link">メニューサンプル</a></li>
        </ul>
        <ul>
          <li class="title">メニュータイトル03</li>
          <li><a href="#" class="footer-link">メニューサンプル</a></li>
          <li><a href="#" class="footer-link">メニューサンプル</a></li>
          <li><a href="#" class="footer-link">メニューサンプル</a></li>
          <li><a href="#" class="footer-link">メニューサンプル</a></li>
          <li><a href="#" class="footer-link">メニューサンプル</a></li>
        </ul>
        <ul>
          <li class="title">メニュータイトル04</li>
          <li><a href="#" class="footer-link">メニューサンプル</a></li>
          <li><a href="#" class="footer-link">メニューサンプル</a></li>
          <li><a href="#" class="footer-link">メニューサンプル</a></li>
          <li><a href="#" class="footer-link">メニューサンプル</a></li>
          <li><a href="#" class="footer-link">メニューサンプル</a></li>
        </ul>
      </div>
    </footer>
  </body>
  @endsection