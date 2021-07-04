<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Logo;
use App\Service;
use App\Parcel;
use App\Agent;
use App\Deliveryman;
use App\Pickup;
use App\Deliverycharge;
use App\District;
use App\Socialmedia;
use App\Nearestzone;
use Carbon\Carbon;
use App\Parceltype;
use DB;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $whitelogo = Logo::where('type',1)->limit(1)->get();
        view()->share('whitelogo',$whitelogo); 


        $darklogo = Logo::where('type',2)->limit(1)->get();
        view()->share('darklogo',$darklogo); 

        $faveicon = Logo::where('type',3)->limit(1)->get();
        view()->share('faveicon',$faveicon); 

        $services = Service::where('status',1)->get();
        view()->share('services',$services); 

        $newparcel = Parcel::where('status',0)
        ->orderBy('id','DESC')
        ->get();
        view()->share('newparcel',$newparcel); 

        $processingparcel = Parcel::where('status',1)
        ->orderBy('id','DESC')
        ->get();
        view()->share('processingparcel',$processingparcel);

        $onthewayparcel = Parcel::where('status',2)
        ->orderBy('id','DESC')
        ->get();
        view()->share('onthewayparcel',$onthewayparcel);

        $deliverdparcel = Parcel::where('status',3)
        ->orderBy('id','DESC')
        ->get();
        view()->share('deliverdparcel',$deliverdparcel);

        $cancelledparcel = Parcel::where('status',4)
        ->orderBy('id','DESC')
        ->get();
        view()->share('cancelledparcel',$cancelledparcel);

        $returnprocessing = Parcel::where('status',5)
        ->orderBy('id','DESC')
        ->get();
        view()->share('returnprocessing',$returnprocessing);

        $returnparcel = Parcel::where('status',6)
        ->orderBy('id','DESC')
        ->get();
        view()->share('returnparcel',$returnparcel);

        $agents = Agent::where(['status'=>1])
        ->orderBy('id','DESC')
        ->get();
        view()->share('agents',$agents);
        
        $deliverymen = Deliveryman::where(['status'=>1])
        ->orderBy('id','ASC')
        ->get();
        view()->share('deliverymen',$deliverymen);
        
        $newpickup = Pickup::where('status',0)
        ->orderBy('id','DESC')
        ->get();
         view()->share('newpickup',$newpickup);

        $pendingpickup = Pickup::where('status',1)
        ->orderBy('id','DESC')
        ->get();
        view()->share('pendingpickup',$pendingpickup);

        $acceptedpickup = Pickup::where('status',2)
        ->orderBy('id','DESC')
        ->get();
        view()->share('acceptedpickup',$acceptedpickup);

        $cancelledpickup = Pickup::where('status',3)
        ->orderBy('id','DESC')
        ->get();
        view()->share('cancelledpickup',$cancelledpickup);

        $deliverycharge = Deliverycharge::where('status',1)
        ->get();
        view()->share('deliverycharge',$deliverycharge);

        $totalamounts=Parcel::sum('merchantAmount');
        view()->share('totalamounts',$totalamounts);

        $merchantsdue=Parcel::sum('merchantDue');
        view()->share('merchantsdue',$merchantsdue);

        $merchantspaid=Parcel::sum('merchantPaid');
        view()->share('merchantspaid',$merchantspaid);
       $todaymerchantspaid=Parcel::where('merchantpayStatus',1)->whereDate('updated_at', Carbon::today())->sum('merchantPaid');
        view()->share('todaymerchantspaid',$todaymerchantspaid);

        $deliverycharges=Parcel::sum('deliveryCharge');
        view()->share('deliverycharges',$deliverycharges);

        $codecharges=Parcel::sum('codCharge');
        view()->share('codecharges',$codecharges);

       $districts= District::where('status',1)->orderBy('id','ASC')->get();
        view()->share('districts',$districts);
        
       $socialmedia= Socialmedia::where('status',1)->orderBy('id','ASC')->get();
        view()->share('socialmedia',$socialmedia);

       $areas = Nearestzone::where('status',1)->get();
        view()->share('areas',$areas);

       $parceltypes = Parceltype::get();
        view()->share('parceltypes',$parceltypes);


    }
}
