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
    echo 'GET';
    if(isset($email)){
    var_dump($email);

    }
      $requests = $request->all();
      var_dump($requests);
      $test_text = "TESTS";
      return view('users.index', compact('test_text'));
  }

  public function post_sign_in(Request $request){
    $e = "";
    $test_text = "TESTS";
    $user_instance  = new User();

    $requests = $request->all();
    $email = $requests["email"];
    $password = $request->input('password');
    var_dump($requests);
    echo $password."<br><br><br>" .$email;
    
    // $request->validate([
    //   'email' => 'required|email',
    //   'password' => 'required|string|min:5|password_check',
    // ]);
    $e = $this->validation($email);

    

    $validator = Validator::make($request->all(),[
      'email' => 'required|email',
      'password' => 'required|string|password_check'
    ]);
    if($validator->fails() &&){
      return redirect('/users')                       
      ->withErrors($validator)
      ->withInput($request->all, $e);
    }else{
    $password = password_hash($password, PASSWORD_BCRYPT);
    // $user_instance  = new User();
    $user_instance->email = $email;
    $user_instance->password = $password;
    $user_instance->save();
    return redirect('/books/index');
    }

    // $validated = $request->validated();



    // return view('users.index', compact('test_text'))
    // ->withErrors($validator)
    // ->withInput($request->all);

    // return view('books.mainpage');
  }
  private function validation($email){
    $row = "";
    $row = User::where('email', $email)->get();
    var_dump($row);
    return "そのメールアドレスは登録されています";
  }

  public function style(){
      $test_text = "aaaaa";
      return view('test',compact('test_text'));
  }
}
