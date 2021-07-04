<?php

namespace App\Http\Middleware;

use Closure;
Use Session;
use App\Deliveryman;
class DeliverymanAuth
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
        $validAgent=Deliveryman::where(['id'=>Session::get('deliverymanId'),'status'=>1])->first();
        if ($validAgent!=NULL) {
            return $next($request);     
        }
        return redirect('deliveryman/login');
    }
}
