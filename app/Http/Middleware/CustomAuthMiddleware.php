<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user_type = $user_id = null;
        if (auth()->check() && auth()->user()->is_admin) {
            $user_type = 'admin';
            $user_id = auth()->id();
        } elseif (auth('company_web')->check()) {
            $user_type = 'company';
            $user_id = auth('company_web')->id();
            if(request()->is('companies*')){
                return redirect()->route('users.index')->with('error','sorry you dont have permission.');
            }
        }else{
            return redirect()->back();
        }

        // config([
        //     'special.current_user_type' => $user_type,
        //     'special.current_user_id' => $user_id,
        // ]);

        return $next($request);
    }
}
