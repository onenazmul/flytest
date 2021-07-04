<?php

namespace App\Http\Controllers\editor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Merchant;
use App\Parcel;
use App\Nearestzone;
use App\Discount;
use App\Deliverycharge;
use DB;
use Auth;
use App\Post;
use App\Merchantpayment;
use Mail;
use Exception;
class MerchantOperationController extends Controller
{
    public function manage(){
       
        $delivery=Deliverycharge::get();
    	$merchants = Merchant::orderBy('id','ASC')->get();
    	return view('backEnd.merchant.manage',compact('merchants','delivery'));
    }
    public function merchantrequest(){
    	$merchants = Merchant::where('verify',0)->orderBy('id','DESC')->get();
    	return view('backEnd.merchant.merchantrequest',compact('merchants'));
    }
    public function profileedit($id){
    	$merchantInfo = Merchant::find($id);
    	$nearestzones = Nearestzone::where('status',1)->get();
    	return view('backEnd.merchant.edit',compact('merchantInfo','nearestzones'));
    }
      // Merchant Profile Edit
        public function profileUpdate(Request $request){
        $update_merchant = Merchant::find($request->hidden_id);
        $update_merchant->phoneNumber   = $request->phoneNumber;
        $update_merchant->pickLocation  = $request->pickLocation;
        $update_merchant->nearestZone   = $request->nearestZone;
        $update_merchant->pickupPreference = $request->pickupPreference;
        $update_merchant->paymentMethod = $request->paymentMethod;
        $update_merchant->withdrawal    = $request->withdrawal;
        $update_merchant->nameOfBank    = $request->nameOfBank;
        $update_merchant->bankBranch    = $request->bankBranch;
        $update_merchant->bankAcHolder  = $request->bankAcHolder;
        $update_merchant->bankAcNo      = $request->bankAcNo;
        $update_merchant->bkashNumber   = $request->bkashNumber;
        $update_merchant->roketNumber   = $request->roketNumber;
        $update_merchant->nogodNumber   = $request->nogodNumber;
        $update_merchant->discount      = $request->discount;
        $update_merchant->save();
         Toastr::success('message', 'Merchant  info update successfully!');
        return redirect()->back();
    }
     public function inactive(Request $request){
        $inactive_merchant = Merchant::find($request->hidden_id);
        $inactive_merchant->status=0;
        $inactive_merchant->save();
        Toastr::success('message', 'Merchant  inactive successfully!');
        return redirect('/editor/merchant/manage');
    }

    public function active(Request $request){
        $active_merchant = Merchant::find($request->hidden_id);
        $active_merchant->status=1;
        $active_merchant->verify=1;
        $active_merchant->save();
        
        $active_merchant = Merchant::find($request->hidden_id);
          $url = "http://premium.mdlsms.com/smsapi";
          $data = [
            "api_key" => "C2000829604b00d0ccad46.26595828",
            "type" => "text",
            "contacts" => "0$active_merchant->phoneNumber",
            
            "senderid" => "8809612441280",
            "msg" => "Dear $active_merchant->companyName \r\n  Successfully boarded your account. Now you can login & enjoy our services. If any query call us +880 1701-012200  \r\n Regards,\r\n PackeN Move " ,
          ];
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          $response = curl_exec($ch);
          curl_close($ch);
        Toastr::success('message', 'Merchant active successfully!');
        return redirect()->back();
        
    }
    public function view($id){
    	$merchantInfo = Merchant::find($id);

        $totalamount = DB::table('parcels')
            ->join('merchants', 'merchants.id','=','parcels.merchantId')
            ->where('parcels.merchantId', $id)->where('parcels.status','!=',9)
            ->sum('parcels.cod');
            $marcentamount = DB::table('parcels')
            ->join('merchants', 'merchants.id','=','parcels.merchantId')
            ->where('parcels.merchantId', $id)->where('parcels.status','!=',9)
            ->sum('parcels.merchantAmount');
            $merchantDue = DB::table('parcels')
            ->join('merchants', 'merchants.id','=','parcels.merchantId')
            ->where('parcels.merchantId', $id)->where('parcels.status','!=',9)
            ->sum('parcels.merchantDue');
            $collectedAmount = DB::table('parcels')
            ->join('merchants', 'merchants.id','=','parcels.merchantId')
            ->where('parcels.merchantId', $id)->where('parcels.status',4)
            ->sum('parcels.cod'); 
            $merchantPaid = DB::table('parcels')
            ->join('merchants', 'merchants.id','=','parcels.merchantId')
            ->where('parcels.merchantId', $id)->where('parcels.status','!=',9)
            ->sum('parcels.merchantPaid'); 
            $deliverycharge = DB::table('parcels')
            ->join('merchants', 'merchants.id','=','parcels.merchantId')
            ->where('parcels.merchantId', $id)->where('parcels.status','!=',9)
            ->sum('parcels.deliveryCharge'); 
        $totaldue = DB::table('parcels')
            ->join('merchants', 'merchants.id','=','parcels.merchantId')
            ->where('parcels.merchantId', $id)->where('parcels.status','!=',9)
            ->sum('parcels.merchantDue');
            $parcel = DB::table('parcels')
            ->join('merchants', 'merchants.id','=','parcels.merchantId')
            ->where('parcels.merchantId', $id)
            ->count();

        $parcels = DB::table('parcels')
            ->join('merchants', 'merchants.id','=','parcels.merchantId')
            ->where('parcels.merchantId', $id)->whereIn('parcels.status',[4,8])
            ->orderBy('parcels.id','DESC')
            ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
            ->get();
            
    	return view('backEnd.merchant.view',compact('merchantInfo','deliverycharge','totalamount','totaldue','parcel','parcels','collectedAmount','merchantDue','marcentamount','merchantPaid'));
    }
    public function paymentinvoice($id){
        $merchantInvoice = Merchantpayment::where('merchantId',$id)->orderBy('id','DESC')->get();
        return view('backEnd.merchant.paymentinvoice',compact('merchantInvoice'));
    }
    public function inovicedetails($id){
        $invoiceInfo = Merchantpayment::find($id);
        $inovicedetails = Parcel::where('paymentInvoice',$id)->get();
        $merchantInfo = Merchant::find($invoiceInfo->merchantId);
        return view('backEnd.merchant.inovicedetails',compact('inovicedetails','invoiceInfo','merchantInfo'));
    }
    
    public function discount(Request $request){
        // dd($request);
        // $merchant= Merchant::where('id',$request->id)->first();
        // $merchant->discount=$request->discount;
        // $merchant->save();
        $typename=Deliverycharge::where('id',$request->delivery_id)->first();
        $discount=new Discount;
        $discount->maID=$request->maID;
        $discount->delivery_id=$request->delivery_id;
        $discount->dliveryTypeName=$typename->title;
        $discount->discount=$request->discount;
        $discount->save();

        Toastr::success('message', 'Merchant Discount successfully!');
        return back();

    }
    public function dis($id){
        $delivery=Deliverycharge::get();
        $merchants = Merchant::where('id',$id)->first();
    	return view('backEnd.merchant.discount',compact('merchants','delivery'));
    }

    public function discount_delete($id){
        $discount=Discount::where('id',$id)->delete();
        Toastr::success('message', ' Discount Delete has been successfully!');
        return back();

    }
}
