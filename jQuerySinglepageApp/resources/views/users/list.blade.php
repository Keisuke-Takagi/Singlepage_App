
@extends('layouts.header')
@section('content')

            <p class="header_logout">ログアウトかり</p>

            <div class='login-icon'>
            <i class='fa fa-user' id='user-login-icon'  aria-hidden='true'></i>

            <div class="header_right"> 
              <a class="header_registration">新規登録</a>
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
      <h1 class="my-3 ml-3">利用者リスト</h1>
      <div class="col-5 ml-3">
          <div class="card">
              <div class="table-responsive">
              <table class="table table-responsive table-bordered table-striped table-hover table-responsive" style="white-space: nowrap;">
                  <thead>
                      <tr>
                          <th id="table_title＿id" style="width: 1%;">番号</th>
                          <th id="table_title__name" style="width:30%;">email</th>
                          <th id="table_title__name" style="width: 44%;">ハッシュ化されたパスワード</th>
                      </tr>
                    </thead>
                    <tbody>

                <!-- ここ繰り返し -->
                @foreach($emails as $email)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$email}}</td>
                  <td>{{$passwords[$loop->iteration - 1]}}</td>
                </tr>
                @endforeach
                <!-- ここまで -->
                </tbody>
              </table>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
  @endsection