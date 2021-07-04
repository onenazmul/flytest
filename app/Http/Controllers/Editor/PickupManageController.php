<?php

namespace App\Http\Controllers\editor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Pickup;
use App\PickDrop;
use App\Codcharge;
use App\Merchant;
use App\Deliveryman;
use DB;
use App\Post;
use Mail;
use Auth;
use Exception;
class PickupManageController extends Controller
{
   
    public function newpickup(Request $request){
		if ($request->dman=='all' && $request->startDate!=null && $request->endDate!=null) {
			$total=PickDrop::whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
		$tprice=PickDrop::whereBetween('updated_at', [$request->startDate, $request->endDate])->sum('price');
		$tpanding= PickDrop::whereBetween('updated_at', [$request->startDate, $request->endDate])->where('status','Pending')->count();
		$tcancel= PickDrop::whereBetween('updated_at', [$request->startDate, $request->endDate])->where('status','Cancelled')->count();
		$taccept= PickDrop::whereBetween('updated_at', [$request->startDate, $request->endDate])->where('status','Accepted')->count();
		$tdeliverd= PickDrop::whereBetween('updated_at', [$request->startDate, $request->endDate])->where('status','Delivered')->count();
    	$show_data = DB::table('pick_drops')->whereBetween('updated_at', [$request->startDate, $request->endDate])
    	->orderBy('pick_drops.id','DESC')
    	->select('pick_drops.*')
    	->get();
			 
		}
		elseif($request->dman!=null && $request->startDate!=null && $request->endDate!=null){
			$total=PickDrop::where('id',$request->dman)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
		$tprice=PickDrop::where('id',$request->dman)->whereBetween('updated_at', [$request->startDate, $request->endDate])->sum('price');
		$tpanding= PickDrop::where('id',$request->dman)->whereBetween('updated_at', [$request->startDate, $request->endDate])->where('status','Pending')->count();
		$tcancel= PickDrop::where('id',$request->dman)->whereBetween('updated_at', [$request->startDate, $request->endDate])->where('status','Cancelled')->count();
		$taccept= PickDrop::where('id',$request->dman)->whereBetween('updated_at', [$request->startDate, $request->endDate])->where('status','Accepted')->count();
		$tdeliverd= PickDrop::where('id',$request->dman)->whereBetween('updated_at', [$request->startDate, $request->endDate])->where('status','Delivered')->count();
    	$show_data = DB::table('pick_drops')->where('id',$request->dman)->whereBetween('updated_at', [$request->startDate, $request->endDate])
    	->orderBy('pick_drops.id','DESC')
    	->select('pick_drops.*')
    	->get();
		}
		
		else{
		$total=PickDrop::count();
		$tprice=PickDrop::sum('price');
		$tpanding= PickDrop::where('status','Pending')->count();
		$tcancel= PickDrop::where('status','Cancelled')->count();
		$taccept= PickDrop::where('status','Accepted')->count();
		$tdeliverd= PickDrop::where('status','Delivered')->count();
    	$show_data = DB::table('pick_drops')
    	->orderBy('pick_drops.id','DESC')
    	->select('pick_drops.*')
    	->get();
	}
		$delivery=Deliveryman::get();
    	return view('backEnd.pickup.new',compact('show_data','delivery','total','tprice','tpanding','tcancel','taccept','tdeliverd'));
    }

    public function pendingpickup(){
		$delivery=Deliveryman::get();
    	$show_data = DB::table('pick_drops')
    	->join('deliverymen','pick_drops.deliveryId','=','deliverymen.id')
    	->where('pick_drops.status','Pending')
    	->orderBy('pick_drops.id','DESC')
    	->select('pick_drops.*','deliverymen.name','deliverymen.phone')
    	->get();
    	return view('backEnd.pickup.pending',compact('show_data','delivery'));
    }

    public function acceptedpickup(){
		$delivery=Deliveryman::get();
    	$show_data = DB::table('pick_drops')
    	->join('deliverymen','pick_drops.deliveryId','=','deliverymen.id')
    	 ->where('pick_drops.status','Accepted')
    	->orderBy('pick_drops.id','DESC')
    	->select('pick_drops.*','deliverymen.name','deliverymen.phone')
    	->get();
    	return view('backEnd.pickup.accepted',compact('show_data','delivery'));
    }

    public function cancelled(){
		$s='Cancelled';
		$delivery=Deliveryman::get();
    	$show_data = DB::table('pick_drops')
    	->join('deliverymen','pick_drops.deliveryId','=','deliverymen.id')
    	 ->where('pick_drops.status','Cancelled')
    	->orderBy('pick_drops.id','DESC')
    	->select('pick_drops.*','deliverymen.name','deliverymen.phone')
    	->get();
    	return view('backEnd.pickup.cancelled',compact('show_data','delivery','s'));
    }

	public function delivered(){
		$s='Delivered';
		$delivery=Deliveryman::get();
    	$show_data = DB::table('pick_drops')
    	->join('deliverymen','pick_drops.deliveryId','=','deliverymen.id')
    	 ->where('pick_drops.status','Delivered')
    	->orderBy('pick_drops.id','DESC')
    	->select('pick_drops.*','deliverymen.name','deliverymen.phone')
    	->get();
    	return view('backEnd.pickup.cancelled',compact('show_data','delivery','s'));
    }
    public function agentmanasign(Request $request){
		// dd($request);
    	// $this->validate($request,[
    	// 	'deliveryId'=>'required',
    	// ]);
    	$parcel = PickDrop::find($request->hidden_id);
		
    	$parcel->deliveryId = $request->deliverid;
    	$parcel->save();
        Toastr::success('message', 'Pick & Drop deliverymen update successfully!');
        return redirect()->back();

    }

    public function statusupdate(Request $request){
    	$this->validate($request,[
    		'status'=>'required',
    	]);
    	$pickup = PickDrop::find($request->hidden_id);
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
            //  $textmsg->from('info@hazicourier.com.bd');
            //  $textmsg->to($data['contact_mail']);
            //  $textmsg->subject('Pickup request update');
            // });
        }
    	Toastr::success('message', 'Pick & Drop information update successfully!');
    	return redirect()->back();
    }

	public function pickdrop(){
// return 1;
		$show_data= PickDrop::orderBy('id','DESC')->get();
		return view('backEnd.pickup.pickdrop',compact('show_data'));

	}
}
