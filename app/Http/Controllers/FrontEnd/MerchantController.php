<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Merchant;
use App\Nearestzone;
use App\Deliverycharge;
use App\Codcharge;
use App\Parcel;
use App\Imports\ParcelImport;
use App\Exports\ParcelExport;
use App\Employee;
use App\Price;
use App\Pickup;
use App\PickDrop;
use App\Merchantpayment;
use App\Parcelnote;
use App\Parceltype;
use App\Deliveryman;
use App\Agent;
use Session;
use DB;
use Mail;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
class MerchantController extends Controller
{
    
    public function registerpage(){
        return view('frontEnd.layouts.pages.register');
    } 

    public function register(Request $request){
        
  	  	$this->validate($request,[
  		  'companyName'=>'required',
          'phoneNumber'=>'required|unique:merchants',
          'emailAddress'=>'required|unique:merchants',
          'username'=>'required|unique:merchants',
          'password'=>'required|same:confirmed',
  	      'confirmed'=>'required',
  		  'agree'=>'required',
  	    ]);
    	 $marchentEmail=Merchant::where('emailAddress',$request->emailAddress)->first();
    	if($marchentEmail){
    	     Toastr::error('message', 'Opps! your email address already exist');
    	     $this->validate($request,[
                'emailAddress'=>'required|unique:merchant',
            ]);
    	   return redirect()->back();
    	 }else{
    	   $this->validate($request,[
          'companyName'=>'required',
            'phoneNumber'=>'required|unique:merchants',
            'emailAddress'=>'required|unique:merchants',
            'username'=>'required|unique:merchants',
            'password'=>'required|same:confirmed',
            'confirmed'=>'required',
          'agree'=>'required',
          ]);
      		$store_data				   = 	new Merchant();
            $store_data->companyName   =   $request->companyName;
            $store_data->firstName     =   $request->firstName;
    	    $store_data->phoneNumber   =   $request->phoneNumber;
            $store_data->emailAddress  =   $request->emailAddress;
            $store_data->username      =   $request->username;
    	    $store_data->pickLocation  =   $request->pickLocation;
            $store_data->paymentMethod =   $request->paymentMethod;
            
            $store_data->status        =    1;
            $store_data->verify        =    1;
            $store_data->agree         =    $request->agree;
    	    $store_data->password 	   =	bcrypt(request('password'));
    	    $store_data->save();
    	    
    	 $dataemail = array(
         'companyName' =>  $request->companyName,
         'username' =>  $request->username,
         'emailAddress' =>  $request->emailAddress,
         'subject' => 'Your Registration Successfully',
        );
         // return $data;
         $send = Mail::send('frontEnd.emails.newregister', $dataemail, function($textmsg) use ($dataemail){
         $textmsg->to($dataemail['emailAddress']);
         $textmsg->subject($dataemail['subject']);
        });
        
        $url = "http://66.45.237.70/api.php";
        $number="$request->phoneNumber;";
        $text="Dear $request->companyName \r\n  Successfully boarded your account. $request->username \r\n Now you can login & enjoy our services. If any query call us +880 1781122423  \r\n Regards,\r\n Flingex ";
        
        $data= array(
        'username'=>"01977593593",
        'password'=>"evertech@593",
        'number'=>"$number",
        'message'=>"$text"
        );
        
        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        $p = explode("|",$smsresult);
        $sendstatus = $p[0];
        
    	    
          Toastr::success('message', 'Registration Successfully !!');
          return redirect('/merchant/login');
    	 }
    	 
    	 
    	 
    	 
    }
    
    public function loginpage(){
        return view('frontEnd.layouts.pages.login');
    }
    public function login(Request $request){
        $this->validate($request,[
            'username' => 'required',
            'password' => 'required',
        ]);
       $merchantChedk =Merchant::where('username',$request->username)
       ->first();
       Session::put('merchantName',$request->username);
        if($merchantChedk){
          if($merchantChedk->status == 0 || $merchantChedk->verify == 0){
             Toastr::warning('warning', 'Opps! your account has been review');
             return redirect()->back();
         }else{
          if(password_verify($request->password,$merchantChedk->password)){
              $merchantId = $merchantChedk->id;
               Session::put('merchantId',$merchantId);

               Toastr::success('success', 'Thanks , You are login successfully');
              return redirect('/merchant/dashboard');
            
          }else{
              Toastr::error('Opps!', 'Sorry! your password wrong');
              return redirect()->back();
          }

           }
        }else{
          Toastr::error('Opps!', 'Opps! you have no account');
          return redirect()->back();
        } 
    }
    // Merchant Login Function End

    public function dashboard(){
          $placepercel=Parcel::where(['merchantId'=>Session::get('merchantId')])->count();
          $pendingparcel=Parcel::where(['merchantId'=>Session::get('merchantId'),'status'=>1])->count();
          $deliverd=Parcel::where(['merchantId'=>Session::get('merchantId'),'status'=>4])->count();
          $cancelparcel=Parcel::where(['merchantId'=>Session::get('merchantId'),'status'=>9])->count();
          $parcelreturn=Parcel::where(['merchantId'=>Session::get('merchantId'),'status'=>8])->count();
          $totalhold=Parcel::where(['merchantId'=>Session::get('merchantId'),'status'=>5])->count();
          $totalamount=Parcel::where(['merchantId'=>Session::get('merchantId'),'status'=>4])->sum('cod');
          $merchantUnPaid=Parcel::where('merchantId',Session::get('merchantId'))->where('status','!=',9)->whereNull('merchantpayStatus')->sum('merchantAmount');
          $merchantPaid=Parcel::where(['merchantId'=>Session::get('merchantId'),'merchantpayStatus'=>1])->sum('merchantAmount');
          $merchantAmount=Parcel::where('merchantId', Session::get('merchantId'))->where('status','!=',9)->sum('merchantAmount');
          return view('frontEnd.layouts.pages.merchant.dashboard',compact('placepercel','merchantAmount','pendingparcel','deliverd','parcelreturn','cancelparcel','totalhold','totalamount','merchantUnPaid','merchantPaid'));
    }
    // Merchant Dashboard
    public function profile(){
        $profileinfos = Merchant::all();
        Session::put('merchantName',$profileinfos->name);
      return view('frontEnd.layouts.pages.merchant.profile',compact('profileinfos'));
      
    }

    public function profileEdit(){
        $profileinfos = Merchant::all();
        $nearestzones = Nearestzone::where('status',1)->get();
        return view('frontEnd.layouts.pages.merchant.profileedit',compact('nearestzones'));
      
    }
    public function support(){
        return view('frontEnd.layouts.pages.merchant.support');
    }
    // Merchant Profile Edit
        public function profileUpdate(Request $request){
        $update_merchant = Merchant::find(Session::get('merchantId'));
        $update_merchant->phoneNumber = $request->phoneNumber;
        $update_merchant->pickLocation = $request->pickLocation;
        $update_merchant->nearestZone = $request->nearestZone;
        $update_merchant->pickupPreference = $request->pickupPreference;
        $update_merchant->paymentMethod = $request->paymentMethod;
        $update_merchant->withdrawal = $request->withdrawal;
        $update_merchant->nameOfBank = $request->nameOfBank;
        $update_merchant->bankBranch = $request->bankBranch;
        $update_merchant->bankAcHolder = $request->bankAcHolder;
        $update_merchant->bankAcNo = $request->bankAcNo;
        $update_merchant->bkashNumber = $request->bkashNumber;
        $update_merchant->roketNumber = $request->roketNumber;
        $update_merchant->nogodNumber = $request->nogodNumber;
        $update_merchant->save();
        return redirect()->back()->with('success','Your account update successfully');
    }
    // Merchant Profile Update
    public function logout(){
        Session::flush();
        Toastr::success('Success!', 'Thanks! you are logout successfully');
        return redirect('/merchant/login');
    }
    // Merchant Logout

 
    public function chooseservice(){
      $pricing = Deliverycharge::where('status',1)->get();
      return view('frontEnd.layouts.pages.merchant.chooseservice',compact('pricing'));
    }
    public function parcelcreate($slug){
      $ordertype = Deliverycharge::where('slug',$slug)->first();
      $areas = Nearestzone::where('status',1)->get();
      $codcharge = Codcharge::where('status',1)->orderBy('id','DESC')->first();
      Session::forget('codpay');
      Session::forget('pcodecharge');
      Session::forget('pdeliverycharge');
      if($ordertype){
        return view('frontEnd.layouts.pages.merchant.parcelcreate',compact('ordertype','codcharge','areas'));
      }
    }
  //Parcel Oparation
  public function parcelstore(Request $request){
     $this->validate($request,[
        'cod'=>'required',
        'percelType'=>'required',
        'name'=>'required',
        'address'=>'required',
        'phonenumber'=>'required',
      ]);
      $hub=Nearestzone::where('id',$request->reciveZone)->first();
     // fixed delivery charge
     if($request->weight > 1 || $request->weight !=NULL){
      $extraweight = $request->weight-1;
      $deliverycharge = (Session::get('deliverycharge')*1)+($extraweight*Session::get('extradeliverycharge'));
      $weight = $request->weight;
     }else{
      $deliverycharge = (Session::get('deliverycharge'));
      $weight = 1;
     }
     // fixed cod charge
     if($request->cod > 100){
    //   $extracod=$request->cod -100;
    //   $extracodcharge = $extracod/100;
      $extracodcharge = 0;
      $codcharge = Session::get('codcharge')+$extracodcharge;
     }else{
      $codcharge= Session::get('codcharge');
     }
    //  dd(Session::get('merchantName'));
     $store_parcel = new Parcel;
     $store_parcel->invoiceNo = $request->invoiceNo;
     $store_parcel->merchantId = Session::get('merchantId');
     $store_parcel->user = Session::get('merchantName');
     $store_parcel->cod = $request->cod;
     $store_parcel->agentId = $hub->hub_id;
     $store_parcel->percelType = $request->percelType;
     $store_parcel->recipientName = $request->name;
     $store_parcel->recipientAddress = $request->address;
     $store_parcel->recipientPhone = $request->phonenumber;
     $store_parcel->productWeight = $weight;
     $store_parcel->trackingCode  = mt_rand(0000,99999)+1;
     $store_parcel->note = $request->note;
     $store_parcel->deliveryCharge = $deliverycharge;
     $store_parcel->codCharge = $codcharge;
     $store_parcel->reciveZone = $request->reciveZone;
     $store_parcel->productPrice = $request->productPrice;
     $store_parcel->merchantAmount = ($request->cod)-($deliverycharge);
     $store_parcel->merchantDue = ($request->cod)-($deliverycharge);
     $store_parcel->orderType = Session::get('ordertype');
     $store_parcel->codType = Session::get('codtype');
     $store_parcel->status = 1;
     $store_parcel->save();
     
     $note = new Parcelnote();
     $note->parcelId = $store_parcel->id;
     $note->note = 'parcel create successfully';
    //  $note->save();
     
     $data = array(
         'trackingCode' =>  $store_parcel->trackingCode,
         'subject' => 'New Parcel Place',
        );
         // return $data;
         $send = Mail::send('frontEnd.emails.parcelplace', $data, function($textmsg) use ($data){
         $textmsg->to('info@flingex.com');
         $textmsg->subject($data['subject']);
        });
     
     Toastr::success('Success!', 'Thanks! your parcel add successfully');
     return redirect('merchant/choose-service');
  } 

 public function pickuprequest(Request $request){
     $this->validate($request,[
        'pickupAddress'=>'required',
      ]);
      
      $date = date('Y-m-d');
      $findpickup = Pickup::where('date',$date)->Where('merchantId',Session::get('merchantId'))->count();
         if($findpickup){
            Toastr::error('Opps!', 'Sorry! your pickup request already pending');
             return redirect()->back();
         }else{
             $store_pickup = new Pickup;
             $store_pickup->merchantId = Session::get('merchantId');
             $store_pickup->pickuptype = $request->pickuptype;
             $store_pickup->area  = $request->area;
             $store_pickup->pickupAddress = $request->pickupAddress;
             $store_pickup->note = $request->note;
             $store_pickup->date = $date;
             $store_pickup->estimedparcel = $request->estimedparcel;
             $store_pickup->save();
             Toastr::success('Success!', 'Thanks! your pickup request send  successfully');
             return redirect()->back();
         }
     
  }
   public function pickupmanage(){
      $show_data = DB::table('pickups')
      ->where('pickups.merchantId',Session::get('merchantId'))
      ->orderBy('pickups.id','DESC')
      ->select('pickups.*')
      ->get();
      $deliverymen = Deliveryman::where('status',1)->get();
      return view('frontEnd.layouts.pages.merchant.pickup',compact('show_data','deliverymen'));
    }
  public function pickup(){
      $show_data = DB::table('pickups')
      ->where('pickups.merchantId',Session::get('merchantId'))
      ->orderBy('pickups.id','DESC')
      ->select('pickups.*')
      ->get();
      $deliverymen = Deliveryman::where('status',1)->get();
      return view('frontEnd.layouts.pages.merchant.pickup',compact('show_data','deliverymen'));
    }
      public function parcel(Request $request){
 
       $filter = $request->filter_id;
       if($request->trackId!=NULL){
           $parcelr =Parcel::where('merchantId',Session::get('merchantId'))->where('status',4)->where('trackingCode',$request->trackId)->count();
    $parcelc =Parcel::where('merchantId',Session::get('merchantId'))->where('status',9)->where('trackingCode',$request->trackId)->count();
    $parcelre =Parcel::where('merchantId',Session::get('merchantId'))->where('status',8)->where('trackingCode',$request->trackId)->count();
    $parcelpa =Parcel::where('merchantId',Session::get('merchantId'))->where('status',1)->where('trackingCode',$request->trackId)->count();
    $parcelpictd =Parcel::where('merchantId',Session::get('merchantId'))->where('status',2)->where('trackingCode',$request->trackId)->count();
    $parcelinterjit =Parcel::where('merchantId',Session::get('merchantId'))->where('status',3)->where('trackingCode',$request->trackId)->count();
    $parcelhold =Parcel::where('merchantId',Session::get('merchantId'))->where('status',5)->where('trackingCode',$request->trackId)->count();
    $parcelrrtupa =Parcel::where('merchantId',Session::get('merchantId'))->where('status',6)->where('trackingCode',$request->trackId)->count();
    $parcelrrhub =Parcel::where('merchantId',Session::get('merchantId'))->where('status',7)->where('trackingCode',$request->trackId)->count();
    $parcelprice =Parcel::where('merchantId',Session::get('merchantId'))->where('trackingCode',$request->trackId)->where('status','!=',9)->sum('cod');
    $parcelamount =Parcel::where('merchantId',Session::get('merchantId'))->where('trackingCode',$request->trackId)->sum('merchantPaid');
    $parcelcount =Parcel::where('merchantId',Session::get('merchantId'))->where('trackingCode',$request->trackId)->count();
        $allparcel = DB::table('parcels')
        ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.merchantId',Session::get('merchantId'))
        ->where('parcels.trackingCode',$request->trackId)
        ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->orderBy('id','DESC')
        ->get();
       }elseif($request->phoneNumber!=NULL){
    $parcelr =Parcel::where('merchantId',Session::get('merchantId'))->where('status',4)->where('recipientPhone',$request->phoneNumber)->count();
    $parcelc =Parcel::where('merchantId',Session::get('merchantId'))->where('status',9)->where('recipientPhone',$request->phoneNumber)->count();
    $parcelre =Parcel::where('merchantId',Session::get('merchantId'))->where('status',8)->where('recipientPhone',$request->phoneNumber)->count();
    $parcelpa =Parcel::where('merchantId',Session::get('merchantId'))->where('status',1)->where('recipientPhone',$request->phoneNumber)->count();
    $parcelpictd =Parcel::where('merchantId',Session::get('merchantId'))->where('status',2)->where('recipientPhone',$request->phoneNumber)->count();
    $parcelinterjit =Parcel::where('merchantId',Session::get('merchantId'))->where('status',3)->where('recipientPhone',$request->phoneNumber)->count();
    $parcelhold =Parcel::where('merchantId',Session::get('merchantId'))->where('status',5)->where('recipientPhone',$request->phoneNumber)->count();
    $parcelrrtupa =Parcel::where('merchantId',Session::get('merchantId'))->where('status',6)->where('recipientPhone',$request->phoneNumber)->count();
    $parcelrrhub =Parcel::where('merchantId',Session::get('merchantId'))->where('status',7)->where('recipientPhone',$request->phoneNumber)->count();
    $parcelprice =Parcel::where('merchantId',Session::get('merchantId'))->where('recipientPhone',$request->phoneNumber)->where('status','!=',9)->sum('cod');
    $parcelamount =Parcel::where('merchantId',Session::get('merchantId'))->where('recipientPhone',$request->phoneNumber)->sum('merchantPaid');
    $parcelcount =Parcel::where('merchantId',Session::get('merchantId'))->where('recipientPhone',$request->phoneNumber)->count();
        $allparcel = DB::table('parcels')
        ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.merchantId',Session::get('merchantId'))
        ->where('parcels.recipientPhone',$request->phoneNumber)
        ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->orderBy('id','DESC')
        ->get();
       }elseif($request->startDate!=NULL && $request->endDate!=NULL){
    $parcelr =Parcel::where('merchantId',Session::get('merchantId'))->where('status',4)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelc =Parcel::where('merchantId',Session::get('merchantId'))->where('status',9)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelre =Parcel::where('merchantId',Session::get('merchantId'))->where('status',8)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelpa =Parcel::where('merchantId',Session::get('merchantId'))->where('status',1)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelpictd =Parcel::where('merchantId',Session::get('merchantId'))->where('status',2)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelinterjit =Parcel::where('merchantId',Session::get('merchantId'))->where('status',3)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelhold =Parcel::where('merchantId',Session::get('merchantId'))->where('status',5)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelrrtupa =Parcel::where('merchantId',Session::get('merchantId'))->where('status',6)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelrrhub =Parcel::where('merchantId',Session::get('merchantId'))->where('status',7)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelprice =Parcel::where('merchantId',Session::get('merchantId'))->whereBetween('updated_at', [$request->startDate, $request->endDate])->where('status','!=',9)->sum('cod');
    $parcelamount =Parcel::where('merchantId',Session::get('merchantId'))->whereBetween('updated_at', [$request->startDate, $request->endDate])->sum('merchantPaid');
    $parcelcount =Parcel::where('merchantId',Session::get('merchantId'))->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
        $allparcel = DB::table('parcels')
        ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.merchantId',Session::get('merchantId'))
        ->whereBetween('parcels.updated_at',[$request->startDate, $request->endDate])
        ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->orderBy('id','DESC')
        ->get();
       }elseif($request->trackId!=NULL || $request->phoneNumber!=NULL && $request->startDate!=NULL && $request->endDate!=NULL){
           $parcelr =Parcel::where('merchantId',Session::get('merchantId'))->where('status',4)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelc =Parcel::where('merchantId',Session::get('merchantId'))->where('status',9)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelre =Parcel::where('merchantId',Session::get('merchantId'))->where('status',8)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelpa =Parcel::where('merchantId',Session::get('merchantId'))->where('status',1)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelpictd =Parcel::where('merchantId',Session::get('merchantId'))->where('status',2)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelinterjit =Parcel::where('merchantId',Session::get('merchantId'))->where('status',3)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelhold =Parcel::where('merchantId',Session::get('merchantId'))->where('status',5)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelrrtupa =Parcel::where('merchantId',Session::get('merchantId'))->where('status',6)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelrrhub =Parcel::where('merchantId',Session::get('merchantId'))->where('status',7)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelprice =Parcel::where('merchantId',Session::get('merchantId'))->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->where('status','!=',9)->sum('cod');
    $parcelamount =Parcel::where('merchantId',Session::get('merchantId'))->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->sum('merchantPaid');
    $parcelcount =Parcel::where('merchantId',Session::get('merchantId'))->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
        $allparcel = DB::table('parcels')
        ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.merchantId',Session::get('merchantId'))
        ->where('parcels.recipientPhone',$request->phoneNumber)
        ->whereBetween('parcels.updated_at',[$request->startDate, $request->endDate])
        ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->orderBy('id','DESC')
        ->get();
       }else{
    $parcelr =Parcel::where('merchantId',Session::get('merchantId'))->where('status',4)->count();
    $parcelc =Parcel::where('merchantId',Session::get('merchantId'))->where('status',9)->count();
    $parcelre =Parcel::where('merchantId',Session::get('merchantId'))->where('status',8)->count();
    $parcelpa =Parcel::where('merchantId',Session::get('merchantId'))->where('status',1)->count();
    $parcelpictd =Parcel::where('merchantId',Session::get('merchantId'))->where('status',2)->count();
    $parcelinterjit =Parcel::where('merchantId',Session::get('merchantId'))->where('status',3)->count();
    $parcelhold =Parcel::where('merchantId',Session::get('merchantId'))->where('status',5)->count();
    $parcelrrtupa =Parcel::where('merchantId',Session::get('merchantId'))->where('status',6)->count();
    $parcelrrhub =Parcel::where('merchantId',Session::get('merchantId'))->where('status',7)->count();
    $parcelprice =Parcel::where('merchantId',Session::get('merchantId'))->sum('cod');
    $parcelamount =Parcel::where('merchantId',Session::get('merchantId'))->sum('merchantPaid');
    $parcelcount =Parcel::where('merchantId',Session::get('merchantId'))->count();
        $allparcel = DB::table('parcels')
        ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.merchantId',Session::get('merchantId'))
         ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->orderBy('id','DESC')
        ->get();
       }
        
      return view('frontEnd.layouts.pages.merchant.parcels',compact('allparcel','parcelr','parcelc','parcelre','parcelpa','parcelpictd','parcelinterjit','parcelhold','parcelrrtupa','parcelrrhub','parcelprice','parcelamount','parcelcount'));
  }
  public function parcels(Request $request){
  
      $aparceltypes = Parceltype::where('slug',$request->slug)->first();
    
       $filter = $request->filter_id;
       if($request->trackId!=NULL){
            $parcelr =Parcel::where('merchantId',Session::get('merchantId'))->where('status',4)->where('trackingCode',$request->trackId)->count();
    $parcelc =Parcel::where('merchantId',Session::get('merchantId'))->where('status',9)->where('trackingCode',$request->trackId)->count();
    $parcelre =Parcel::where('merchantId',Session::get('merchantId'))->where('status',8)->where('trackingCode',$request->trackId)->count();
    $parcelpa =Parcel::where('merchantId',Session::get('merchantId'))->where('status',1)->where('trackingCode',$request->trackId)->count();
    $parcelpictd =Parcel::where('merchantId',Session::get('merchantId'))->where('status',2)->where('trackingCode',$request->trackId)->count();
    $parcelinterjit =Parcel::where('merchantId',Session::get('merchantId'))->where('status',3)->where('trackingCode',$request->trackId)->count();
    $parcelhold =Parcel::where('merchantId',Session::get('merchantId'))->where('status',5)->where('trackingCode',$request->trackId)->count();
    $parcelrrtupa =Parcel::where('merchantId',Session::get('merchantId'))->where('status',6)->where('trackingCode',$request->trackId)->count();
    $parcelrrhub =Parcel::where('merchantId',Session::get('merchantId'))->where('status',7)->where('trackingCode',$request->trackId)->count();
    $parcelprice =Parcel::where('merchantId',Session::get('merchantId'))->where('trackingCode',$request->trackId)->where('status','!=',9)->sum('cod');
    $parcelamount =Parcel::where('merchantId',Session::get('merchantId'))->where('trackingCode',$request->trackId)->sum('merchantPaid');
    $parcelcount =Parcel::where('merchantId',Session::get('merchantId'))->where('trackingCode',$request->trackId)->count();
      
        $allparcel = DB::table('parcels')
        ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.merchantId',Session::get('merchantId'))
        ->where('parcels.trackingCode',$request->trackId)
        ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->orderBy('id','DESC')
        ->get();
       }elseif($request->phoneNumber!=NULL){
           $parcelr =Parcel::where('merchantId',Session::get('merchantId'))->where('status',4)->where('recipientPhone',$request->phoneNumber)->count();
    $parcelc =Parcel::where('merchantId',Session::get('merchantId'))->where('status',9)->where('recipientPhone',$request->phoneNumber)->count();
    $parcelre =Parcel::where('merchantId',Session::get('merchantId'))->where('status',8)->where('recipientPhone',$request->phoneNumber)->count();
    $parcelpa =Parcel::where('merchantId',Session::get('merchantId'))->where('status',1)->where('recipientPhone',$request->phoneNumber)->count();
    $parcelpictd =Parcel::where('merchantId',Session::get('merchantId'))->where('status',2)->where('recipientPhone',$request->phoneNumber)->count();
    $parcelinterjit =Parcel::where('merchantId',Session::get('merchantId'))->where('status',3)->where('recipientPhone',$request->phoneNumber)->count();
    $parcelhold =Parcel::where('merchantId',Session::get('merchantId'))->where('status',5)->where('recipientPhone',$request->phoneNumber)->count();
    $parcelrrtupa =Parcel::where('merchantId',Session::get('merchantId'))->where('status',6)->where('recipientPhone',$request->phoneNumber)->count();
    $parcelrrhub =Parcel::where('merchantId',Session::get('merchantId'))->where('status',7)->where('recipientPhone',$request->phoneNumber)->count();
    $parcelprice =Parcel::where('merchantId',Session::get('merchantId'))->where('recipientPhone',$request->phoneNumber)->where('status','!=',9)->sum('cod');
    $parcelamount =Parcel::where('merchantId',Session::get('merchantId'))->where('recipientPhone',$request->phoneNumber)->sum('merchantPaid');
    $parcelcount =Parcel::where('merchantId',Session::get('merchantId'))->where('recipientPhone',$request->phoneNumber)->count();
        $allparcel = DB::table('parcels')
        ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.merchantId',Session::get('merchantId'))
        ->where('parcels.recipientPhone',$request->phoneNumber)
        ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->orderBy('id','DESC')
        ->get();
       }elseif($request->startDate!=NULL && $request->endDate!=NULL){
            $parcelr =Parcel::where('merchantId',Session::get('merchantId'))->where('status',4)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelc =Parcel::where('merchantId',Session::get('merchantId'))->where('status',9)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelre =Parcel::where('merchantId',Session::get('merchantId'))->where('status',8)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelpa =Parcel::where('merchantId',Session::get('merchantId'))->where('status',1)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelpictd =Parcel::where('merchantId',Session::get('merchantId'))->where('status',2)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelinterjit =Parcel::where('merchantId',Session::get('merchantId'))->where('status',3)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelhold =Parcel::where('merchantId',Session::get('merchantId'))->where('status',5)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelrrtupa =Parcel::where('merchantId',Session::get('merchantId'))->where('status',6)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelrrhub =Parcel::where('merchantId',Session::get('merchantId'))->where('status',7)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelprice =Parcel::where('merchantId',Session::get('merchantId'))->whereBetween('updated_at', [$request->startDate, $request->endDate])->where('status','!=',9)->sum('cod');
    $parcelamount =Parcel::where('merchantId',Session::get('merchantId'))->whereBetween('updated_at', [$request->startDate, $request->endDate])->sum('merchantPaid');
    $parcelcount =Parcel::where('merchantId',Session::get('merchantId'))->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
        $allparcel = DB::table('parcels')
        ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.merchantId',Session::get('merchantId'))
        ->whereBetween('parcels.updated_at',[$request->startDate, $request->endDate])
        ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->orderBy('id','DESC')
        ->get();
       }elseif($request->trackId!=NULL || $request->phoneNumber!=NULL && $request->startDate!=NULL && $request->endDate!=NULL){
        $parcelr =Parcel::where('merchantId',Session::get('merchantId'))->where('status',4)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelc =Parcel::where('merchantId',Session::get('merchantId'))->where('status',9)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelre =Parcel::where('merchantId',Session::get('merchantId'))->where('status',8)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelpa =Parcel::where('merchantId',Session::get('merchantId'))->where('status',1)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelpictd =Parcel::where('merchantId',Session::get('merchantId'))->where('status',2)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelinterjit =Parcel::where('merchantId',Session::get('merchantId'))->where('status',3)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelhold =Parcel::where('merchantId',Session::get('merchantId'))->where('status',5)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelrrtupa =Parcel::where('merchantId',Session::get('merchantId'))->where('status',6)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelrrhub =Parcel::where('merchantId',Session::get('merchantId'))->where('status',7)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelprice =Parcel::where('merchantId',Session::get('merchantId'))->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->where('status','!=',9)->sum('cod');
    $parcelamount =Parcel::where('merchantId',Session::get('merchantId'))->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->sum('merchantPaid');
    $parcelcount =Parcel::where('merchantId',Session::get('merchantId'))->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
        $allparcel = DB::table('parcels')
        ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.merchantId',Session::get('merchantId'))
        ->where('parcels.recipientPhone',$request->phoneNumber)
        ->whereBetween('parcels.updated_at',[$request->startDate, $request->endDate])
        ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->orderBy('id','DESC')
        ->get();
       }else{
    $parcelr =Parcel::where('merchantId',Session::get('merchantId'))->where('status',$aparceltypes->id)->where('status',4)->count();
    $parcelc =Parcel::where('merchantId',Session::get('merchantId'))->where('status',$aparceltypes->id)->where('status',9)->count();
    $parcelre =Parcel::where('merchantId',Session::get('merchantId'))->where('status',$aparceltypes->id)->where('status',8)->count();
    $parcelpa =Parcel::where('merchantId',Session::get('merchantId'))->where('status',$aparceltypes->id)->where('status',1)->count();
    $parcelpictd =Parcel::where('merchantId',Session::get('merchantId'))->where('status',$aparceltypes->id)->where('status',2)->count();
    $parcelinterjit =Parcel::where('merchantId',Session::get('merchantId'))->where('status',$aparceltypes->id)->where('status',3)->count();
    $parcelhold =Parcel::where('merchantId',Session::get('merchantId'))->where('status',$aparceltypes->id)->where('status',5)->count();
    $parcelrrtupa =Parcel::where('merchantId',Session::get('merchantId'))->where('status',$aparceltypes->id)->where('status',6)->count();
    $parcelrrhub =Parcel::where('merchantId',Session::get('merchantId'))->where('status',$aparceltypes->id)->where('status',7)->count();
    $parcelprice =Parcel::where('merchantId',Session::get('merchantId'))->where('status',$aparceltypes->id)->sum('cod');
    $parcelamount =Parcel::where('merchantId',Session::get('merchantId'))->where('status',$aparceltypes->id)->sum('merchantPaid');
    $parcelcount =Parcel::where('merchantId',Session::get('merchantId'))->where('status',$aparceltypes->id)->count();
        $allparcel = DB::table('parcels')
        ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.merchantId',Session::get('merchantId'))->where('parcels.status',$aparceltypes->id)
         ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->orderBy('id','DESC')
        ->get();
      
       }
        
      return view('frontEnd.layouts.pages.merchant.parcels',compact('allparcel','parcelr','parcelc','parcelre','parcelpa','parcelpictd','parcelinterjit','parcelhold','parcelrrtupa','parcelrrhub','parcelprice','parcelamount','parcelcount'));
  }
  
  public function report(Request $request){
    $parcelr =Parcel::where('merchantId',Session::get('merchantId'))->where('status',4)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelc =Parcel::where('merchantId',Session::get('merchantId'))->where('status',9)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelre =Parcel::where('merchantId',Session::get('merchantId'))->where('status',8)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelpa =Parcel::where('merchantId',Session::get('merchantId'))->where('status',1)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelpictd =Parcel::where('merchantId',Session::get('merchantId'))->where('status',2)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelinterjit =Parcel::where('merchantId',Session::get('merchantId'))->where('status',3)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelhold =Parcel::where('merchantId',Session::get('merchantId'))->where('status',5)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelrrtupa =Parcel::where('merchantId',Session::get('merchantId'))->where('status',6)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelrrhub =Parcel::where('merchantId',Session::get('merchantId'))->where('status',7)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    $parcelprice =Parcel::where('merchantId',Session::get('merchantId'))->whereBetween('updated_at', [$request->startDate, $request->endDate])->where('status','!=',9)->sum('cod');
    $parcelamount =Parcel::where('merchantId',Session::get('merchantId'))->whereBetween('updated_at', [$request->startDate, $request->endDate])->sum('merchantPaid');
    $parcelcount =Parcel::where('merchantId',Session::get('merchantId'))->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
    return view('frontEnd.layouts.pages.merchant.report')->with('parcelr',$parcelr)->with('parcelcount',$parcelcount)->with('parcelc',$parcelc)->with('parcelprice',$parcelprice)->with('parcelamount',$parcelamount)->with('parcelpa',$parcelpa)->with('parcelpictd',$parcelpictd)->with('parcelinterjit',$parcelinterjit)->with('parcelhold',$parcelhold)->with('parcelhold',$parcelhold)->with('parcelrrtupa',$parcelrrtupa)->with('parcelre',$parcelre)->with('parcelrrhub',$parcelrrhub);
  }
  public function parceldetails($id){
    $parceldetails= DB::table('parcels')
        ->join('nearestzones', 'parcels.reciveZone','=','nearestzones.id')
         ->where(['parcels.merchantId'=>Session::get('merchantId'),'parcels.id'=>$id])
        ->select('parcels.*','nearestzones.zonename')
        ->first();
      $trackInfos = Parcelnote::where('parcelId',$id)->orderBy('id','ASC')->get();
      return view('frontEnd.layouts.pages.merchant.parceldetails',compact('parceldetails','trackInfos'));
  }
   public function invoice($id){
    $show_data = DB::table('parcels')
    ->join('merchants', 'merchants.id','=','parcels.merchantId')
    ->where(['parcels.merchantId'=>Session::get('merchantId'),'parcels.id'=>$id])
    ->join('nearestzones', 'parcels.reciveZone','=','nearestzones.id')
    ->where('parcels.id',$id)
    ->select('parcels.*','nearestzones.zonename','merchants.companyName','merchants.phoneNumber','merchants.emailAddress')
    ->first();
        if($show_data!=NULL){
        	return view('frontEnd.layouts.pages.merchant.invoice',compact('show_data'));
        }else{
          Toastr::error('Opps!', 'Your process wrong');
          return redirect()->back();
        }
    }
  public function parceledit($id){
      $parceledit=Parcel::where(['merchantId'=>Session::get('merchantId'),'id'=>$id])->first();
      if($parceledit !=NULL){
      $ordertype = Deliverycharge::find($parceledit->orderType);
      $codcharge = Codcharge::find($parceledit->codType);
      $areas = Nearestzone::where('status',1)->get();
      Session::put('codpay',$parceledit->cod);
      Session::put('pcodecharge',$parceledit->codCharge);
      Session::put('pdeliverycharge',$parceledit->deliveryCharge);
      return view('frontEnd.layouts.pages.merchant.parceledit',compact('ordertype','codcharge','parceledit','areas'));
      }else{
         Toastr::error('Opps!', 'Your process wrong');
         return redirect()->back();
      }
  }
  
public function parcelupdate(Request $request){
     $this->validate($request,[
        'cod'=>'required',
        'name'=>'required',
        'address'=>'required',
        'phonenumber'=>'required',
      ]);
         // fixed delivery charge
        if($request->weight > 1 || $request->weight !=NULL){
          $extraweight = $request->weight-1;
          $deliverycharge = (Session::get('deliverycharge')*1)+($extraweight*Session::get('extradeliverycharge'));
          $weight = $request->weight;
         }else{
          $deliverycharge = (Session::get('deliverycharge'));
          $weight = 1;
         }

         // fixed cod charge
         if($request->cod > 100){
          $extracod=$request->cod -100;
          $extracodcharge = $extracod/100;
          $codcharge = Session::get('codcharge')+$extracodcharge;
         }else{
          $codcharge= Session::get('codcharge');
         }
         $update_parcel = Parcel::find($request->hidden_id);
         $update_parcel->invoiceNo = $request->invoiceno;
         $update_parcel->merchantId = Session::get('merchantId');
         $update_parcel->cod = $request->cod;
         $update_parcel->percelType = $request->percelType;
         $update_parcel->recipientName = $request->name;
         $update_parcel->recipientAddress = $request->address;
         $update_parcel->recipientPhone = $request->phonenumber;
         $update_parcel->productWeight = $weight;
         $update_parcel->note = $request->note;
        $update_parcel->reciveZone = $request->reciveZone;
         $update_parcel->deliveryCharge = $deliverycharge;
         $update_parcel->codCharge = $codcharge;
         $update_parcel->orderType = Session::get('ordertype');
         $update_parcel->codType = Session::get('codtype');
         $update_parcel->save();
         Toastr::success('Success!', 'Thanks! your parcel update successfully');
         return redirect()->back();
  }
  public function singleservice(Request $request){
      $data = array(
              'contact_mail' => 'info@flingex.com',
              'address' => $request->address,
              'area' => $request->area,
              'note' => $request->note,
              'estimate' => $request->estimate,
            );
            // $send = Mail::send('frontEnd.emails.singleservice', $data, function($textmsg) use ($data){
            //  $textmsg->to($data['contact_mail']);
            //  $textmsg->subject('A Single Service Request');
            // });
            $pickdroup= new PickDrop;
            $pickdroup->address=$request->address;
            $pickdroup->area=$request->area;
            $pickdroup->note=$request->note;
            $pickdroup->estimate=$request->estimate;
            $pickdroup->phone=$request->phone;
            $pickdroup->price=150;
            $pickdroup->status='New';
            $pickdroup->save();
            
        Toastr::success('Success!', 'Thanks! your  request send successfully');
        return redirect()->back();
  }
  public function payments(){
      $merchantInvoice = Merchantpayment::where('merchantId',Session::get('merchantId'))->get();
      return view('frontEnd.layouts.pages.merchant.payments',compact('merchantInvoice'));
  }
  public function inovicedetails($id){
        $invoiceInfo = Merchantpayment::find($id);
        $inovicedetails = Parcel::where('paymentInvoice',$id)->get();
        return view('frontEnd.layouts.pages.merchant.inovicedetails',compact('inovicedetails','invoiceInfo'));
    }
   public function passreset(){
      return view('frontEnd.layouts.pages.passreset');
    }
    public function passfromreset(Request $request){
      $this->validate($request,[
            'phoneNumber' => 'required',
        ]);
        $validMerchant = Merchant::Where('phoneNumber',$request->phoneNumber)
       ->first();
        if($validMerchant){
            
            $verifyToken=rand(111111,999999);
    	     $validMerchant->passwordReset 	=	$verifyToken;
             $validMerchant->save();
             Session::put('resetCustomerId',$validMerchant->id);
             
             $data = array(
             'contact_mail' => $validMerchant->phoneNumber,
             'verifyToken' => $verifyToken,
            );
            $send = Mail::send('frontEnd.emails.passwordreset', $data, function($textmsg) use ($data){
             $textmsg->from('info@flingex.com');
             $textmsg->to($data['contact_mail']);
             $textmsg->subject('Forget password token');
            });
            
  
 
         return redirect('/merchant/resetpassword/verify');
        }else{
              Toastr::error('Sorry! You have no account', 'warning!');
             return redirect()->back();
        }
        
        
        
        
        
        
        
    }
    public function resetpasswordverify(){
        if(Session::get('resetCustomerId')){
        return view('frontEnd.layouts.pages.passwordresetverify');
        }else{
            Toastr::error('Sorry! Your process something wrong', 'warning!');
            return redirect('forget/password');
        }
    }
    public function saveResetPassword(Request $request){
       $validMerchant = Merchant::find(Session::get('resetCustomerId'));
        if($validMerchant->passwordReset==$request->verifyPin){
    	     $validMerchant->password 	=	bcrypt(request('newPassword'));
    	     $validMerchant->passwordReset 	=	NULL;
             $validMerchant->save();
             
             Session::forget('resetCustomerId');
             Session::put('merchantId',$validMerchant->id);
             Toastr::success('Wow! Your password reset successfully', 'success!');
             return redirect('/merchant/dashboard');
        }else{
            Toastr::error('Sorry! Your process something wrong', 'warning!');
             return redirect()->back();
        }
       
    }
    public function parceltrack(Request $request){
         $trackparcel = DB::table('parcels')
        ->join('nearestzones', 'parcels.reciveZone','=','nearestzones.id')
         ->where('parcels.trackingCode','LIKE','%'.$request->trackid."%")
         ->select('parcels.*','nearestzones.zonename')
         ->orderBy('id','DESC')
         ->first();
         
        if($trackparcel){
            $trackInfos = Parcelnote::where('parcelId',$trackparcel->id)->orderBy('id','ASC')->get();
            return view('frontEnd.layouts.pages.merchant.trackparcel',compact('trackparcel','trackInfos'));
        }else{
            return redirect()->back();
        }
    }
    public function import(Request $request)
    {   
        // return 1;
        // dd(request()->file('excel'));
     Excel::import(new ParcelImport,request()->file('excel'));
  
      Toastr::success('Wow! Bulk uploaded', 'success!');
      return redirect()->back();
    }
    public function export( Request $request ) {
        return Excel::download( new ParcelExport(), 'parcel.xlsx') ;
    
    }

}