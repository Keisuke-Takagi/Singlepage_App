<?php

namespace App\Http\Middleware;

use Closure;

class ajax_check 
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
        // アクション実行前の処理
        // SERVERに来たリクエストからajax通信かどうか判定
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            // ajaxの時
            return $next($request);
        }else{
            // ルートへリダイレクト
            return redirect('/users');
        }
    }
}
