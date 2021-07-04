<?php

namespace App\Http\Middleware;
use Closure;
Use Session;
use App\Merchant;
class MerchantAuth
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
        $validMerchant=Merchant::where(['id'=>Session::get('merchantId'),'status'=>1])->first();
        if ($validMerchant!=NULL) {
            return $next($request);     
        }
        return redirect('/');
    }
}
