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
            foreach (Auth::User()->role as $role)
            {
               if($role->id == 2 || $role->id == 1)
               {
                   return $next($request);
               }
            }
            Auth::logout();
            return redirect('/login')->with('message_fales','برجاء الاتصال بالدعم الفنى');
        }
        else
        {
            Auth::logout();
            return redirect('/login')->with('message_fales','برجاء الاتصال بالدعم الفنى');

        }
    }
}
