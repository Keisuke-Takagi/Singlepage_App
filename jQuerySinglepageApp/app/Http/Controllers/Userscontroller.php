<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Userscontroller extends Controller
{
  public function index(){
      $test_text = "TESTS";
      return view('index', compact('test_text'));
  }
}
