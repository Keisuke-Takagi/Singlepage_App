<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Validator, Input, Redirect; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Routing\Controllers;






class Userscontroller extends Controller
{
        /**
     * 認証の確認作業を処理する
     *
     * @return Response
     */

  // rootパス
  public function index(Request $request){
    // ajax/jsonを使用するため定義
    header("Content-type: application/json; charset=UTF-8");
    return view('layouts.app');
  }

  public function get_login(){
    header("Content-type: application/json; charset=UTF-8");
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
      // layoutから変更部分書き換え
      return view('users.ajax_login');
    }else{
      return view('layouts.app_login');
    }
  }


  // 新規登録(GET)  requestはajaxから取得
  public function signed_in(Request $request){

    $error_text = "";

    $user_instance  = new User();

    // request取得
    $requests = $request->all();
  
    $email = $requests["email"];
    $password = $requests["password"];

    // バリデーションの定義
    $validator = Validator::make($request->all(),[
      'email' => 'required|email|unique:users,email',
      'password' => 'required|string|password_check'
    ]);

    
    if($validator->fails() ){
      // validation失敗時
      $error_message = $validator->errors()->toArray();

      // Laravelエラーを配列から取得
      if(array_key_exists("email", $error_message)){
        $error_text .= $error_message["email"][0] . "<br>";
      };
      if(array_key_exists("password", $error_message)){
        $error_text .= $error_message["password"][0];
      };
      $return_error = '<p class="error">'. $error_text . '</p>';

      // json型式ででエラーメッセージ返す
      echo json_encode($return_error);
      exit;
    }else{
      // validation成功時(DB保存, ログイン処理, 次ページのviewをjsonで返す)
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $user_instance  = new User();
    $user_instance->email = $email;
    $user_instance->password = $password_hash;

    // DB保存
    $user_instance->save();

    // ログイン処理
    $this->user_login($email, $password);

    // jsに渡すviewの取得
    $page = view('books.index.mainpage');
    $page = strval($page);
    
    $array = [
      'page_info' => $page
    ];

    return json_encode($array);
    }
  
  }

  // 新規登録(POST)
  public function post_success_signed_in(Request $request){
  }

  // リストページ(GET)
  public function get_user_list(Request $request){

    // ログインチェック
    if (Auth::check()){
      return view('layouts.app');
    }else{
      //未ログイン時rootリダイレクト
      return redirect('/users');
    }
  }
  // リストページ(POST)ajaxで呼ばれる
  public function post_user_list(){
    $page_html_array = [];
    $user_array = [];
     // ログインチェック
    if (Auth::check()){
     
      // Laravelのview関数で扱うPathの定義(キーはjQueryで使用)
      $get_page_names = ['list_temp' => 'users.list_template', 'list_user' =>'users.user_info'];

      // 定義したviewのfile_pathからhtmlをjson型式にして返す
      foreach ($get_page_names as $k => $page) {
        $page_obj = view($page);
        $page_html = strval($page_obj);
        $page_html_array[$k] = $page_html;
      }

      // ユーザー情報の配列を取得
      $user_array = $this->get_info_users();
      $page_html_array["user_info"] = $user_array;

      // 作った配列をjson型式で返す
      echo json_encode($page_html_array);
    }else{
      // ログインが認められなかった時
      $error["error"] = 1;
      echo json_encode($error);
    }
  }


  // ログアウト処理
  public function logout(){
    Auth::logout();
    return view('layouts.reprint_first_page');
    // $page = strval($page);
    // echo  $page;
    if (Auth::check()){
      echo 'ユーザーはログイン済み…';
    }else{
      echo 'ログアウト済み';
    }
  }


  // -------------------private

    // ユーザーをログインさせる
    private function user_login($email, $password){
      // フォームで登録したemailでログイン
      $row_user = DB::table('users')
      ->where('email', $email)
      ->get();
  
      // Laravelのコレクションを配列に変換
      $row_user =   json_decode(json_encode($row_user[0]), true);
      $id = $row_user["id"];
  
      // 一ページだけログインをかけたい場合はこっち
      // \Auth::onceUsingId($id);
      
      // ログイン処理
      if (Auth::attempt(['email' => $email, 'password' => $password], true)) {
      }
    }

  // ユーザー情報をカラム別で分け一つの配列で返す処理
  private function get_info_users(){
    $users_info_array = [];
    $user_email_array = [];
    $user_password_array = [];
    
    // DBからユーザーの全レコードの取得
    $users_info = User::get();

    // カラム別で配列か
    foreach ($users_info as $key => $user_info){
      $user_email_array[$key] = $user_info->email;
      $user_password_array[$key] = $user_info->password;
    }
    // 作った配列をusers_info_arrayに一つにまとめる
    $users_info_array["email"] = $user_email_array;
    $users_info_array["password"] = $user_password_array;
    return $users_info_array;
  }



}
