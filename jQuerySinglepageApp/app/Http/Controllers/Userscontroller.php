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

      $requests = $request->all();
      var_dump($requests);
      return view('users.index');
  }

  public function post_sign_in(Request $request){
    $error = "";
    $user_instance  = new User();

    $requests = $request->all();
    $email = $requests["email"];
    $password = $request->input('password');

    $validator = Validator::make($request->all(),[
      'email' => 'required|email|unique:users,email',
      'password' => 'required|string|password_check'
    ]);

    
    if($validator->fails() || $error != ""){
      return redirect('/users')
      ->withErrors($validator)
      ->withInput($request->all)
      ->with("db_error" ,$error);
    }else{
    $password = password_hash($password, PASSWORD_BCRYPT);
    $user_instance  = new User();
    $user_instance->email = $email;
    $user_instance->password = $password;
    $user_instance->save();
    return redirect('/books/index');
    }
  }

  public function style(){
      $test_text = "aaaaa";
      return view('test',compact('test_text'));
  }
}
