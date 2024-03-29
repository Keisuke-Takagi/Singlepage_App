<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Validator, Input, Redirect; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Routing\Controllers;
use Illuminate\Contracts\Auth\Authenticatable;


class Userscontroller extends Controller
{
        /**
     * 認証の確認作業を処理する
     *
     * @return Response
     */

  // rootパス(新規登録viewを返す)

  function __construct()
  {
    if($_SERVER["REQUEST_URI"] != "/users/list"){
      if(!isset($_SESSION)){
        session_start();
      }
      $_SESSION["url"] =  $_SERVER["REQUEST_URI"];
    }
  }
  public function index(Request $request){
    // ajax/jsonを使用するため定義
    header("Content-type: application/json; charset=UTF-8");
    return view('layouts.app');
  }

  // ログインviewを返す
  public function get_login(Request $request){
    header("Content-type: application/json; charset=UTF-8");
    return view('users.login');
  }

  // ajax通信でのloginpage処理
  public function get_login_ajax(Request $request){
    $requests = $request->all();

    // book_appからのajaxか判定
    if($requests["page"] == 'book_app'){
      return view("users.ajax.ajax_login");
    }else{
      $view = view('errors.401_error');
      return strval($view);
    }
  }
  public function get_registration_ajax(Request $request){
    $requests = $request->all();

    // book_appからのajaxか判定
    if($requests["page"] == 'book_app'){
      return view("users.ajax.ajax_registration");
    }else{
      $view = view('errors.401_error');
      return strval($view);
    }
  }

  // ajax通信でのログイン認証
  public function post_login_ajax(Request $request){
    $error_text = "";
    $return_error = "";
    $result_array = [];
    $user_instance  = new User();

    // request取得
    $requests = $request->all();
  
    $email = $requests["email"];
    $password = $requests["password"];

    // バリデーションの定義
    $validator = Validator::make($request->all(),[
      'email' => 'required|email',
      'password' => 'required|password_check|minlength'
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
      $result_array["error"] = $return_error;
      echo json_encode($result_array);
      exit;
    }else{
    // バリデーション成功
    // ログイン処理
    $error_text = $this->user_login($email, $password);
    if($error_text != ""){
      // ログイン認証失敗
      $return_error =  '<p class="error">'. $error_text . '</p>';
      $result_array["error"] = $return_error;
      echo json_encode($result_array);
      exit;
    }

    // jsに渡すviewの取得
    $get_page_names = ['list_temp' => 'users.ajax.list_template', 'list_user' =>'users.ajax.user_info'];

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
    return json_encode($page_html_array);
    exit;
    }
  }

  // 2ページ目新規登録完了(GET) 
  public function signed_in(Request $request){
    $array = [
      'error' => '<p class="error">ログインしてください </p>',
      'ajax_access' => 1,
    ];
    return json_encode($array);

  }

  // 新規登録(POST) ajaxからフォーム情報を受け取って登録orエラー出力
  public function post_success_signed_in(Request $request){
    $error_text = "";
    $array =[];

    $user_instance  = new User();
    $requests = $request->all();
  
    $email = $requests["email"];
    $password = $requests["password"];

    // バリデーションの定義
    $validator = Validator::make($request->all(),[
      'email' => 'required|email|unique:users,email',
      'password' => 'required|string|password_check|minlength|max:10'
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
      $array["error"] = '<p class="error">'. $error_text . '</p>';
      // json型式ででエラーメッセージ返す
      echo json_encode($array);
      exit;
    }else{
      // validation成功時(DB保存, ログイン処理, 次ページのviewをjsonで返す)
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $user_instance  = new User();
    $user_instance->email = $email;
    $user_instance->password = $password_hash;

    DB::beginTransaction();
    try {
      // DB保存
      $user_instance->save();
      DB::commit();
    }
    catch (\Exception $e) {
      DB::rollback();
      return 'トランザクション';
      exit;
    }
    

    // ログイン処理
    $error_text = $this->user_login($email, $password);

    // jsに渡すviewの取得
    if(Auth::user()){
      $page = view('users.ajax.mainpage');
      $page = strval($page);
      
      $array = [
        'page_info' => $page
      ];

      return json_encode($array);
    }else{
      // ユーザー作成に成功し、ログインできていない場合
      $page = view('layouts.app');
      $array = [
        'error' => 'ログインしてください',
        'external_access' => '1',
        'page_info' => $page,
      ];
      return json_encode($array);
    }
    }
  }

  // リストページ(GET)
  public function get_user_list(Request $request){

    // ログインチェック
    $user_array = $this->get_info_users();
    $emails = $user_array["email"];
    $passwords = $user_array["password"];
    return view('users.list',compact('emails', 'passwords'));
  }
  
  // リストページ(POST)ajaxで呼ばれる
  public function post_user_list(){
    $page_html_array = [];
    $user_array = [];
     // ログインチェック
    if (Auth::check()){
     
      // Laravelのview関数で扱うPathの定義(キーはjQueryで使用)
      $get_page_names = ['list_temp' => 'users.ajax.list_template', 'list_user' =>'users.ajax.user_info'];

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
    // $id = Auth::id();
    // return $id;
    Auth::logout();
    return view('users.ajax.print_registration_page');
    // $page = strval($page);
    // echo  $page;
    if (Auth::check()){
      echo 'ユーザーはログイン済み…';
    }else{
      echo 'ログアウト済み';
    }
  }

  public function re_login_ajax(Request $request){
    $requests = $request->all();
  
    $email = $requests["email"];
    $password = $requests["password"];
    $error_text = $this->user_login($email, $password);
    return "あああ";
  }

  // -------------------private

    // ユーザーをログインさせる
    private function user_login($email, $password){
      // フォーム入力されたemailの検索
      $row_user = "";
      $row_user = DB::table('users')
      ->where('email', $email)
      ->get()
      ->toArray();
  
      // Laravelのコレクションを配列に変換
      if(count($row_user) != 0){
        // 検索されたemailが存在
        $row_user =   json_decode(json_encode($row_user[0]), true);
        $id = $row_user["id"];
        // 一ページだけログインをかけたい場合はこっち
        // \Auth::onceUsingId($id);

        // ログイン処理
        if (Auth::attempt(['email' => $email, 'password' => $password], true)) {
        }else{
          return 'パスワードが違います';
        }
      }else{
        return 'メールアドレスが登録されていません';
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
