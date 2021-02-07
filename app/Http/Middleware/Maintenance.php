<?php

namespace App\Http\Middleware;

use App;
use Closure;
use DB;

class Maintenance
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
        $Status = DB::table('Maintenance')->value('Status');

        if ($Status == "active") {
//return redirect()->to('https://sub.digi-gate.com/Maintenance');

                   //    dd("The site is in maintenance mode");
          return  redirect()->route('Maintenance.pag');
        }else{
                   return $next($request);
 
        }

    }
}
