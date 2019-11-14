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
  <title>新規登録ページ</title>
</head>
  @yield('content')
  </html>