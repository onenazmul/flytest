<?php

namespace App\Http\Controllers\Editor;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Parcel;
use App\Codcharge;
use App\Deliveryman;
use App\Deliverycharge;
use App\Nearestzone;
use App\Imports\AdminParcelimport;
use App\Merchant;
use DB;
use Auth;
use App\Post;
use App\Parcelnote;
use App\Parceltype;
use Mail;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
class ParcelManageController extends Controller
{
    public function parcel(Request $request){
        
       $parceltype = Parceltype::where('slug',$request->slug)->first();
        if($request->trackId!=NULL){
         $show_data = DB::table('parcels')
          ->join('merchants', 'merchants.id','=','parcels.merchantId')
          ->join('nearestzones', 'parcels.reciveZone','=','nearestzones.id')
          ->where('parcels.status',$parceltype->id)
          ->where('parcels.trackingCode',$request->trackId)
          ->orderBy('id','DESC')
          ->select('parcels.*','nearestzones.zonename','merchants.firstName','merchants.lastName','merchants.pickLocation','merchants.pickLocation','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
          ->get();
       }elseif($request->merchantId!=NULL){
         $show_data = DB::table('parcels')
          ->join('merchants', 'merchants.id','=','parcels.merchantId')
          ->join('nearestzones', 'parcels.reciveZone','=','nearestzones.id')
          ->where('parcels.status',$parceltype->id)
          ->where('parcels.merchantId',$request->merchantId)
          ->orderBy('id','DESC')
          ->select('parcels.*','nearestzones.zonename','merchants.firstName','merchants.lastName','merchants.pickLocation','merchants.pickLocation','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
      ->get();
       }elseif($request->phoneNumber!=NULL){
        $show_data = DB::table('parcels')
          ->join('merchants', 'merchants.id','=','parcels.merchantId')
          ->join('nearestzones', 'parcels.reciveZone','=','nearestzones.id')
          ->where('parcels.status',$parceltype->id)
          ->where('parcels.recipientPhone',$request->phoneNumber)
          ->orderBy('id','DESC')
          ->select('parcels.*','nearestzones.zonename','merchants.firstName','merchants.lastName','merchants.pickLocation','merchants.pickLocation','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
       ->get();
       }elseif($request->startDate!=NULL && $request->endDate!=NULL){
        $show_data = DB::table('parcels')
          ->join('merchants', 'merchants.id','=','parcels.merchantId')
          ->join('nearestzones', 'parcels.reciveZone','=','nearestzones.id')
          ->where('parcels.status',$parceltype->id)
          ->whereBetween('parcels.created_at',[$request->startDate, $request->endDate])
          ->orderBy('id','DESC')
          ->select('parcels.*','nearestzones.zonename','merchants.firstName','merchants.lastName','merchants.pickLocation','merchants.pickLocation','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->get();
       }elseif($request->phoneNumber!=NULL  && $request->startDate!=NULL && $request->endDate!=NULL){
         $show_data = DB::table('parcels')
          ->join('merchants', 'merchants.id','=','parcels.merchantId')
          ->join('nearestzones', 'parcels.reciveZone','=','nearestzones.id')
          ->where('parcels.status',$parceltype->id)
          ->where('parcels.recipientPhone',$request->phoneNumber)
          ->whereBetween('parcels.created_at',[$request->startDate, $request->endDate])
          ->orderBy('id','DESC')
          ->select('parcels.*','nearestzones.zonename','merchants.firstName','merchants.lastName','merchants.pickLocation','merchants.pickLocation','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->get();
       }elseif($request->merchantId!=NULL && $request->startDate!=NULL && $request->endDate!=NULL){
         $show_data = DB::table('parcels')
          ->join('merchants', 'merchants.id','=','parcels.merchantId')
          ->join('nearestzones', 'parcels.reciveZone','=','nearestzones.id')
          ->where('parcels.status',$parceltype->id)
          ->where('parcels.merchantId',$request->merchantId)
          ->whereBetween('parcels.created_at',[$request->startDate, $request->endDate])
          ->orderBy('id','DESC')
          ->select('parcels.*','nearestzones.zonename','merchants.firstName','merchants.lastName','merchants.pickLocation','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->get();
       }else{
        $show_data = DB::table('parcels')
         ->join('merchants', 'merchants.id','=','parcels.merchantId')
         ->join('nearestzones', 'parcels.reciveZone','=','nearestzones.id')
         ->where('parcels.status',$parceltype->id)
         ->orderBy('id','DESC')
         ->select('parcels.*','nearestzones.zonename','merchants.firstName','merchants.lastName','merchants.pickLocation','merchants.pickLocation','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->get();
        }
    	return view('backEnd.parcel.parcel',compact('show_data','parceltype'));
    }

    public function allparcel(Request $request){
          $parceltype = 'All Parcel';
        if($request->trackId!=NULL){
         $show_data = DB::table('parcels')
          ->join('merchants', 'merchants.id','=','parcels.merchantId')
          ->join('nearestzones', 'parcels.reciveZone','=','nearestzones.id')
          ->where('parcels.trackingCode',$request->trackId)
          ->orderBy('id','DESC')
          ->select('parcels.*','nearestzones.zonename','merchants.firstName','merchants.lastName','merchants.pickLocation','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
          ->paginate(50);
       }elseif($request->merchantId!=NULL){
         $show_data = DB::table('parcels')
          ->join('merchants', 'merchants.id','=','parcels.merchantId')
          ->join('nearestzones', 'parcels.reciveZone','=','nearestzones.id')
          ->where('parcels.merchantId',$request->merchantId)
          ->orderBy('id','DESC')
          ->select('parcels.*','nearestzones.zonename','merchants.firstName','merchants.lastName','merchants.pickLocation','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
      ->paginate(50);
       }elseif($request->phoneNumber!=NULL){
        $show_data = DB::table('parcels')
          ->join('merchants', 'merchants.id','=','parcels.merchantId')
          ->join('nearestzones', 'parcels.reciveZone','=','nearestzones.id')
          ->where('parcels.recipientPhone',$request->phoneNumber)
          ->orderBy('id','DESC')
          ->select('parcels.*','nearestzones.zonename','merchants.firstName','merchants.lastName','merchants.pickLocation','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
       ->paginate(50);
       }elseif($request->startDate!=NULL && $request->endDate!=NULL){
        $show_data = DB::table('parcels')
          ->join('merchants', 'merchants.id','=','parcels.merchantId')
          ->join('nearestzones', 'parcels.reciveZone','=','nearestzones.id')
          ->whereBetween('parcels.created_at',[$request->startDate, $request->endDate])
          ->orderBy('id','DESC')
          ->select('parcels.*','nearestzones.zonename','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.pickLocation','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->paginate(50);
       }elseif($request->phoneNumber!=NULL  && $request->startDate!=NULL && $request->endDate!=NULL){
         $show_data = DB::table('parcels')
          ->join('merchants', 'merchants.id','=','parcels.merchantId')
          ->join('nearestzones', 'parcels.reciveZone','=','nearestzones.id')
          ->where('parcels.recipientPhone',$request->phoneNumber)
          ->whereBetween('parcels.created_at',[$request->startDate, $request->endDate])
          ->orderBy('id','DESC')
          ->select('parcels.*','nearestzones.zonename','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.pickLocation','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->paginate(50);
       }elseif($request->merchantId!=NULL && $request->startDate!=NULL && $request->endDate!=NULL){
         $show_data = DB::table('parcels')
          ->join('merchants', 'merchants.id','=','parcels.merchantId')
          ->join('nearestzones', 'parcels.reciveZone','=','nearestzones.id')
          ->where('parcels.merchantId',$request->merchantId)
          ->whereBetween('parcels.created_at',[$request->startDate, $request->endDate])
          ->orderBy('id','DESC')
          ->select('parcels.*','nearestzones.zonename','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.pickLocation','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->paginate(50);
       }else{
        $show_data = DB::table('parcels')
         ->join('merchants', 'merchants.id','=','parcels.merchantId')
         ->join('nearestzones', 'parcels.reciveZone','=','nearestzones.id')
         ->orderBy('id','DESC')
         ->select('parcels.*','nearestzones.zonename','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.pickLocation','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->paginate(50);
        }
        
        
       
        //   $show_data = DB::table('parcels')
        //  ->join('merchants', 'merchants.id','=','parcels.merchantId')
        //  ->join('nearestzones', 'parcels.reciveZone','=','nearestzones.id')
        //  ->orderBy('id','DESC')
        //  ->select('parcels.*','nearestzones.zonename','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        // ->get();
        return view('backEnd.parcel.allparcel',compact('show_data','parceltype'));
    }
    public function invoice($id){
    	    $show_data = DB::table('parcels')
    	    ->join('merchants', 'merchants.id','=','parcels.merchantId')
    	    ->join('nearestzones', 'parcels.reciveZone','=','nearestzones.id')
    	    ->where('parcels.id',$id)
    	    ->select('parcels.*','nearestzones.zonename','merchants.companyName','merchants.phoneNumber','merchants.emailAddress')
            ->first();
    	return view('backEnd.parcel.invoice',compact('show_data'));
    }

       public function agentasign(Request $request){
    	$this->validate($request,[
    		'agentId'=>'required',
    	]);
    	$parcel = Parcel::find($request->hidden_id);
    	$parcel->agentId = $request->agentId;
    	$parcel->save();

        if($request->note){
            $note = new Parcelnote();
            $note->parcelId = $request->hidden_id;
            $note->note = $request->note;
            $note->save();
        }

    	Toastr::success('message', 'A agent asign successfully!');
    	return redirect()->back();
    }
    public function partial_pay(Request $request){
      $parcel = Parcel::find($request->id);
    	$parcel->partial_pay = $request->partial_pay;
    	$parcel->save();
      Toastr::success('message', 'Partial Pay Add successfully!');
    	return redirect()->back();

    }
    public function deliverymanasign(Request $request){
      $this->validate($request,[
        'deliverymanId'=>'required',
      ]);
      $parcel = Parcel::find($request->hidden_id);
      $parcel->deliverymanId = $request->deliverymanId;
      $parcel->save();

      if($request->note){
            $note = new Parcelnote();
            $note->parcelId = $request->hidden_id;
            $note->note = $request->note;
            $note->save();
        }

      Toastr::success('message', 'A deliveryman asign successfully!');
      return redirect()->back();
      $deliverymanInfo = Deliveryman::find($parcel->deliverymanId);
      $merchantinfo =Merchant::find($parcel->merchantId);
      $data = array(
       'contact_mail' => $merchantinfo->emailAddress,
       'ridername' => $deliverymanInfo->name,
       'riderphone' => $deliverymanInfo->phone,
       'codprice' => $parcel->cod,
       'trackingCode' => $parcel->trackingCode,
      );
      $send = Mail::send('frontEnd.emails.percelassign', $data, function($textmsg) use ($data){
       $textmsg->from('info@flingex.com');
       $textmsg->to($data['contact_mail']);
       $textmsg->subject('Percel Assign Notification');
      });
        
  }
    public function statusupdate(Request $request){
    	$this->validate($request,[
    		'status'=>'required',
    	]); 
      $parceltype=Parceltype::where('id',$request->status)->first();
    	$parcel = Parcel::find($request->hidden_id);
    	$parcel->status = $request->status;
    	$parcel->present_date =date("Y-m-d");
    	$parcel->save();

              if($request->note){
            $note = new Parcelnote();
            $note->parcelId = $request->hidden_id;            
            $note->note = $request->note;
            $note->parcelStatus = $parceltype->title;
            $note->user=Auth::user()->username;
            $note->save();
        }
        if($request->snote){
          $note = new Parcelnote();
          $note->parcelId = $request->hidden_id;            
          $note->note = $request->snote;
          $note->parcelStatus = $parceltype->title;
          $note->user=Auth::user()->username;
          $note->save();
      }
      if($request->snote && $request->note){
        $note = new Parcelnote();
        $note->parcelId = $request->hidden_id;            
        $note->note = $request->snote;
        $note->parcelStatus = $parceltype->title;
        $note->user=Auth::user()->username;
        $note->save();
    }

        if($request->status==4){
            // $codcharge=$request->customerpay/100;
            $codcharge=0;
            $parcel->merchantAmount=($parcel->merchantAmount)-($codcharge);
            $parcel->merchantDue=($parcel->merchantAmount)-($codcharge);
            $parcel->codCharge=$codcharge;
            $parcel->save();
            $validMerchant =Merchant::find($parcel->merchantId);
              $url = "http://66.45.237.70/api.php";
                $number="0$validMerchant->phoneNumber";
                $text="Dear Merchant, 
              Your Parcel Tracking ID $parcel->trackingCode for $validMerchant->companyName , $validMerchant->phoneNumber is on Deliverd. see comment section on Orders. \r\n Regards,\r\n Flingex";
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
              
        }elseif($request->status==5){
            // $codcharge=$request->customerpay/100;
            $codcharge=0;
            $parcel->merchantAmount=($parcel->merchantAmount)-($codcharge);
            $parcel->merchantDue=($parcel->merchantAmount)-($codcharge);
            $parcel->codCharge=$codcharge;
            $parcel->save();
            $validMerchant =Merchant::find($parcel->merchantId);
          
            $url = "http://66.45.237.70/api.php";
                $number="0$validMerchant->phoneNumber";
                $text="Dear $validMerchant->companyName \r\n Your Parcel Tracking ID $parcel->trackingCode for $parcel->recipientName , $parcel->recipientPhone is on Hold. see comment section on Orders. \r\n Regards,\r\n Flingex";
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
        }
          elseif($request->status==8){
          // $codcharge=$request->customerpay/100;
          $codcharge=0;
          $parcel->merchantAmount=0;
          $parcel->merchantDue=0;
          $parcel->codCharge=$codcharge;
          $parcel->cod=0;
          $parcel->save();
          
          $validMerchant =Merchant::find($parcel->merchantId);
          $deliveryMan = Deliveryman::find($parcel->deliverymanId);
          $readytaka = $parcel->cod+$parcel->deliveryCharge;
        //   $url = "http://premium.mdlsms.com/smsapi";
        //     $data = [
        //       "api_key" => "C2000829604b00d0ccad46.26595828",
        //       "type" => "text",
        //       "contacts" => "0$parcel->recipientPhone",
        //       "senderid" => "8809612441280",
        //       "msg" => "Dear @$parcel->recipientName \r\nYour parcel from @$validMerchant->companyName, Tracking ID $parcel->trackingCode will be delivered by $deliveryMan->name, 0$deliveryMan->phone. Please keep TK. $readytaka ready.\r\n Regards,\r\n PackeN Move",
        //     ];
        //     $ch = curl_init();
        //     curl_setopt($ch, CURLOPT_URL, $url);
        //     curl_setopt($ch, CURLOPT_POST, 1);
        //     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //     $response = curl_exec($ch);
        //     curl_close($ch);
       }
        elseif($request->status==6){
            // $codcharge=$request->customerpay/100;
            $codcharge=0;
            $parcel->merchantAmount=($parcel->merchantAmount)-($codcharge);
            $parcel->merchantDue=($parcel->merchantAmount)-($codcharge);
            $parcel->codCharge=$codcharge;
            $parcel->save();
            $validMerchant =Merchant::find($parcel->merchantId);
            $url = "http://66.45.237.70/api.php";
                $number="0$validMerchant->phoneNumber";
                $text="Dear $validMerchant->companyName \r\n Your Parcel Tracking ID $parcel->trackingCode for $validMerchant->companyName , $validMerchant->phoneNumber will be return within 48 hours. see comment section on Orders.\r\n Regards,\r\n Flingex";
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
        }
        elseif($request->status==3){
            // $codcharge=$request->customerpay/100;
            $codcharge=0;
            $parcel->merchantAmount=($parcel->merchantAmount)-($codcharge);
            $parcel->merchantDue=($parcel->merchantAmount)-($codcharge);
            $parcel->codCharge=$codcharge;
            $parcel->save();
            
            $validMerchant =Merchant::find($parcel->merchantId);
            $deliveryMan = Deliveryman::find($parcel->deliverymanId);
            $readytaka = $parcel->cod;
            
              
              $url = "http://66.45.237.70/api.php";
                $number="0$parcel->recipientPhone";
                $text="Dear $parcel->recipientName \r\nYour parcel from $validMerchant->companyName, Tracking ID $parcel->trackingCode will be delivered by $deliveryMan->name, $deliveryMan->phone. Please keep TK. $readytaka ready.\r\n Regards,\r\n Flingex";
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
              
         }
         elseif($request->status==2){
            $deliverymanInfo =Deliveryman::where(['id'=>$parcel->deliverymanId])->first();
            $merchantinfo =Merchant::find($parcel->merchantId);
            if($deliverymanInfo !=NULL){
            $data = array(
             'contact_mail' => $merchantinfo->emailAddress,
             'ridername' => $deliverymanInfo->name,
             'riderphone' => $deliverymanInfo->phone,
             'codprice' => $parcel->cod,
             'trackingCode' => $parcel->trackingCode,
            );
            $send = Mail::send('frontEnd.emails.percelassign', $data, function($textmsg) use ($data){
             $textmsg->from('info@flingex.com');
             $textmsg->to($data['contact_mail']);
             $textmsg->subject('Percel Assign Notification');
            });
          }
        }
         elseif($request->status==9){
            $merchantinfo =Merchant::find($parcel->merchantId);
             $data = array(
             'contact_mail' => $merchantinfo->emailAddress,
             'trackingCode' => $parcel->trackingCode,
            );
             $send = Mail::send('frontEnd.emails.percelcancel', $data, function($textmsg) use ($data){
             $textmsg->from('info@flingex.com');
             $textmsg->to($data['contact_mail']);
             $textmsg->subject('Percel Cancelled Notification');
            });
        }
    	Toastr::success('message', 'Parcel information update successfully!');
    	return redirect()->back();
    }

    public function create(){
        $merchants = Merchant::orderBy('id','DESC')->get();
          $areas = Nearestzone::where('status',1)->get();
        $delivery=Deliverycharge::where('status',1)->get();
        return view('backEnd.addparcel.create',compact('merchants','delivery','areas'));
    }
    public function parcelreport(Request $request){
      if($request->mid=='Allmarcent'){
          $id=$request->mid;
        $merchants = Merchant::orderBy('id','DESC')->get();
        $parcelr =Parcel::where('status',4)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelc =Parcel::where('status',9)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelre =Parcel::where('status',8)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelpa =Parcel::where('status',1)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $paid =Parcel::where('status','!=',9)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('merchantPaid');
      $unpaid =Parcel::where('status','!=',9)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('merchantDue');
      $parcelpictd =Parcel::where('status',2)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelinterjit =Parcel::where('status',3)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelhold =Parcel::where('status',5)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelrrtupa =Parcel::where('status',6)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelrrhub =Parcel::where('status',7)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
  
      $parcelpriceCOD =Parcel::where('status','!=',9)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('cod');
  // dd($parcelprice);
      $deliveryCharge= $parcelprice =Parcel::whereBetween('created_at', [$request->startDate, $request->endDate])->where('status','!=',9)->sum('deliveryCharge');
  
      $codCharge= $parcelprice =Parcel::whereBetween('created_at', [$request->startDate, $request->endDate])->where('status','!=',9)->sum('codCharge');
  
      $Collectedamount =Parcel::where('status',4)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('cod');
  
      $parcelcount =Parcel::whereBetween('created_at', [$request->startDate, $request->endDate])->count();
  
      }else{
      $id=$request->mid;
      $merchants = Merchant::orderBy('id','DESC')->get();
      $parcelr =Parcel::where('merchantId',$request->mid)->where('status',4)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelc =Parcel::where('merchantId',$request->mid)->where('status',9)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelre =Parcel::where('merchantId',$request->mid)->where('status',8)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelpa =Parcel::where('merchantId',$request->mid)->where('status',1)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $paid =Parcel::where('status','!=',9)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('merchantPaid');
      $unpaid =Parcel::where('status','!=',9)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('merchantDue');
      $parcelpictd =Parcel::where('merchantId',$request->mid)->where('status',2)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelinterjit =Parcel::where('merchantId',$request->mid)->where('status',3)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelhold =Parcel::where('merchantId',$request->mid)->where('status',5)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelrrtupa =Parcel::where('merchantId',$request->mid)->where('status',6)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelrrhub =Parcel::where('merchantId',$request->mid)->where('status',7)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
  
      $parcelpriceCOD =Parcel::where('merchantId',$request->mid)->where('status','!=',9)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('cod');
  // dd($parcelprice);
      $deliveryCharge= $parcelprice =Parcel::where('merchantId',$request->mid)->whereBetween('created_at', [$request->startDate, $request->endDate])->where('status','!=',9)->sum('deliveryCharge');
  
      $codCharge= $parcelprice =Parcel::where('merchantId',$request->mid)->whereBetween('created_at', [$request->startDate, $request->endDate])->where('status','!=',9)->sum('codCharge');
  
      $Collectedamount =Parcel::where('merchantId',$request->mid)->where('status',4)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('cod');
  
      $parcelcount =Parcel::where('merchantId',$request->mid)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      }
  
      return view('backEnd.addparcel.report')->with('parcelr',$parcelr)->with('paid',$paid)->with('unpaid',$unpaid)->with('parcelcount',$parcelcount)->with('parcelc',$parcelc)->with('parcelpriceCOD',$parcelpriceCOD)->with('parcelpa',$parcelpa)->with('parcelre',$parcelre)->with('merchants',$merchants)->with('id',$id)->with('parcelpictd',$parcelpictd)->with('parcelinterjit',$parcelinterjit)->with('parcelhold',$parcelhold)->with('parcelrrtupa',$parcelrrtupa)->with('parcelrrhub',$parcelrrhub)->with('deliveryCharge',$deliveryCharge)->with('codCharge',$codCharge)->with('Collectedamount',$Collectedamount);
      }
      
       public function report(Request $request){
      if($request->mid=='Allmarcent'){
           $show_data = DB::table('parcels')
            ->join('merchants', 'merchants.id','=','parcels.merchantId')
            ->join('nearestzones', 'parcels.reciveZone','=','nearestzones.id')
            ->whereBetween('parcels.created_at', [$request->startDate, $request->endDate])
            ->orderBy('id','DESC')
            ->select('parcels.*','nearestzones.zonename','merchants.firstName','merchants.lastName','merchants.pickLocation','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->get();
          $id=$request->mid;
        $merchants = Merchant::orderBy('id','DESC')->get();
        $parcelr =Parcel::where('status',4)->whereBetween('parcels.created_at', [$request->startDate, $request->endDate])->count();
      $parcelc =Parcel::where('status',9)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelre =Parcel::where('status',8)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelpa =Parcel::where('status',1)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
  
      $parcelpictd =Parcel::where('status',2)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelinterjit =Parcel::where('status',3)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelhold =Parcel::where('status',5)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelrrtupa =Parcel::where('status',6)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelrrhub =Parcel::where('status',7)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
  
      $parcelpriceCOD =Parcel::where('status','!=',9)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('cod');
      $paid =Parcel::where('status','!=',9)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('merchantPaid');
      $unpaid =Parcel::where('status','!=',9)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('merchantDue');
  // dd($parcelprice);
      $deliveryCharge= $parcelprice =Parcel::whereBetween('created_at', [$request->startDate, $request->endDate])->where('status','!=',9)->sum('deliveryCharge');
  
      $codCharge= $parcelprice =Parcel::whereBetween('created_at', [$request->startDate, $request->endDate])->where('status','!=',9)->sum('codCharge');
  
      $Collectedamount =Parcel::where('status',4)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('cod');
  
      $parcelcount =Parcel::whereBetween('created_at', [$request->startDate, $request->endDate])->count();
  
      }else{
          $show_data = DB::table('parcels')
            ->join('merchants', 'merchants.id','=','parcels.merchantId')
            ->join('nearestzones', 'parcels.reciveZone','=','nearestzones.id')
            ->where('parcels.merchantId',$request->mid)->whereBetween('parcels.created_at', [$request->startDate, $request->endDate])
            ->orderBy('id','DESC')
            ->select('parcels.*','nearestzones.zonename','merchants.firstName','merchants.lastName','merchants.pickLocation','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->get();
        
      $id=$request->mid;
       $paid =Parcel::where('merchantId',$request->mid)->where('status',4)->where('status','!=',9)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('merchantPaid');
      $unpaid =Parcel::where('merchantId',$request->mid)->where('status',4)->where('status','!=',9)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('merchantDue');
      $merchants = Merchant::orderBy('id','DESC')->get();
      $parcelr =Parcel::where('merchantId',$request->mid)->where('status',4)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelc =Parcel::where('merchantId',$request->mid)->where('status',9)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelre =Parcel::where('merchantId',$request->mid)->where('status',8)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelpa =Parcel::where('merchantId',$request->mid)->where('status',1)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
  
      $parcelpictd =Parcel::where('merchantId',$request->mid)->where('status',2)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelinterjit =Parcel::where('merchantId',$request->mid)->where('status',3)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelhold =Parcel::where('merchantId',$request->mid)->where('status',5)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelrrtupa =Parcel::where('merchantId',$request->mid)->where('status',6)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      $parcelrrhub =Parcel::where('merchantId',$request->mid)->where('status',7)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
  
      $parcelpriceCOD =Parcel::where('merchantId',$request->mid)->where('status','!=',9)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('cod');
  // dd($parcelprice);
      $deliveryCharge= $parcelprice =Parcel::where('merchantId',$request->mid)->whereBetween('created_at', [$request->startDate, $request->endDate])->where('status','!=',9)->sum('deliveryCharge');
  
      $codCharge= $parcelprice =Parcel::where('merchantId',$request->mid)->whereBetween('created_at', [$request->startDate, $request->endDate])->where('status','!=',9)->sum('codCharge');
  
      $Collectedamount =Parcel::where('merchantId',$request->mid)->where('status',4)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('cod');
  
      $parcelcount =Parcel::where('merchantId',$request->mid)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      }
  
      return view('backEnd.addparcel.marcentreport')->with('show_data',$show_data)->with('paid',$paid)->with('unpaid',$unpaid)->with('parcelr',$parcelr)->with('parcelcount',$parcelcount)->with('parcelc',$parcelc)->with('parcelpriceCOD',$parcelpriceCOD)->with('parcelpa',$parcelpa)->with('parcelre',$parcelre)->with('merchants',$merchants)->with('id',$id)->with('parcelpictd',$parcelpictd)->with('parcelinterjit',$parcelinterjit)->with('parcelhold',$parcelhold)->with('parcelrrtupa',$parcelrrtupa)->with('parcelrrhub',$parcelrrhub)->with('deliveryCharge',$deliveryCharge)->with('codCharge',$codCharge)->with('Collectedamount',$Collectedamount);
      }
    public function parcelstore(Request $request){
      $this->validate($request,[
        'cod'=>'required',
        'name'=>'required',
        'address'=>'required',
        'phonenumber'=>'required',
      ]);
      $merchant=Discount::where('maID',$request->merchantId)->where('delivery_id',$request->daytype)->first();
     $hub=Nearestzone::where('id',$request->reciveZone)->first();
     // fixed delivery charge
     $intialdcharge = Deliverycharge::find($request->daytype);
     $initialcodcharge = Codcharge::where('status',1)->orderBy('id','DESC')->first();
     if($request->weight > 1 || $request->weight !=NULL){
      $extraweight = $request->weight-1;
       $deliverycharge = (($intialdcharge->deliverycharge*1)+($extraweight*$intialdcharge->extradeliverycharge))-$merchant->discount;
       $weight = $request->weight;
     }else{
      $deliverycharge = $intialdcharge->deliverycharge-$merchant->discount;
      $weight = 1;
     }
     // fixed cod charge
     if($request->cod > 100){
      // $extracod=$request->cod -100;
      // $extracodcharge = $extracod/100;
    
      //  $codcharge = $initialcodcharge->codcharge+$extracodcharge;
      $codcharge=0;
       
     }else{
       $codcharge= $initialcodcharge->codcharge;
      
     }

     $store_parcel = new Parcel;
     $store_parcel->invoiceNo = $request->invoiceNo;
     $store_parcel->user = Auth::user()->name;
     $store_parcel->agentId = $hub->hub_id;
     $store_parcel->merchantId = $request->merchantId;
     $store_parcel->percelType = $request->percelType;
     $store_parcel->reciveZone = $request->reciveZone;
     $store_parcel->cod = $request->cod;
     $store_parcel->recipientName = $request->name;
     $store_parcel->recipientAddress = $request->address;
     $store_parcel->recipientPhone = $request->phonenumber;
     $store_parcel->productWeight = $weight;
     $store_parcel->trackingCode  = mt_rand(0000,99999)+1;
     $store_parcel->note = $request->note;
     $store_parcel->deliveryCharge = $deliverycharge;
     $store_parcel->codCharge = $codcharge;
     $store_parcel->merchantAmount = ($request->cod)-($deliverycharge);
     $store_parcel->merchantDue = ($request->cod)-($deliverycharge);
     $store_parcel->orderType = $intialdcharge->id;
     $store_parcel->codType = $initialcodcharge->id;
     $store_parcel->status = 2;     
    //  return $store_parcel;
     $store_parcel->save();
     $id=$store_parcel->id;
     Toastr::success('Success!', 'Thanks! your parcel add successfully ');
     return redirect('editor/parcel/create');
  } 

  public function parceledit($id){
    $edit_data = Parcel::find($id);
    $merchants = Merchant::orderBy('id','DESC')->get();
    $delivery=Deliverycharge::where('status',1)->get();
    return view('backEnd.addparcel.edit',compact('edit_data','merchants','delivery'));
  }
  public function parcelupdate(Request $request){
     $this->validate($request,[
            'cod'=>'required',
            'name'=>'required',
            'percelType'=>'required',
            'address'=>'required',
            'weight'=>'required',
            'phonenumber'=>'required',
          ]);
          $merchant=Discount::where('maID',$request->merchantId)->where('delivery_id',$request->daytype)->first();
          $hub=Nearestzone::where('id',$request->reciveZone)->first();
         $intialdcharge = Deliverycharge::find($request->daytype);
         $initialcodcharge = Codcharge::where('status',1)->orderBy('id','DESC')->first();
         // fixed delivery charge
         if($request->weight > 1){
          $extraweight = $request->weight-1;
          $deliverycharge = (($intialdcharge->deliverycharge*1)+($extraweight*$intialdcharge->extradeliverycharge))-$merchant->discount;
           $weight = $request->weight;
         }else{
          $deliverycharge = ($intialdcharge->deliverycharge-$merchant->discount);
          $weight = $request->weight;
         }
    
         // fixed cod charge
         if($request->cod > 100){
        //   $extracod=$request->cod -100;
        //   $extracodcharge = $extracod/100;
        //   $codcharge = $initialcodcharge->codcharge+$extracodcharge;
             $codcharge = 0;
         }else{
        //   $codcharge= $initialcodcharge->codcharge;
            $codcharge = 0;
         }
         
         $update_parcel = Parcel::find($request->hidden_id);
         $update_parcel->invoiceNo = $request->invoiceno;
         if ($hub->hub_id) {
          $update_parcel->agentId = $hub->hub_id;  
               }
        
         $update_parcel->merchantId = $request->merchantId;
         $update_parcel->reciveZone = $request->reciveZone;
         $update_parcel->cod = $request->cod;
         $update_parcel->percelType = $request->percelType;
         $update_parcel->recipientName = $request->name;
         $update_parcel->recipientAddress = $request->address;
         $update_parcel->recipientPhone = $request->phonenumber;
         $update_parcel->productWeight = $weight;
         $update_parcel->note = $request->note;
         $update_parcel->deliveryCharge = $deliverycharge;
         $update_parcel->codCharge = $codcharge;
         $update_parcel->merchantAmount = ($request->cod)-($deliverycharge);
         $update_parcel->merchantDue = ($request->cod)-($deliverycharge);
         $update_parcel->orderType = $intialdcharge->id;
         $update_parcel->save();
         Toastr::success('Success!', 'Thanks! your parcel update successfully');
         return redirect()->back();
  }
  public function import(Request $request){
    //   return 1;
    Excel::import(new AdminParcelimport,request()->file('excel'));
      Toastr::success('Wow! Bulk uploaded', 'success!');
      return redirect()->back();
  }
    
}