<?php

namespace App\Http\Middleware;

use Closure;
Use Session;
use App\Agent;
class AgentAuth
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
         $validAgent=Agent::where(['id'=>Session::get('agentId'),'status'=>1])->first();
        if ($validAgent!=NULL) {
            return $next($request);     
        }
        return redirect('/agent/login');
    }
}
