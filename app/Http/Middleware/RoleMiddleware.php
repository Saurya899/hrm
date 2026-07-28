<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
         if(!auth()->check()){
            if($role === 'super-admin'){
                return redirect()->route('super-admin.login');
            }
            elseif($role === 'doctor'){
              return redirect()->route('doctor.login');
            }
            else{
                return redirect()->route('patient.login');
            }
         }

         if(auth()->user()->role !== $role)
            {
                abort(403,'unthorised Acccess.');
            }
        return $next($request);
    }
}
