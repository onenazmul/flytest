<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Deliveryman;
use App\Merchant;
use App\Parcel;
use App\Parcelnote;
use App\PickDrop;
use App\Parceltype;
use App\Exports\RiderParcelExport;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use DB;
use Mail;
class DeliverymanController extends Controller
{
    public function loginform(){
        return view('frontEnd.layouts.pages.deliveryman.login');
    }
    public function login(Request $request){
        $this->validate($request,[
            'email' => 'required',
            'password' => 'required',
        ]);
       $checkAuth = Deliveryman::where('email',$request->email)
       ->first();
        if($checkAuth){
          if($checkAuth->status == 0){
             Toastr::warning('warning', 'Opps! your account has been suspends');
             return redirect()->back();
         }else{
          if(password_verify($request->password,$checkAuth->password)){
              $deliverymanId = $checkAuth->id;
               Session::put('deliverymanId',$deliverymanId);
               Toastr::success('success', 'Thanks , You are login successfully');
              return redirect('deliveryman/dashboard');
            
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
    public function dashboard(){
      $totalparcel=Parcel::where(['deliverymanId'=>Session::get('deliverymanId')])->count();
          $totaldelivery=Parcel::where(['deliverymanId'=>Session::get('deliverymanId'),'status'=>4])->count();
          $totalhold=Parcel::where(['deliverymanId'=>Session::get('deliverymanId'),'status'=>5])->count();
          $totalcancel=Parcel::where(['deliverymanId'=>Session::get('deliverymanId'),'status'=>9])->count();
          $returnpendin=Parcel::where(['deliverymanId'=>Session::get('deliverymanId'),'status'=>6])->count();
          $returnmerchant=Parcel::where(['deliverymanId'=>Session::get('deliverymanId'),'status'=>8])->count();
          return view('frontEnd.layouts.pages.deliveryman.dashboard',compact('totalparcel','totaldelivery','totalhold','totalcancel','returnpendin','returnmerchant'));
    }
    public function parcels(Request $request){
       $filter = $request->filter_id;
       if($request->trackId!=NULL){
        $parcelr =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',4)->where('trackingCode',$request->trackId)->count();
        $parcelc =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',9)->where('trackingCode',$request->trackId)->count();
        $parcelre =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',8)->where('trackingCode',$request->trackId)->count();
        $parcelpa =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',1)->where('trackingCode',$request->trackId)->count();
      
        $parcelpictd =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',2)->where('trackingCode',$request->trackId)->count();
        $parcelinterjit =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',3)->where('trackingCode',$request->trackId)->count();
        $parcelhold =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',5)->where('trackingCode',$request->trackId)->count();
        $parcelrrtupa =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',6)->where('trackingCode',$request->trackId)->count();
        $parcelrrhub =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',7)->where('trackingCode',$request->trackId)->count();
      
        $parcelpriceCOD =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status','!=',9)->where('trackingCode',$request->trackId)->sum('cod');
      // dd($parcelprice);
        $deliveryCharge= $parcelprice =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('trackingCode',$request->trackId)->sum('deliveryCharge');
      
        $codCharge= $parcelprice =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('trackingCode',$request->trackId)->sum('codCharge');
      
        $Collectedamount =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',4)->where('trackingCode',$request->trackId)->sum('cod');
      
        $parcelcount =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('trackingCode',$request->trackId)->count();
        $allparcel = DB::table('parcels')
        ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.deliverymanId',Session::get('deliverymanId'))
        ->where('parcels.trackingCode',$request->trackId)
        ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->orderBy('id','DESC')
        ->get();
       }elseif($request->phoneNumber!=NULL){
        $parcelr =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',4)->where('recipientPhone',$request->phoneNumber)->count();
        $parcelc =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',9)->where('recipientPhone',$request->phoneNumber)->count();
        $parcelre =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',8)->where('recipientPhone',$request->phoneNumber)->count();
        $parcelpa =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',1)->where('recipientPhone',$request->phoneNumber)->count();
      
        $parcelpictd =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',2)->where('recipientPhone',$request->phoneNumber)->count();
        $parcelinterjit =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',3)->where('recipientPhone',$request->phoneNumber)->count();
        $parcelhold =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',5)->where('recipientPhone',$request->phoneNumber)->count();
        $parcelrrtupa =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',6)->where('recipientPhone',$request->phoneNumber)->count();
        $parcelrrhub =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',7)->where('recipientPhone',$request->phoneNumber)->count();
      
        $parcelpriceCOD =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status','!=',9)->where('recipientPhone',$request->phoneNumber)->sum('cod');
      // dd($parcelprice);
        $deliveryCharge= $parcelprice =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('recipientPhone',$request->phoneNumber)->sum('deliveryCharge');
      
        $codCharge= $parcelprice =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('recipientPhone',$request->phoneNumber)->sum('codCharge');
      
        $Collectedamount =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',4)->where('recipientPhone',$request->phoneNumber)->sum('cod');
      
        $parcelcount =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('recipientPhone',$request->phoneNumber)->count();
        $allparcel = DB::table('parcels')
        ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.deliverymanId',Session::get('deliverymanId'))
        ->where('parcels.recipientPhone',$request->phoneNumber)
        ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->orderBy('id','DESC')
        ->get();
       }elseif($request->startDate!=NULL && $request->endDate!=NULL){
        $parcelr =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',4)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelc =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',9)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelre =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',8)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelpa =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',1)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      
        $parcelpictd =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',2)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelinterjit =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',3)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelhold =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',5)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelrrtupa =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',6)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelrrhub =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',7)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      
        $parcelpriceCOD =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status','!=',9)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('cod');
      // dd($parcelprice);
        $deliveryCharge= $parcelprice =Parcel::where('deliverymanId',Session::get('deliverymanId'))->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('deliveryCharge');
      
        $codCharge= $parcelprice =Parcel::where('deliverymanId',Session::get('deliverymanId'))->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('codCharge');
      
        $Collectedamount =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',4)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('cod');
      
        $parcelcount =Parcel::where('deliverymanId',Session::get('deliverymanId'))->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $allparcel = DB::table('parcels')
        ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.deliverymanId',Session::get('deliverymanId'))
        ->whereBetween('parcels.created_at',[$request->startDate, $request->endDate])
        ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->orderBy('id','DESC')
        ->get();
       }elseif($request->phoneNumber!=NULL || $request->phoneNumber!=NULL && $request->startDate!=NULL && $request->endDate!=NULL){
        $allparcel = DB::table('parcels')
        ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.deliverymanId',Session::get('deliverymanId'))
        ->where('parcels.recipientPhone',$request->phoneNumber)
        ->whereBetween('parcels.created_at',[$request->startDate, $request->endDate])
        ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->orderBy('id','DESC')
        ->get();
       }else{
        $parcelr =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',4)->count();
        $parcelc =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',9)->count();
        $parcelre =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',8)->count();
        $parcelpa =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',1)->count();
      
        $parcelpictd =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',2)->count();
        $parcelinterjit =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',3)->count();
        $parcelhold =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',5)->count();
        $parcelrrtupa =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',6)->count();
        $parcelrrhub =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',7)->count();
      
        $parcelpriceCOD =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status','!=',9)->sum('cod');
      // dd($parcelprice);
        $deliveryCharge= $parcelprice =Parcel::where('deliverymanId',Session::get('deliverymanId'))->sum('deliveryCharge');
      
        $codCharge= $parcelprice =Parcel::where('deliverymanId',Session::get('deliverymanId'))->sum('codCharge');
      
        $Collectedamount =Parcel::where('deliverymanId',Session::get('deliverymanId'))->sum('cod');
      
        $parcelcount =Parcel::where('deliverymanId',Session::get('deliverymanId'))->count();
        $allparcel = DB::table('parcels')
        ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.deliverymanId',Session::get('deliverymanId'))
        ->select('parcels.*','merchants.companyName','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress')
        ->orderBy('id','DESC')
        ->get();
       }
       return view('frontEnd.layouts.pages.deliveryman.parcels',compact('allparcel','parcelr','parcelc','parcelre','parcelpa','parcelpictd','parcelinterjit','parcelhold','parcelrrtupa','parcelrrhub','parcelpriceCOD','deliveryCharge','codCharge','Collectedamount','parcelcount'));
  }
  public function parcel(Request $request){
    // dd($request);
      $aparceltypes = Parceltype::where('slug',$request->slug)->first();
   $filter = $request->filter_id;
   if($request->trackId!=NULL){
     $parcelr =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',4)->where('trackingCode',$request->trackId)->count();
    $parcelc =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',9)->where('trackingCode',$request->trackId)->count();
    $parcelre =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',8)->where('trackingCode',$request->trackId)->count();
    $parcelpa =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',1)->where('trackingCode',$request->trackId)->count();
  
    $parcelpictd =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',2)->where('trackingCode',$request->trackId)->count();
    $parcelinterjit =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',3)->where('trackingCode',$request->trackId)->count();
    $parcelhold =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',5)->where('trackingCode',$request->trackId)->count();
    $parcelrrtupa =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',6)->where('trackingCode',$request->trackId)->count();
    $parcelrrhub =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',7)->where('trackingCode',$request->trackId)->count();
  
    $parcelpriceCOD =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status','!=',9)->where('trackingCode',$request->trackId)->sum('cod');
  // dd($parcelprice);
    $deliveryCharge= $parcelprice =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('trackingCode',$request->trackId)->sum('deliveryCharge');
  
    $codCharge= $parcelprice =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('trackingCode',$request->trackId)->sum('codCharge');
  
    $Collectedamount =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',4)->where('trackingCode',$request->trackId)->sum('cod');
  
    $parcelcount =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('trackingCode',$request->trackId)->count();
    $allparcel = DB::table('parcels')
    ->join('merchants', 'merchants.id','=','parcels.merchantId')
    ->where('parcels.deliverymanId',Session::get('deliverymanId'))
    ->where('parcels.trackingCode',$request->trackId)
    ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
    ->orderBy('id','DESC')
    ->get();
   }elseif($request->phoneNumber!=NULL){
    $parcelr =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',4)->where('recipientPhone',$request->phoneNumber)->count();
    $parcelc =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',9)->where('recipientPhone',$request->phoneNumber)->count();
    $parcelre =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',8)->where('recipientPhone',$request->phoneNumber)->count();
    $parcelpa =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',1)->where('recipientPhone',$request->phoneNumber)->count();
  
    $parcelpictd =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',2)->where('recipientPhone',$request->phoneNumber)->count();
    $parcelinterjit =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',3)->where('recipientPhone',$request->phoneNumber)->count();
    $parcelhold =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',5)->where('recipientPhone',$request->phoneNumber)->count();
    $parcelrrtupa =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',6)->where('recipientPhone',$request->phoneNumber)->count();
    $parcelrrhub =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',7)->where('recipientPhone',$request->phoneNumber)->count();
  
    $parcelpriceCOD =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status','!=',9)->where('recipientPhone',$request->phoneNumber)->sum('cod');
  // dd($parcelprice);
    $deliveryCharge= $parcelprice =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('recipientPhone',$request->phoneNumber)->sum('deliveryCharge');
  
    $codCharge= $parcelprice =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('recipientPhone',$request->phoneNumber)->sum('codCharge');
  
    $Collectedamount =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',4)->where('recipientPhone',$request->phoneNumber)->sum('cod');
  
    $parcelcount =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('trackingCode',$request->trackId)->count();
    $allparcel = DB::table('parcels')
    ->join('merchants', 'merchants.id','=','parcels.merchantId')
    ->where('parcels.deliverymanId',Session::get('deliverymanId'))
    ->where('parcels.recipientPhone',$request->phoneNumber)
    ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
    ->orderBy('id','DESC')
    ->get();
   }elseif($request->startDate!=NULL && $request->endDate!=NULL){
        $parcelr =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',4)->where('parcels.status',$aparceltypes->id)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
    $parcelc =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',9)->where('parcels.status',$aparceltypes->id)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
    $parcelre =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',8)->where('parcels.status',$aparceltypes->id)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
    $parcelpa =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',1)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
  
    $parcelpictd =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',2)->where('parcels.status',$aparceltypes->id)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
    $parcelinterjit =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',3)->where('parcels.status',$aparceltypes->id)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
    $parcelhold =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',5)->where('parcels.status',$aparceltypes->id)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
    $parcelrrtupa =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',6)->where('parcels.status',$aparceltypes->id)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
    $parcelrrhub =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',7)->where('parcels.status',$aparceltypes->id)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
  
    $parcelpriceCOD =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status','!=',9)->where('parcels.status',$aparceltypes->id)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('cod');
  // dd($parcelprice);
    $deliveryCharge= $parcelprice =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('parcels.status',$aparceltypes->id)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('deliveryCharge');
  
    $codCharge= $parcelprice =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('parcels.status',$aparceltypes->id)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('codCharge');
  
    $Collectedamount =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('status',4)->where('parcels.status',$aparceltypes->id)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('cod');
  
    $parcelcount =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('parcels.status',$aparceltypes->id)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
    $allparcel = DB::table('parcels')
    ->join('merchants', 'merchants.id','=','parcels.merchantId')
    ->where('parcels.deliverymanId',Session::get('deliverymanId'))->where('parcels.status',$aparceltypes->id)
    ->whereBetween('parcels.created_at',[$request->startDate, $request->endDate])
    ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
    ->orderBy('id','DESC')
    ->get();
   }elseif($request->phoneNumber!=NULL || $request->phoneNumber!=NULL && $request->startDate!=NULL && $request->endDate!=NULL){
    $allparcel = DB::table('parcels')
    ->join('merchants', 'merchants.id','=','parcels.merchantId')
    ->where('parcels.deliverymanId',Session::get('deliverymanId'))
    ->where('parcels.recipientPhone',$request->phoneNumber)
    ->whereBetween('parcels.created_at',[$request->startDate, $request->endDate])
    ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
    ->orderBy('id','DESC')
    ->get();
   }else{
    $parcelr =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('parcels.status',$aparceltypes->id)->where('status',4)->count();
    $parcelc =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('parcels.status',$aparceltypes->id)->where('status',9)->count();
    $parcelre =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('parcels.status',$aparceltypes->id)->where('status',8)->count();
    $parcelpa =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('parcels.status',$aparceltypes->id)->where('status',1)->count();
  
    $parcelpictd =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('parcels.status',$aparceltypes->id)->where('status',2)->count();
    $parcelinterjit =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('parcels.status',$aparceltypes->id)->where('status',3)->count();
    $parcelhold =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('parcels.status',$aparceltypes->id)->where('status',5)->count();
    $parcelrrtupa =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('parcels.status',$aparceltypes->id)->where('status',6)->count();
    $parcelrrhub =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('parcels.status',$aparceltypes->id)->where('status',7)->count();
  
    $parcelpriceCOD =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('parcels.status',$aparceltypes->id)->where('status','!=',9)->sum('cod');
  // dd($parcelprice);
    $deliveryCharge= $parcelprice =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('parcels.status',$aparceltypes->id)->sum('deliveryCharge');
  
    $codCharge= $parcelprice =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('parcels.status',$aparceltypes->id)->sum('codCharge');
  
    $Collectedamount =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('parcels.status',$aparceltypes->id)->sum('cod');
  
    $parcelcount =Parcel::where('deliverymanId',Session::get('deliverymanId'))->where('parcels.status',$aparceltypes->id)->count();
    
    $allparcel = DB::table('parcels')
    ->join('merchants', 'merchants.id','=','parcels.merchantId')
    ->where('parcels.deliverymanId',Session::get('deliverymanId'))->where('parcels.status',$aparceltypes->id)
    ->select('parcels.*','merchants.companyName','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress')
    ->orderBy('id','DESC')
    ->get();
   }
   $aparceltypes = Parceltype::limit(8)->get();
  return view('frontEnd.layouts.pages.deliveryman.parcels',compact('allparcel','aparceltypes','parcelr','parcelc','parcelre','parcelpa','parcelpictd','parcelinterjit','parcelhold','parcelrrtupa','parcelrrhub','parcelpriceCOD','deliveryCharge','codCharge','Collectedamount','parcelcount'));
}
  public function pickdrop(Request $request){
    if($request->startDate!=NULL && $request->endDate!=NULL){
      $total=PickDrop::where('deliveryId',Session::get('deliverymanId'))->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
		$tprice=PickDrop::where('deliveryId',Session::get('deliverymanId'))->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('price');
		$tpanding= PickDrop::where('deliveryId',Session::get('deliverymanId'))->whereBetween('created_at', [$request->startDate, $request->endDate])->where('status','Pending')->count();
		$tcancel= PickDrop::where('deliveryId',Session::get('deliverymanId'))->whereBetween('created_at', [$request->startDate, $request->endDate])->where('status','Cancelled')->count();
		$taccept= PickDrop::where('deliveryId',Session::get('deliverymanId'))->whereBetween('created_at', [$request->startDate, $request->endDate])->where('status','Accepted')->count();
		$tdeliverd= PickDrop::where('deliveryId',Session::get('deliverymanId'))->whereBetween('created_at', [$request->startDate, $request->endDate])->where('status','Delivered')->count();
      $show_data  = DB::table('pick_drops')
      ->where('pick_drops.deliveryId',Session::get('deliverymanId'))
      ->whereBetween('pick_drops.created_at',[$request->startDate, $request->endDate])
      ->orderBy('id','DESC')
      ->get();
     }else{
      $total=PickDrop::where('deliveryId',Session::get('deliverymanId'))->count();
      $tprice=PickDrop::where('deliveryId',Session::get('deliverymanId'))->sum('price');
      $tpanding= PickDrop::where('deliveryId',Session::get('deliverymanId'))->where('status','Pending')->count();
      $tcancel= PickDrop::where('deliveryId',Session::get('deliverymanId'))->where('status','Cancelled')->count();
      $taccept= PickDrop::where('deliveryId',Session::get('deliverymanId'))->where('status','Accepted')->count();
      $tdeliverd= PickDrop::where('deliveryId',Session::get('deliverymanId'))->where('status','Delivered')->count();
    
      $show_data  = DB::table('pick_drops')->where('pick_drops.deliveryId',Session::get('deliverymanId'))
    	->orderBy('pick_drops.id','DESC')
    	->select('pick_drops.*')
    	->get();
     }
     return view('frontEnd.layouts.pages.deliveryman.pickdrop',compact('show_data','total','tprice','tpanding','tcancel','taccept','tdeliverd'));
  }
   public function invoice($id){
    $show_data = DB::table('parcels')
    ->join('merchants', 'merchants.id','=','parcels.merchantId')
    ->where('parcels.deliverymanId',Session::get('deliverymanId'))
    ->join('nearestzones', 'parcels.reciveZone','=','nearestzones.id')
    ->where('parcels.id',$id)
    ->select('parcels.*','nearestzones.zonename','merchants.companyName','merchants.phoneNumber','merchants.emailAddress')
    ->first();
        if($show_data!=NULL){
        	return view('frontEnd.layouts.pages.deliveryman.invoice',compact('show_data'));
        }else{
          Toastr::error('Opps!', 'Your process wrong');
          return redirect()->back();
        }
    }
  public function statusupdate(Request $request){
    $user=Deliveryman::where('id',Session::get('agentName'))->first();
      $this->validate($request,[
        'status'=>'required',
      ]); 
       $parcel = Parcel::find($request->hidden_id);
            $parcel->status = $request->status;
            $parcel->present_date =date("Y-m-d");
            $parcel->save();
            $note = new Parcelnote();
            $note->parcelId = $request->hidden_id;            
            $note->note = $request->note;
            $note->user=$user->name;
            $note->save();
        if($request->status==3){
           $parcel = Parcel::find($request->hidden_id);
           $parcel->present_date =date("Y-m-d");
           $parcel->save();
           if($request->note){
                 $note = new Parcelnote();
                 $note->parcelId = $request->hidden_id;            
                 $note->note = $request->note;
                 $note->user=$user->name;
                 $note->save();
             }
             

            // $codcharge=$request->customerpay/100;
            $codcharge=0;
            $parcel->merchantAmount=($parcel->merchantAmount)-($codcharge);
            $parcel->merchantDue=($parcel->merchantAmount)-($codcharge);
            $parcel->codCharge=$codcharge;
            $parcel->save();
        }elseif($request->status==4){
           $parcel = Parcel::find($request->hidden_id);
            $parcel->status = $request->status;
            $parcel->save();
            
            if($request->note){
                $note = new Parcelnote();
                $note->parcelId = $request->hidden_id;
                $note->note = 'Parcel delivered successfully';
                $note->user=$user->name;
                $note->save();
            }
            
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
    public function partial_pay(Request $request){
      $parcel = Parcel::find($request->id);
    	$parcel->partial_pay = $request->partial_pay;
    	$parcel->save();
      Toastr::success('message', 'Partial Pay Add successfully!');
    	return redirect()->back();
    }
    public function pickup(){
      $show_data = DB::table('pickups')
      ->where('pickups.deliveryman',Session::get('deliverymanId'))
      ->orderBy('pickups.id','DESC')
      ->select('pickups.*')
      ->get();
      $deliverymen = Deliveryman::where('status',1)->get();
      return view('frontEnd.layouts.pages.deliveryman.pickup',compact('show_data','deliverymen'));
    }
    public function pickupdeliverman(Request $request){
        $this->validate($request,[
          'deliveryman'=>'required',
        ]);
        $pickup = Pickup::find($request->hidden_id);
        $pickup->deliveryman = $request->deliveryman;
        $pickup->save();

        Toastr::success('message', 'A deliveryman asign successfully!');
        return redirect()->back();
        $deliverymanInfo = Deliveryman::find($parcel->deliverymanId);
        $agentInfo =Agent::find($parcel->merchantId);
        $data = array(
         'contact_mail' => $agentInfo->email,
         'ridername' => $deliverymanInfo->name,
         'riderphone' => $deliverymanInfo->phone,
         'codprice' => $pickup->cod,
        );
        $send = Mail::send('frontEnd.emails.percelassign', $data, function($textmsg) use ($data){
         $textmsg->from('info@flingex.com');
         $textmsg->to($data['contact_mail']);
         $textmsg->subject('Pickup Assign Notification');
        });
          
    }
    public function pickupstatus(Request $request){
      $this->validate($request,[
        'status'=>'required',
      ]);
      $pickup = Pickup::find($request->hidden_id);
      $pickup->status = $request->status;
      $pickup->save();
    
      Toastr::success('message', 'Pickup status update successfully!');
      return redirect()->back();
    }
    public function passreset(){
      return view('frontEnd.layouts.pages.deliveryman.passreset');
    }
    public function passfromreset(Request $request){
      $this->validate($request,[
            'email' => 'required',
        ]);
        $validDeliveryman =Deliveryman::Where('email',$request->email)
       ->first();
        if($validDeliveryman){
             $verifyToken=rand(111111,999999);
             $validDeliveryman->passwordReset  = $verifyToken;
             $validDeliveryman->save();
             Session::put('resetDeliverymanId',$validDeliveryman->id);
             
             $data = array(
             'contact_mail' => $validDeliveryman->email,
             'verifyToken' => $verifyToken,
            );
            $send = Mail::send('frontEnd.layouts.pages.deliveryman.forgetemail', $data, function($textmsg) use ($data){
             $textmsg->from('info@flingex.com');
             $textmsg->to($data['contact_mail']);
             $textmsg->subject('Forget password token');
            });
          return redirect('deliveryman/resetpassword/verify');
        }else{
              Toastr::error('Sorry! You have no account', 'warning!');
             return redirect()->back();
        }
    }
    public function saveResetPassword(Request $request){
      // return "okey";
       $validDeliveryman = Deliveryman::find(Session::get('resetDeliverymanId'));
        if($validDeliveryman->passwordReset==$request->verifyPin){
           $validDeliveryman->password   = bcrypt(request('newPassword'));
           $validDeliveryman->passwordReset  = NULL;
             $validDeliveryman->save();
             
             Session::forget('resetDeliverymanId');
             Session::put('deliverymanId',$validDeliveryman->id);
             Toastr::success('Wow! Your password reset successfully', 'success!');
             return redirect('deliveryman/dashboard');
        }else{
          return $request->verifyPin;
            Toastr::error('Sorry! Your process something wrong', 'warning!');
             return redirect()->back();
        }
       
    }
    public function resetpasswordverify(){
        if(Session::get('resetDeliverymanId')){
        return view('frontEnd.layouts.pages.deliveryman.passwordresetverify');
        }else{
            Toastr::error('Sorry! Your process something wrong', 'warning!');
            return redirect('forget/password');
        }
    }
    public function logout(){
        Session::flush();
        Toastr::success('Success!', 'Thanks! you are logout successfully');
        return redirect('deliveryman/logout');
    }
     public function export( Request $request ) {
        return Excel::download( new RiderParcelExport(), 'parcel.xlsx') ;
    
    }
    
}