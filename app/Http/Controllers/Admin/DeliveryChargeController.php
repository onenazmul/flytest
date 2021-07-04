<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Deliverycharge;
use File;

class DeliveryChargeController extends Controller
{
     public function add(){
    	return view('backEnd.deliverycharge.add');

    }
    public function store(Request $request){
    	$this->validate($request,[
            'title'=>'required',
            'subtitle'=>'required',
            'deliverycharge'=>'required',
            'extradeliverycharge'=>'required',
            'time'=>'required',
            'description'=>'required',
    		'status'=>'required',
    	]);


    	$store_data                    = new Deliverycharge();
    	$store_data->title   	   = $request->title;
    	$store_data->slug   	   =  strtolower(str_replace(array(" ","/",), "-", $request->title));
    	$store_data->subtitle      = $request->subtitle;
    	$store_data->deliverycharge= $request->deliverycharge;
    	$store_data->extradeliverycharge = $request->extradeliverycharge;
    	$store_data->time   	   = $request->time;
    	$store_data->description   = $request->description;
    	$store_data->status        = $request->status;
    	$store_data->save();
    	Toastr::success('message', 'Delivery charge add successfully!');
    	return redirect('/admin/deliverycharge/manage');
    }
     public function manage(){
        $show_data = Deliverycharge::
             orderBy('id','DESC')
            ->get();
    	return view('backEnd.deliverycharge.manage',compact('show_data'));
    }
     public function edit($id){
        $edit_data = Deliverycharge::find($id);
        return view('backEnd.deliverycharge.edit',compact('edit_data'));
    }
      public function update(Request $request){
      	$update_data = Deliverycharge::find($request->hidden_id);
      	$update_data->title   	   = $request->title;
      	$update_data->slug   	   =  strtolower(str_replace(array(" ","/",), "-", $request->title));
    	$update_data->subtitle      = $request->subtitle;
    	$update_data->deliverycharge= $request->deliverycharge;
    	$update_data->extradeliverycharge = $request->extradeliverycharge;
    	$update_data->time   	   = $request->time;
    	$update_data->description   = $request->description;
    	$update_data->status        = $request->status;
    	$update_data->save();
        Toastr::success('message', 'Delivery charge Update successfully!');
        return redirect('admin/deliverycharge/manage');
    }

    public function inactive(Request $request){
        $unpublish_data = Deliverycharge::find($request->hidden_id);
        $unpublish_data->status=0;
        $unpublish_data->save();
        Toastr::success('message', 'Delivery charge active successfully!');
        return redirect('/admin/deliverycharge/manage');
    }

    public function active(Request $request){
        $publishId = Deliverycharge::find($request->hidden_id);
        $publishId->status=1;
        $publishId->save();
        Toastr::success('message', 'Delivery charge active successfully!');
        return redirect('/admin/deliverycharge/manage');
    }

     public function destroy(Request $request){
        $destroy_id = Deliverycharge::find($request->hidden_id);
        $destroy_id->delete();
        Toastr::success('message', 'Delivery charge  delete successfully!');
        return redirect('/admin/deliverycharge/manage');         
    }
}
