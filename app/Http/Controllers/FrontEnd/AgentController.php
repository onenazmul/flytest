<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Agent;
use App\Parcel;
use App\Pickup;
use App\Deliveryman;
use App\Merchant;
use App\Parcelnote;
use App\Parceltype;
use App\Exports\AgentParcelExport;
use Maatwebsite\Excel\Facades\Excel;
use Mail;
use Session;
use DB;
use Auth;
class AgentController extends Controller
{
    public function loginform(){
        return view('frontEnd.layouts.pages.agent.login');
    }
    public function login(Request $request){
        $this->validate($request,[
            'email' => 'required',
            'password' => 'required',
        ]);
       $checkAuth =Agent::where('email',$request->email)
       ->first();
        if($checkAuth){
          if($checkAuth->status == 0){
             Toastr::warning('warning', 'Opps! your account has been suspends');
             return redirect()->back();
         }else{
          if(password_verify($request->password,$checkAuth->password)){
              $agentId = $checkAuth->id;
              $agentName = $checkAuth->name;
               Session::put('agentId',$agentId);
               Session::put('agentName',$agentName);
               Toastr::success('success', 'Thanks , You are login successfully');
              return redirect('/agent/dashboard');
            
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
    	  $totalparcel=Parcel::where(['agentId'=>Session::get('agentId')])->count();
          $totaldelivery=Parcel::where(['agentId'=>Session::get('agentId'),'status'=>4])->count();
          $totalhold=Parcel::where(['agentId'=>Session::get('agentId'),'status'=>5])->count();
          $totalcancel=Parcel::where(['agentId'=>Session::get('agentId'),'status'=>9])->count();
          $returnpendin=Parcel::where(['agentId'=>Session::get('agentId'),'status'=>6])->count();
          $returnmerchant=Parcel::where(['agentId'=>Session::get('agentId'),'status'=>8])->count();
          return view('frontEnd.layouts.pages.agent.dashboard',compact('totalparcel','totaldelivery','totalhold','totalcancel','returnpendin','returnmerchant'));
    }
    public function parcel(Request $request){
        // dd($request);
        $aparceltypes = Parceltype::where('slug',$request->slug)->first();
       $filter = $request->filter_id;
   
       if($request->trackId!=NULL){
        $parcelr =Parcel::where('agentId',Session::get('agentId'))->where('status',4)->where('trackingCode',$request->trackId)->count();
        $parcelc =Parcel::where('agentId',Session::get('agentId'))->where('status',9)->where('trackingCode',$request->trackId)->count();
        $parcelre =Parcel::where('agentId',Session::get('agentId'))->where('status',8)->where('trackingCode',$request->trackId)->count();
        $parcelpa =Parcel::where('agentId',Session::get('agentId'))->where('status',1)->where('trackingCode',$request->trackId)->count();
      
        $parcelpictd =Parcel::where('agentId',Session::get('agentId'))->where('status',2)->where('trackingCode',$request->trackId)->count();
        $parcelinterjit =Parcel::where('agentId',Session::get('agentId'))->where('status',3)->where('trackingCode',$request->trackId)->count();
        $parcelhold =Parcel::where('agentId',Session::get('agentId'))->where('status',5)->where('trackingCode',$request->trackId)->count();
        $parcelrrtupa =Parcel::where('agentId',Session::get('agentId'))->where('status',6)->where('trackingCode',$request->trackId)->count();
        $parcelrrhub =Parcel::where('agentId',Session::get('agentId'))->where('status',7)->where('trackingCode',$request->trackId)->count();
      
        $parcelpriceCOD =Parcel::where('agentId',Session::get('agentId'))->where('status','!=',9)->where('trackingCode',$request->trackId)->sum('cod');
      // dd($parcelprice);
        $deliveryCharge= $parcelprice =Parcel::where('agentId',Session::get('agentId'))->where('trackingCode',$request->trackId)->sum('deliveryCharge');
      
        $codCharge= $parcelprice =Parcel::where('agentId',Session::get('agentId'))->where('trackingCode',$request->trackId)->sum('codCharge');
      
        $Collectedamount =Parcel::where('agentId',Session::get('agentId'))->where('status',4)->where('trackingCode',$request->trackId)->sum('cod');
      
        $parcelcount =Parcel::where('agentId',Session::get('agentId'))->where('trackingCode',$request->trackId)->count();
        $allparcel = DB::table('parcels')
        ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.agentId',Session::get('agentId'))
        ->where('parcels.trackingCode',$request->trackId)
        ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->orderBy('id','DESC')
        ->get();
       }elseif($request->phoneNumber!=NULL){
        $parcelr =Parcel::where('agentId',Session::get('agentId'))->where('status',4)->where('recipientPhone',$request->phoneNumber)->count();
        $parcelc =Parcel::where('agentId',Session::get('agentId'))->where('status',9)->where('recipientPhone',$request->phoneNumber)->count();
        $parcelre =Parcel::where('agentId',Session::get('agentId'))->where('status',8)->where('recipientPhone',$request->phoneNumber)->count();
        $parcelpa =Parcel::where('agentId',Session::get('agentId'))->where('status',1)->where('recipientPhone',$request->phoneNumber)->count();
      
        $parcelpictd =Parcel::where('agentId',Session::get('agentId'))->where('status',2)->where('recipientPhone',$request->phoneNumber)->count();
        $parcelinterjit =Parcel::where('agentId',Session::get('agentId'))->where('status',3)->where('recipientPhone',$request->phoneNumber)->count();
        $parcelhold =Parcel::where('agentId',Session::get('agentId'))->where('status',5)->where('recipientPhone',$request->phoneNumber)->count();
        $parcelrrtupa =Parcel::where('agentId',Session::get('agentId'))->where('status',6)->where('recipientPhone',$request->phoneNumber)->count();
        $parcelrrhub =Parcel::where('agentId',Session::get('agentId'))->where('status',7)->where('recipientPhone',$request->phoneNumber)->count();
      
        $parcelpriceCOD =Parcel::where('agentId',Session::get('agentId'))->where('status','!=',9)->where('recipientPhone',$request->phoneNumber)->sum('cod');
      // dd($parcelprice);
        $deliveryCharge= $parcelprice =Parcel::where('agentId',Session::get('agentId'))->where('recipientPhone',$request->phoneNumber)->sum('deliveryCharge');
      
        $codCharge= $parcelprice =Parcel::where('agentId',Session::get('agentId'))->where('recipientPhone',$request->phoneNumber)->sum('codCharge');
      
        $Collectedamount =Parcel::where('agentId',Session::get('agentId'))->where('status',4)->where('recipientPhone',$request->phoneNumber)->sum('cod');
      
        $parcelcount =Parcel::where('agentId',Session::get('agentId'))->where('recipientPhone',$request->phoneNumber)->count();
        $allparcel = DB::table('parcels')
        ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.agentId',Session::get('agentId'))
        ->where('parcels.recipientPhone',$request->phoneNumber)
        ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->orderBy('id','DESC')
        ->get();
       }elseif($request->startDate!=NULL && $request->endDate!=NULL){
        $parcelr =Parcel::where('agentId',Session::get('agentId'))->where('status',4)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelc =Parcel::where('agentId',Session::get('agentId'))->where('status',9)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelre =Parcel::where('agentId',Session::get('agentId'))->where('status',8)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelpa =Parcel::where('agentId',Session::get('agentId'))->where('status',1)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      
        $parcelpictd =Parcel::where('agentId',Session::get('agentId'))->where('status',2)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelinterjit =Parcel::where('agentId',Session::get('agentId'))->where('status',3)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelhold =Parcel::where('agentId',Session::get('agentId'))->where('status',5)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelrrtupa =Parcel::where('agentId',Session::get('agentId'))->where('status',6)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelrrhub =Parcel::where('agentId',Session::get('agentId'))->where('status',7)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      
        $parcelpriceCOD =Parcel::where('agentId',Session::get('agentId'))->where('status','!=',9)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('cod');
      // dd($parcelprice);
        $deliveryCharge= $parcelprice =Parcel::where('agentId',Session::get('agentId'))->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('deliveryCharge');
      
        $codCharge= $parcelprice =Parcel::where('agentId',Session::get('agentId'))->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('codCharge');
      
        $Collectedamount =Parcel::where('agentId',Session::get('agentId'))->where('status',4)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('cod');
      
        $parcelcount =Parcel::where('agentId',Session::get('agentId'))->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $allparcel = DB::table('parcels')
        ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.agentId',Session::get('agentId'))
        ->whereBetween('parcels.created_at',[$request->startDate, $request->endDate])
        ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->orderBy('id','DESC')
        ->get();
       }elseif($request->trackId!=NULL || $request->phoneNumber!=NULL && $request->startDate!=NULL && $request->endDate!=NULL){
           
          $parcelr =Parcel::where('agentId',Session::get('agentId'))->where('status',4)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelc =Parcel::where('agentId',Session::get('agentId'))->where('status',9)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelre =Parcel::where('agentId',Session::get('agentId'))->where('status',8)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelpa =Parcel::where('agentId',Session::get('agentId'))->where('status',1)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      
        $parcelpictd =Parcel::where('agentId',Session::get('agentId'))->where('status',2)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelinterjit =Parcel::where('agentId',Session::get('agentId'))->where('status',3)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
        $parcelhold =Parcel::where('agentId',Session::get('agentId'))->where('status',5)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelrrtupa =Parcel::where('agentId',Session::get('agentId'))->where('status',6)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelrrhub =Parcel::where('agentId',Session::get('agentId'))->where('status',7)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      
        $parcelpriceCOD =Parcel::where('agentId',Session::get('agentId'))->where('status','!=',9)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->sum('cod');
      // dd($parcelprice);
        $deliveryCharge= $parcelprice =Parcel::where('agentId',Session::get('agentId'))->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('deliveryCharge');
      
        $codCharge= $parcelprice =Parcel::where('agentId',Session::get('agentId'))->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->sum('codCharge');
      
        $Collectedamount =Parcel::where('agentId',Session::get('agentId'))->where('status',4)->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->sum('cod');
      
        $parcelcount =Parcel::where('agentId',Session::get('agentId'))->where('trackingCode',$request->trackId)->where('recipientPhone',$request->phoneNumber)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
        $allparcel = DB::table('parcels')
        ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.agentId',Session::get('agentId'))
        ->where('parcels.recipientPhone',$request->phoneNumber)
        ->whereBetween('parcels.created_at',[$request->startDate, $request->endDate])
        ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->orderBy('id','DESC')
        ->get();
           
       }else{
            $parcelr =Parcel::where('agentId',Session::get('agentId'))->where('status',4)->count();
        $parcelc =Parcel::where('agentId',Session::get('agentId'))->where('status',9)->count();
        $parcelre =Parcel::where('agentId',Session::get('agentId'))->where('status',8)->count();
        $parcelpa =Parcel::where('agentId',Session::get('agentId'))->where('status',1)->count();
      
        $parcelpictd =Parcel::where('agentId',Session::get('agentId'))->where('status',2)->count();
        $parcelinterjit =Parcel::where('agentId',Session::get('agentId'))->where('status',3)->count();
        $parcelhold =Parcel::where('agentId',Session::get('agentId'))->where('status',5)->count();
        $parcelrrtupa =Parcel::where('agentId',Session::get('agentId'))->where('status',6)->count();
        $parcelrrhub =Parcel::where('agentId',Session::get('agentId'))->where('status',7)->count();
      
        $parcelpriceCOD =Parcel::where('agentId',Session::get('agentId'))->where('status','!=',9)->sum('cod');
      // dd($parcelprice);
        $deliveryCharge= $parcelprice =Parcel::where('agentId',Session::get('agentId'))->sum('deliveryCharge');
      
        $codCharge= $parcelprice =Parcel::where('agentId',Session::get('agentId'))->sum('codCharge');
      
        $Collectedamount =Parcel::where('agentId',Session::get('agentId'))->sum('cod');
      
        $parcelcount =Parcel::where('agentId',Session::get('agentId'))->count();
        
        $allparcel = DB::table('parcels')
        ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.agentId',Session::get('agentId'))
        ->select('parcels.*','merchants.companyName','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress')
        ->orderBy('parcels.id','DESC')
        ->get();
       }
       $aparceltypes = Parceltype::limit(8)->get();
      return view('frontEnd.layouts.pages.agent.parcels',compact('allparcel','aparceltypes','parcelr','parcelc','parcelre','parcelpa','parcelpictd','parcelinterjit','parcelhold','parcelrrtupa','parcelrrhub','parcelpriceCOD','deliveryCharge','codCharge','Collectedamount','parcelcount'));
  }
   public function parcels(Request $request){
        // dd($request);
          $aparceltypes = Parceltype::where('slug',$request->slug)->first();
       $filter = $request->filter_id;
       if($request->trackId!=NULL){
         $parcelr =Parcel::where('agentId',Session::get('agentId'))->where('status',4)->where('trackingCode',$request->trackId)->count();
        $parcelc =Parcel::where('agentId',Session::get('agentId'))->where('status',9)->where('trackingCode',$request->trackId)->count();
        $parcelre =Parcel::where('agentId',Session::get('agentId'))->where('status',8)->where('trackingCode',$request->trackId)->count();
        $parcelpa =Parcel::where('agentId',Session::get('agentId'))->where('status',1)->where('trackingCode',$request->trackId)->count();
      
        $parcelpictd =Parcel::where('agentId',Session::get('agentId'))->where('status',2)->where('trackingCode',$request->trackId)->count();
        $parcelinterjit =Parcel::where('agentId',Session::get('agentId'))->where('status',3)->where('trackingCode',$request->trackId)->count();
        $parcelhold =Parcel::where('agentId',Session::get('agentId'))->where('status',5)->where('trackingCode',$request->trackId)->count();
        $parcelrrtupa =Parcel::where('agentId',Session::get('agentId'))->where('status',6)->where('trackingCode',$request->trackId)->count();
        $parcelrrhub =Parcel::where('agentId',Session::get('agentId'))->where('status',7)->where('trackingCode',$request->trackId)->count();
      
        $parcelpriceCOD =Parcel::where('agentId',Session::get('agentId'))->where('status','!=',9)->where('trackingCode',$request->trackId)->sum('cod');
      // dd($parcelprice);
        $deliveryCharge= $parcelprice =Parcel::where('agentId',Session::get('agentId'))->where('trackingCode',$request->trackId)->sum('deliveryCharge');
      
        $codCharge= $parcelprice =Parcel::where('agentId',Session::get('agentId'))->where('trackingCode',$request->trackId)->sum('codCharge');
      
        $Collectedamount =Parcel::where('agentId',Session::get('agentId'))->where('status',4)->where('trackingCode',$request->trackId)->sum('cod');
      
        $parcelcount =Parcel::where('agentId',Session::get('agentId'))->where('trackingCode',$request->trackId)->count();
        $allparcel = DB::table('parcels')
        ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.agentId',Session::get('agentId'))
        ->where('parcels.trackingCode',$request->trackId)
        ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->orderBy('id','DESC')
        ->get();
       }elseif($request->phoneNumber!=NULL){
        $allparcel = DB::table('parcels')
        ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.agentId',Session::get('agentId'))
        ->where('parcels.recipientPhone',$request->phoneNumber)
        ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->orderBy('id','DESC')
        ->get();
       }elseif($request->startDate!=NULL && $request->endDate!=NULL){
            $parcelr =Parcel::where('agentId',Session::get('agentId'))->where('status',4)->where('parcels.status',$aparceltypes->id)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
        $parcelc =Parcel::where('agentId',Session::get('agentId'))->where('status',9)->where('parcels.status',$aparceltypes->id)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
        $parcelre =Parcel::where('agentId',Session::get('agentId'))->where('status',8)->where('parcels.status',$aparceltypes->id)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
        $parcelpa =Parcel::where('agentId',Session::get('agentId'))->where('status',1)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
      
        $parcelpictd =Parcel::where('agentId',Session::get('agentId'))->where('status',2)->where('parcels.status',$aparceltypes->id)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
        $parcelinterjit =Parcel::where('agentId',Session::get('agentId'))->where('status',3)->where('parcels.status',$aparceltypes->id)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
        $parcelhold =Parcel::where('agentId',Session::get('agentId'))->where('status',5)->where('parcels.status',$aparceltypes->id)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
        $parcelrrtupa =Parcel::where('agentId',Session::get('agentId'))->where('status',6)->where('parcels.status',$aparceltypes->id)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
        $parcelrrhub =Parcel::where('agentId',Session::get('agentId'))->where('status',7)->where('parcels.status',$aparceltypes->id)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
      
        $parcelpriceCOD =Parcel::where('agentId',Session::get('agentId'))->where('status','!=',9)->where('parcels.status',$aparceltypes->id)->whereBetween('updated_at', [$request->startDate, $request->endDate])->sum('cod');
      // dd($parcelprice);
        $deliveryCharge= $parcelprice =Parcel::where('agentId',Session::get('agentId'))->where('parcels.status',$aparceltypes->id)->whereBetween('updated_at', [$request->startDate, $request->endDate])->sum('deliveryCharge');
      
        $codCharge= $parcelprice =Parcel::where('agentId',Session::get('agentId'))->where('parcels.status',$aparceltypes->id)->whereBetween('updated_at', [$request->startDate, $request->endDate])->sum('codCharge');
      
        $Collectedamount =Parcel::where('agentId',Session::get('agentId'))->where('status',4)->where('parcels.status',$aparceltypes->id)->whereBetween('updated_at', [$request->startDate, $request->endDate])->sum('cod');
      
        $parcelcount =Parcel::where('agentId',Session::get('agentId'))->where('parcels.status',$aparceltypes->id)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
        $allparcel = DB::table('parcels')
        ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.agentId',Session::get('agentId'))->where('parcels.status',$aparceltypes->id)
        ->whereBetween('parcels.updated_at',[$request->startDate, $request->endDate])
        ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->orderBy('id','DESC')
        ->get();
       }elseif($request->phoneNumber!=NULL || $request->phoneNumber!=NULL && $request->startDate!=NULL && $request->endDate!=NULL){
        $allparcel = DB::table('parcels')
        ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.agentId',Session::get('agentId'))
        ->where('parcels.recipientPhone',$request->phoneNumber)
        ->whereBetween('parcels.updated_at',[$request->startDate, $request->endDate])
        ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
        ->orderBy('id','DESC')
        ->get();
       }else{
        $parcelr =Parcel::where('agentId',Session::get('agentId'))->where('parcels.status',$aparceltypes->id)->where('status',4)->count();
        $parcelc =Parcel::where('agentId',Session::get('agentId'))->where('parcels.status',$aparceltypes->id)->where('status',9)->count();
        $parcelre =Parcel::where('agentId',Session::get('agentId'))->where('parcels.status',$aparceltypes->id)->where('status',8)->count();
        $parcelpa =Parcel::where('agentId',Session::get('agentId'))->where('status',1)->count();
      
        $parcelpictd =Parcel::where('agentId',Session::get('agentId'))->where('parcels.status',$aparceltypes->id)->where('status',2)->count();
        $parcelinterjit =Parcel::where('agentId',Session::get('agentId'))->where('parcels.status',$aparceltypes->id)->where('status',3)->count();
        $parcelhold =Parcel::where('agentId',Session::get('agentId'))->where('parcels.status',$aparceltypes->id)->where('status',5)->count();
        $parcelrrtupa =Parcel::where('agentId',Session::get('agentId'))->where('parcels.status',$aparceltypes->id)->where('status',6)->count();
        $parcelrrhub =Parcel::where('agentId',Session::get('agentId'))->where('parcels.status',$aparceltypes->id)->where('status',7)->count();
      
        $parcelpriceCOD =Parcel::where('agentId',Session::get('agentId'))->where('parcels.status',$aparceltypes->id)->where('status','!=',9)->sum('cod');
      // dd($parcelprice);
        $deliveryCharge= $parcelprice =Parcel::where('agentId',Session::get('agentId'))->where('parcels.status',$aparceltypes->id)->sum('deliveryCharge');
      
        $codCharge= $parcelprice =Parcel::where('agentId',Session::get('agentId'))->where('parcels.status',$aparceltypes->id)->sum('codCharge');
      
        $Collectedamount =Parcel::where('agentId',Session::get('agentId'))->where('parcels.status',$aparceltypes->id)->sum('cod');
      
        $parcelcount =Parcel::where('agentId',Session::get('agentId'))->where('parcels.status',$aparceltypes->id)->count();
        
        $allparcel = DB::table('parcels')
        ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.agentId',Session::get('agentId'))->where('parcels.status',$aparceltypes->id)
        ->select('parcels.*','merchants.companyName','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress')
        ->orderBy('parcels.id','DESC')
        ->get();
       }
       $aparceltypes = Parceltype::limit(8)->get();
      return view('frontEnd.layouts.pages.agent.parcels',compact('allparcel','aparceltypes','parcelr','parcelc','parcelre','parcelpa','parcelpictd','parcelinterjit','parcelhold','parcelrrtupa','parcelrrhub','parcelpriceCOD','deliveryCharge','codCharge','Collectedamount','parcelcount'));
  }
  public function accept($id){
    // dd($id);
    $parcel= Parcel::where('id',$id)->first();
    // dd($parcel);
    $parcel->agentAprove=1;
    $parcel->save();
    Toastr::success('message', 'Parcel has been accept successfully!');
      return redirect()->back();


  }
   public function invoice($id){
    $show_data = DB::table('parcels')
    ->join('merchants', 'merchants.id','=','parcels.merchantId')
    ->where('parcels.agentId',Session::get('agentId'))
    ->join('nearestzones', 'parcels.reciveZone','=','nearestzones.id')
    ->where('parcels.id',$id)
    ->select('parcels.*','nearestzones.zonename','merchants.companyName','merchants.phoneNumber','merchants.emailAddress')
    ->first();
        if($show_data!=NULL){
        	return view('frontEnd.layouts.pages.agent.invoice',compact('show_data'));
        }else{
          Toastr::error('Opps!', 'Your process wrong');
          return redirect()->back();
        }
    }
  public function delivermanasiagn(Request $request){
      $this->validate($request,[
        'deliverymanId'=>'required',
      ]);
      $parcel = Parcel::find($request->hidden_id);
      $parcel->deliverymanId = $request->deliverymanId;
      $parcel->save();

      Toastr::success('message', 'A deliveryman asign successfully!');
      return redirect()->back();
      $deliverymanInfo = Deliveryman::find($parcel->deliverymanId);
      $merchantinfo =Agent::find($parcel->merchantId);
      $data = array(
       'contact_mail' => $merchantinfo->email,
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
    //   return $request->all();
      $this->validate($request,[
        'status'=>'required',
      ]); 
      $parcel = Parcel::find($request->hidden_id);
      $parcel->status = $request->status;
      $parcel->present_date =date("Y-m-d");
      $parcel->save();
      if($request->note){
            $note = new Parcelnote();
            $note->parcelId = $request->hidden_id;            
            $note->note = $request->note;
            $note->user=Session::get('agentName');
            $note->save();
        }
        if($request->snote){
          $note = new Parcelnote();
          $note->parcelId = $request->hidden_id;            
          $note->note = $request->snote;
          $note->user=Session::get('agentName');
        //   $note->user=Auth::user()->username;
          $note->save();
      }
      if($request->snote && $request->note){
        $note = new Parcelnote();
        $note->parcelId = $request->hidden_id;            
        $note->note = $request->snote;
        $note->user=Session::get('agentName');
        // $note->user=Auth::user()->username;
        $note->save();
    }
        if($request->status==3){
            // $codcharge=$request->customerpay/100;
            $codcharge=0;
            $parcel->merchantAmount=($parcel->merchantAmount)-($codcharge);
            $parcel->merchantDue=($parcel->merchantAmount)-($codcharge);
            $parcel->codCharge=$codcharge;
            $parcel->save();
        }
        $deliverymanInfo =Deliveryman::where(['id'=>$parcel->deliverymanId])->first();
         if($request->status==2 && $deliverymanInfo!=NULL){
            $merchantinfo =Agent::find($parcel->merchantId);
            $data = array(
             'contact_mail' => $merchantinfo->email,
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
         if($request->status==4){
            $merchantinfo = Merchant::find($parcel->merchantId);
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
  public function logout(){
      Session::flush();
      Toastr::success('Success!', 'Thanks! you are logout successfully');
      return redirect('agent/logout');
  }
 public function pickup(){
      $show_data = DB::table('pickups')
      ->where('pickups.agent',Session::get('agentId'))
      ->orderBy('pickups.id','DESC')
      ->select('pickups.*')
      ->get();
      $deliverymen = Deliveryman::where('status',1)->get();
      return view('frontEnd.layouts.pages.agent.pickup',compact('show_data','deliverymen'));
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
    
        if($request->status==2){
            $deliverymanInfo =Deliveryman::where(['id'=>$pickup->deliveryman])->first();
            // $data = array(
            //  'name' => $deliverymanInfo->name,
            //  'companyname' => $merchantInfo->companyName,
            //  'phone' => $deliverymanInfo->phone,
            //  'address' => $merchantInfo->pickLocation,
            // );
            // $send = Mail::send('frontEnd.emails.pickupdeliveryman', $data, function($textmsg) use ($data){
            //  $textmsg->from('info@flingex.com');
            //  $textmsg->to($data['contact_mail']);
            //  $textmsg->subject('Pickup request update');
            // });
        }
      Toastr::success('message', 'Pickup status update successfully!');
      return redirect()->back();
    }
   public function passreset(){
      return view('frontEnd.layouts.pages.agent.passreset');
    }
    public function passfromreset(Request $request){
      $this->validate($request,[
            'email' => 'required',
        ]);
        $validAgent =Agent::Where('email',$request->email)
       ->first();
        if($validAgent){
             $verifyToken=rand(111111,999999);
             $validAgent->passwordReset  = $verifyToken;
             $validAgent->save();
             Session::put('resetAgentId',$validAgent->id);
             
             $data = array(
             'contact_mail' => $validAgent->email,
             'verifyToken' => $verifyToken,
            );
            $send = Mail::send('frontEnd.layouts.pages.agent.forgetemail', $data, function($textmsg) use ($data){
             $textmsg->from('info@flingex.com');
             $textmsg->to($data['contact_mail']);
             $textmsg->subject('Forget password token');
            });
          return redirect('agent/resetpassword/verify');
        }else{
              Toastr::error('Sorry! You have no account', 'warning!');
             return redirect()->back();
        }
    }
    public function saveResetPassword(Request $request){
       $validAgent =Agent::find(Session::get('resetAgentId'));
        if($validAgent->passwordReset==$request->verifyPin){
           $validAgent->password   = bcrypt(request('newPassword'));
           $validAgent->passwordReset  = NULL;
             $validAgent->save();
             
             Session::forget('resetAgentId');
             Session::put('agentId',$validAgent->id);
             Toastr::success('Wow! Your password reset successfully', 'success!');
             return redirect('agent/dashboard');
        }else{
            Toastr::error('Sorry! Your process something wrong', 'warning!');
             return redirect()->back();
        }
       
    }
    public function resetpasswordverify(){
        if(Session::get('resetAgentId')){
        return view('frontEnd.layouts.pages.agent.passwordresetverify');
        }else{
            Toastr::error('Sorry! Your process something wrong', 'warning!');
            return redirect('forget/password');
        }
    }
    public function export( Request $request ) {
        return Excel::download( new AgentParcelExport(), 'parcel.xlsx') ;
    
    }
    public function report(Request $request){
      if ($request->startDate) {
      
        
        $parcelr =Parcel::where('agentId',Session::get('agentId'))->where('status',4)->whereBetween('present_date', [$request->startDate, $request->endDate])->count();
        $parcelc =Parcel::where('agentId',Session::get('agentId'))->where('status',9)->whereBetween('present_date', [$request->startDate, $request->endDate])->count();
        $parcelre =Parcel::where('agentId',Session::get('agentId'))->where('status',8)->whereBetween('present_date', [$request->startDate, $request->endDate])->count();
        $parcelpa =Parcel::where('agentId',Session::get('agentId'))->where('status',1)->whereBetween('present_date', [$request->startDate, $request->endDate])->count();
      
        $parcelpictd =Parcel::where('agentId',Session::get('agentId'))->where('status',2)->whereBetween('present_date', [$request->startDate, $request->endDate])->count();
        $parcelinterjit =Parcel::where('agentId',Session::get('agentId'))->where('status',3)->whereBetween('present_date', [$request->startDate, $request->endDate])->count();
        $parcelhold =Parcel::where('agentId',Session::get('agentId'))->where('status',5)->whereBetween('present_date', [$request->startDate, $request->endDate])->count();
        $parcelrrtupa =Parcel::where('agentId',Session::get('agentId'))->where('status',6)->whereBetween('present_date', [$request->startDate, $request->endDate])->count();
        $parcelrrhub =Parcel::where('agentId',Session::get('agentId'))->where('status',7)->whereBetween('present_date', [$request->startDate, $request->endDate])->count();
      
        $parcelpriceCOD =Parcel::where('agentId',Session::get('agentId'))->where('status','!=',9)->whereBetween('present_date', [$request->startDate, $request->endDate])->sum('cod');
      // dd($parcelprice);
        $deliveryCharge= $parcelprice =Parcel::where('agentId',Session::get('agentId'))->whereBetween('present_date', [$request->startDate, $request->endDate])->sum('deliveryCharge');
      
        $codCharge= $parcelprice =Parcel::where('agentId',Session::get('agentId'))->whereBetween('present_date', [$request->startDate, $request->endDate])->sum('codCharge');
      
        $Collectedamount =Parcel::where('agentId',Session::get('agentId'))->where('status',4)->whereBetween('present_date', [$request->startDate, $request->endDate])->sum('cod');
      
        $parcelcount =Parcel::where('agentId',Session::get('agentId'))->whereBetween('present_date', [$request->startDate, $request->endDate])->count();
  
        $parcels = DB::table('parcels')
              ->join('merchants', 'merchants.id','=','parcels.merchantId')
        ->where('parcels.agentId',Session::get('agentId'))->whereBetween('parcels.present_date', [$request->startDate, $request->endDate])
              ->orderBy('parcels.id','DESC')
              ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
              ->get();
  
      }
      else{
        $parcelr =Parcel::where('agentId',Session::get('agentId'))->where('status',4)->count();
        $parcelc =Parcel::where('agentId',Session::get('agentId'))->where('status',9)->count();
        $parcelre =Parcel::where('agentId',Session::get('agentId'))->where('status',8)->count();
        $parcelpa =Parcel::where('agentId',Session::get('agentId'))->where('status',1)->count();
      
        $parcelpictd =Parcel::where('agentId',Session::get('agentId'))->where('status',2)->count();
        $parcelinterjit =Parcel::where('agentId',Session::get('agentId'))->where('status',3)->count();
        $parcelhold =Parcel::where('agentId',Session::get('agentId'))->where('status',5)->count();
        $parcelrrtupa =Parcel::where('agentId',Session::get('agentId'))->where('status',6)->count();
        $parcelrrhub =Parcel::where('agentId',Session::get('agentId'))->where('status',7)->count();
      
        $parcelpriceCOD =Parcel::where('agentId',Session::get('agentId'))->where('status','!=',9)->sum('cod');
      // dd($parcelprice);
        $deliveryCharge =Parcel::where('agentId',Session::get('agentId'))->sum('deliveryCharge');
      
        $codCharge= Parcel::where('agentId',Session::get('agentId'))->sum('codCharge');
      
        $Collectedamount =Parcel::where('agentId',Session::get('agentId'))->where('status',4)->sum('cod');
      
        $parcelcount =Parcel::where('agentId',Session::get('agentId'))->count();

      $parcels = DB::table('parcels')
              ->join('merchants', 'merchants.id','=','parcels.merchantId')->where('parcels.agentId',Session::get('agentId'))
              ->orderBy('parcels.id','DESC')
              ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
              ->get();
      }
      
      return view('frontEnd.layouts.pages.agent.report')->with('parcels',$parcels)->with('parcelr',@$parcelr)->with('parcelcount',@$parcelcount)->with('parcelc',@$parcelc)->with('parcelpriceCOD',@$parcelpriceCOD)->with('parcelpa',@$parcelpa)->with('parcelre',@$parcelre)->with('id',@$id)->with('parcelpictd',@$parcelpictd)->with('parcelinterjit',@$parcelinterjit)->with('parcelhold',@$parcelhold)->with('parcelrrtupa',@$parcelrrtupa)->with('parcelrrhub',@$parcelrrhub)->with('deliveryCharge',@$deliveryCharge)->with('codCharge',@$codCharge)->with('Collectedamount',@$Collectedamount);
    }


public function asingreport(Request $request){
      $dates=$request->startDate;
      $datee=$request->endDate;
      $id=$request->agent;
      $deliveryman=Deliveryman::where('agentId',Session::get('agentId'))->get();
  // 		dd($agent);
      if ($request->agent  && $request->startDate==null && $request->endDate==null) {
  // 			$id=$request->agent;
        
        $parcelr =Parcel::where('agentId',Session::get('agentId'))->where('deliverymanId',$request->agent)->where('status',4)->count();
        $parcelc =Parcel::where('agentId',Session::get('agentId'))->where('deliverymanId',$request->agent)->where('status',9)->count();
        $parcelre =Parcel::where('agentId',Session::get('agentId'))->where('deliverymanId',$request->agent)->where('status',8)->count();
        $parcelpa =Parcel::where('deliverymanId',$request->agent)->where('status',1)->count();
      
        $parcelpictd =Parcel::where('agentId',Session::get('agentId'))->where('deliverymanId',$request->agent)->where('status',2)->count();
        $parcelinterjit =Parcel::where('agentId',Session::get('agentId'))->where('deliverymanId',$id)->where('status',3)->count();
        $parcelhold =Parcel::where('agentId',Session::get('agentId'))->where('deliverymanId',$request->agent)->where('status',5)->count();
        $parcelrrtupa =Parcel::where('deliverymanId',$request->agent)->where('status',6)->count();
        $parcelrrhub =Parcel::where('agentId',Session::get('agentId'))->where('deliverymanId',$request->agent)->where('status',7)->count();
      
        $parcelpriceCOD =Parcel::where('agentId',Session::get('agentId'))->where('deliverymanId',$request->agent)->where('status','!=',9)->sum('cod');
       //dd($parcelprice);
        $deliveryCharge= $parcelprice =Parcel::where('agentId',Session::get('agentId'))->where('deliverymanId',$request->agent)->sum('deliveryCharge');
      
        $codCharge= $parcelprice =Parcel::where('agentId',Session::get('agentId'))->where('deliverymanId',$request->agent)->sum('codCharge');
      
        $Collectedamount =Parcel::where('agentId',Session::get('agentId'))->where('deliverymanId',$request->agent)->sum('cod');
      
        $parcelcount =Parcel::where('agentId',Session::get('agentId'))->where('deliverymanId',$request->agent)->count();
  
        $parcels = DB::table('parcels')
              ->join('merchants', 'merchants.id','=','parcels.merchantId')->where('agentId',Session::get('agentId'))
        ->where('parcels.deliverymanId',$request->agent)
              ->orderBy('parcels.id','DESC')
              ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
              ->get();
  
      }
      elseif($request->agent!=NULL  && $request->startDate!=NULL && $request->endDate!=NULL){ 
          $id=$request->agent;
        
        $parcelr =Parcel::where('agentId',Session::get('agentId'))->where('deliverymanId',$request->agent)->where('status',4)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelc =Parcel::where('agentId',Session::get('agentId'))->where('deliverymanId',$request->agent)->where('status',9)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelre =Parcel::where('agentId',Session::get('agentId'))->where('deliverymanId',$request->agent)->where('status',8)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelpa =Parcel::where('agentId',Session::get('agentId'))->where('deliverymanId',$request->agent)->where('status',1)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      
        $parcelpictd =Parcel::where('agentId',Session::get('agentId'))->where('deliverymanId',$request->agent)->where('status',2)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelinterjit =Parcel::where('agentId',Session::get('agentId'))->where('deliverymanId',$id)->where('status',3)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelhold =Parcel::where('agentId',Session::get('agentId'))->where('deliverymanId',$request->agent)->where('status',5)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelrrtupa =Parcel::where('agentId',Session::get('agentId'))->where('deliverymanId',$request->agent)->where('status',6)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $parcelrrhub =Parcel::where('agentId',Session::get('agentId'))->where('deliverymanId',$request->agent)->where('status',7)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
      
        $parcelpriceCOD =Parcel::where('agentId',Session::get('agentId'))->where('deliverymanId',$request->agent)->where('status','!=',9)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('cod');
      // dd($parcelprice);
        $deliveryCharge= $parcelprice =Parcel::where('deliverymanId',$request->agent)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('deliveryCharge');
      
        $codCharge= $parcelprice =Parcel::where('agentId',Session::get('agentId'))->where('deliverymanId',$request->agent)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('codCharge');
      
        $Collectedamount =Parcel::where('agentId',Session::get('agentId'))->where('deliverymanId',$request->agent)->where('status',4)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('cod');
      
        $parcelcount =Parcel::where('agentId',Session::get('agentId'))->where('deliverymanId',$request->agent)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
  
        $parcels = DB::table('parcels')
              ->join('merchants', 'merchants.id','=','parcels.merchantId')->where('agentId',Session::get('agentId'))
        ->where('parcels.deliverymanId',$request->agent)->whereBetween('parcels.created_at', [$request->startDate, $request->endDate])
              ->orderBy('parcels.id','DESC')
              ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
              ->get();
      }
      else{
        $parcelr =Parcel::where('agentId',Session::get('agentId'))->where('status',4)->count();
        $parcelc =Parcel::where('agentId',Session::get('agentId'))->where('status',9)->count();
        $parcelre =Parcel::where('agentId',Session::get('agentId'))->where('status',8)->count();
        $parcelpa =Parcel::where('agentId',Session::get('agentId'))->where('status',1)->count();
      
        $parcelpictd =Parcel::where('agentId',Session::get('agentId'))->where('status',2)->count();
        $parcelinterjit =Parcel::where('agentId',Session::get('agentId'))->where('status',3)->count();
        $parcelhold =Parcel::where('agentId',Session::get('agentId'))->where('status',5)->count();
        $parcelrrtupa =Parcel::where('agentId',Session::get('agentId'))->where('status',6)->count();
        $parcelrrhub =Parcel::where('agentId',Session::get('agentId'))->where('status',7)->count();
      
        $parcelpriceCOD =Parcel::where('agentId',Session::get('agentId'))->where('status','!=',9)->sum('cod');
       //dd($parcelprice);
        $deliveryCharge= $parcelprice =Parcel::where('agentId',Session::get('agentId'))->sum('deliveryCharge');
      
        $codCharge= $parcelprice =Parcel::where('agentId',Session::get('agentId'))->sum('codCharge');
      
        $Collectedamount =Parcel::where('agentId',Session::get('agentId'))->sum('cod');
      
        $parcelcount =Parcel::where('agentId',Session::get('agentId'))->count();
      $parcels = DB::table('parcels')
              ->join('merchants', 'merchants.id','=','parcels.merchantId')
              ->orderBy('parcels.id','DESC')->where('parcels.agentId',Session::get('agentId'))
              ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
              ->get();
      }
      
      return view('frontEnd.layouts.pages.agent.asigndelivery')->with('deliveryman',@$deliveryman)->with('parcels',@$parcels)->with('parcelr',@$parcelr)->with('parcelcount',@$parcelcount)->with('parcelc',@$parcelc)->with('parcelpriceCOD',@$parcelpriceCOD)->with('parcelpa',@$parcelpa)->with('parcelre',@$parcelre)->with('id',@$id)->with('parcelpictd',@$parcelpictd)->with('parcelinterjit',@$parcelinterjit)->with('parcelhold',@$parcelhold)->with('parcelrrtupa',@$parcelrrtupa)->with('parcelrrhub',@$parcelrrhub)->with('deliveryCharge',@$deliveryCharge)->with('codCharge',@$codCharge)->with('Collectedamount',@$Collectedamount)->with('aid',@$id)->with('dates',@$dates)->with('datee',@$datee);
    }

    public function partial_pay(Request $request){  

      $parcel = Parcel::find($request->id);
    	$parcel->partial_pay = $request->partial_pay;
    	$parcel->save();
      Toastr::success('message', 'Partial Pay Add successfully!');
    	return redirect()->back();
    }
}