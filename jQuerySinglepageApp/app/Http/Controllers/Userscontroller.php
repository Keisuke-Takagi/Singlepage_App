<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Validator, Input, Redirect; 
use Illuminate\Support\Facades\DB; 






class Userscontroller extends Controller
{

  public function index(Request $request){
    // とりあえずいまusersで出る
      header("Content-type: application/json; charset=UTF-8");
      $request = $request->all();
      var_dump($request);
      return view('layouts.app');

  }

  public function post_sign_in(Request $request){

    $error_text = "";
    // header("Content-type: application/json; charset=UTF-8");
    // $data = $_POST["email_json"];
    // var_dump($data);
    $email = json_encode(filter_input(INPUT_POST,"email"));
    $password = json_encode(filter_input(INPUT_POST,"password"));
    $email = $this->remove_quotation($email);
    $password = $this->remove_quotation($password);




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
    $user_instance->save();
    $user = DB::table('users')->where('email', $email);
    Auth::login($user);
    if (Auth::check()) {
      echo 'ろぐいんしています';
      exit;
    }
    // return redirect('/books/index');
    $page = file_get_contents('http://singlepage_app.com/books/index');
    $array = [
      'page_info' => $page
    ];
    echo json_encode($array);
    }
  }

  public function signed_in(){
    return view('books.index.mainpage');
  }

  public function post_success_signed_in(){
    $email = json_encode(filter_input(INPUT_POST,"_token"));
    echo $email;


  }

  private function remove_quotation($data){
    $data = str_replace("\"", '', $data);
    return $data;
  }

  // public function failedValidation( Validator $validator ){
  //   $response['data']    = [];
  //   $response['status']  = 'NG';
  //   $response['summary'] = 'Failed validation.';
  //   $response['errors']  = $validator->errors()->toArray();
  // }
}
