<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Validator, Input, Redirect; 






class Userscontroller extends Controller
{
  public function index(Request $request){
    // とりあえずいまusersで出る
      header("Content-type: application/json; charset=UTF-8");
      $requests = $request->all();
      $json = $request->json()->all();
      // var_dump($requests);
      return view('users.index');

  }

  public function post_sign_in(Request $request){


    // header("Content-type: application/json; charset=UTF-8");
    // $data = $_POST["email_json"];
    // var_dump($data);
    $email = json_encode(filter_input(INPUT_POST,"email"));
    $password = json_encode(filter_input(INPUT_POST,"password"));
    $email = $this->remove_quotation($email);
    $password = $this->remove_quotation($password);
    echo $email;




    // echo json_encode($json_email);

    $user_instance  = new User();


    // request取得
    // $requests = $request->all();
    // var_dump($requests);
    // $email = $requests["email"];
    // $password = $request->input('password');

    $validator = Validator::make($request->all(),[
      'email' => 'required|email|unique:users,email',
      'password' => 'required|string|password_check'
    ]);

    
    if($validator->fails() ){
      $error_message = $validator->errors()->toArray();


      // return redirect('/users')
      // ->withErrors($validator)
      // ->withInput($request->all)
      // ->with("db_error" ,$error);
      // return view('users.json_test');
    }else{
    $password = password_hash($password, PASSWORD_BCRYPT);
    $user_instance  = new User();
    $user_instance->email = $email;
    $user_instance->password = $password;
    $user_instance->save();
    // return redirect('/books/index');
    }
  }

  public function style(){
      $test_text = "aaaaa";
      return view('test',compact('test_text'));
  }

  private function remove_quotation($data){
    $data = str_replace("\"", '', $data);
    return $data;
  }
  public function failedValidation( Validator $validator ){
    $response['data']    = [];
    $response['status']  = 'NG';
    $response['summary'] = 'Failed validation.';
    $response['errors']  = $validator->errors()->toArray();
  }
}
