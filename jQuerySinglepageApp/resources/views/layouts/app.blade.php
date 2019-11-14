<!DOCTYPE html>
<html lang='ja'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <meta http-equiv='X-UA-Compatible' content='ie=edge'>
  <link rel='stylesheet' href='https://unpkg.com/ress/dist/ress.min.css'>
  <link rel='stylesheet' type='text/css' href="{{  asset('css/style.css')  }}">
  <link href='https://use.fontawesome.com/releases/v5.6.1/css/all.css' rel='stylesheet'>
  <!-- jquery cdn -->
  <script src="https://code.jquery.com/jquery-3.4.1.js"integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="crossorigin="anonymous"></script>
  <!-- jsファイルの読み込み -->
  <script src="{{asset('js/user_registration.js')}}"></script>
  
  <link rel='stylesheet' href='//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
  <script src='//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
  <script src='//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>
  	
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name='viewport' content='width=device-width,initial-scale=1'>
  <title>新規登録ページ</title>
</head>

<body>
  <header id="header">
    <div class="app-icons">
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="registration.php">READ-BOOK-RECORDER</a>

            <div class='login-icon'>
            <i class='fa fa-user' id='user-login-icon'  aria-hidden='true'></i>
      
            <div class="header_right"> 
              <a href='../login/login'>ログイン</a>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </div>
</header>
<div class='main'>
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
</div>
  @yield('content')

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
  </html>