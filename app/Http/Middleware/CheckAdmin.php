<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
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
            $currentUser = Auth::user();
            if($currentUser->roles == User::ADMIN){
                return $next($request);
            }
            return redirect()->to("/logout");
        }
        return redirect()->to("/chatify");
    }
}
