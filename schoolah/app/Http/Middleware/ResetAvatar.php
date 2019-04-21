<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class ResetAvatar
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user = Auth::user();
        if($user->role == "student") {
            $userDetail = \App\Student::where("user_id", $user->id)->first();
            if($userDetail->avatar == 'img/no-pict') {
                return redirect('/reset-avatar');
            }
        }else if($user->role == "teacher") {
            $userDetail = \App\Teacher::where("user_id", $user->id)->first();
            if($userDetail->avatar == 'img/no-pict') {
                return redirect('/reset-avatar');
            }
        }



        return $next($request);
    }
}
