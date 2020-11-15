<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;


class AdminMiddelware
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

        if(Auth::User() == true &&Auth::User()->status==1 )
        {


            return $next($request);
        }
        else
        {
            Auth::logout();
            return redirect('/login')->with('message_fales','برجاء الاتصال بالدعم الفنى');

        }
    }
}
