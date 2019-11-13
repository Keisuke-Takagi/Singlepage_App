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
  public function __construct()
  {
    // if (Auth::check())
    // {
    // }else{
    //   return redirect('/users');
    // }
    
  }
        /**
     * 認証の確認作業を処理する
     *
     * @return Response
     */

  // ユーザーをログインさせる
  public function user_login($email, $password)
  {
    $row_user = DB::table('users')
    ->where('email', $email)
    ->get();
    $row_user =   json_decode(json_encode($row_user[0]), true);
    $id = $row_user["id"];
    // \Auth::onceUsingId($id);
    // if (Auth::attempt(['email' => $email, 'password' => $password])) {
    // }
    // if (Auth::check())
    // {
    //     echo 'ユーザーはログイン済み…';
    // }else{
    //   echo 'ログアウト済み';
    // }
  }

  public function index(Request $request){
    // とりあえずいまusersで出る
      header("Content-type: application/json; charset=UTF-8");
      $request = $request->all();
      return view('layouts.app');
  }

  public function post_sign_in(Request $request){
    $error_text = "";
    // header("Content-type: application/json; charset=UTF-8");
    // $data = $_POST["email_json"];
    // var_dump($data);
    // $email = json_encode(filter_input(INPUT_POST,"email"));
    // $password = json_encode(filter_input(INPUT_POST,"password"));
    // $email = $this->remove_quotation($email);
    // $password = $this->remove_quotation($password);



    $user_instance  = new User();

    // request取得
    $requests = $request->all();
    // var_dump($requests);
    $email = $requests["email"];
    // $password = $request->input('password');
    $password = $requests["password"];

    $validator = Validator::make($request->all(),[
      'email' => 'required|email|unique:users,email',
      'password' => 'required|string|password_check'
    ]);

    
    if($validator->fails() ){
      $error_message = $validator->errors()->toArray();
      if(array_key_exists("email", $error_message)){
        $error_text .= $error_message["email"][0] . "<br>";
      };
      if(array_key_exists("password", $error_message)){
        $error_text .= $error_message["password"][0];
      };
      $return_error = '<p class="error">'. $error_text . '</p>';
      echo json_encode($return_error);
      exit;
    }else{
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $user_instance  = new User();
    $user_instance->email = $email;
    $user_instance->password = $password_hash;

    // 作成
    $user_instance->save();

    // Laravelでユーザーのログイン
    $this->user_login($email, $password);
;
    // jsに渡すviewの取得
    // 配列ではなく文字列で返すreturn view()でやる
    $page = file_get_contents('http://singlepage_app.com/users/index');

    $array = [
      'page_info' => $page
    ];
    echo json_encode($array);
    }
  }

  public function signed_in(){
        // Auth::logout();
    // if (Auth::check())
    // {
    // }else{
    //   return redirect('/users');
    // }
    return view('books.index.mainpage');
  }

  public function post_success_signed_in(Request $request){

    $request = $request->all();
    $token = $request["_token"];
    $page = file_get_contents('http://singlepage_app.com/users/index');
    echo $page;
    // echo $email;
  }

  public function get_user_list(){
    return view('users.user_list');
  }

  private function remove_quotation($data){
    $data = str_replace("\"", '', $data);
    return $data;
  }

  public function logout(){
    // Auth::logout();
    if (Auth::check())
    {
        echo 'ユーザーはログイン済み…';
    }else{
      echo 'ログアウト済み';
    }
  }
}
