<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAuthMiddlwaree
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
       //---------------------------------------------------------------------------
       // return "this is middleware";
       //id here is path parameter it will be passed to the  function as first parameter
       //here we should have our logic so we can check if the user is authenticated or not and then we can return the response accordingly
       //here we check if user is auth to go to next page or no 
      dd($request->id);

        return  $next($request);    
    }
}
