<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class ListLoginCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            return $next($request);
        }else{
            if(!isset($_SESSION)){
                session_start();
            }
            if($_SESSION["url"] == "/users/login"){
                return redirect("/users/login");
            }
            return redirect("/users");
        }
    }
}
