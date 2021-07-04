<?php

namespace App\Http\Controllers\superadmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Customer;
class DashboardController extends Controller
{
    public function index(){
    	return view('backEnd.superadmin.dashboard');
    }
    public function cinactive(Request $request){
	    $active_data         =   Customer::find($request->hidden_id);
	    $active_data->status =  0;
	    $active_data->save();
	    Toastr::success('message', 'customer inactive successfully!');
	    	return redirect()->back();   
		}

		public function cactive(Request $request){
	    $active_data         =   Customer::find($request->hidden_id);
	    $active_data->status =  1;
	    $active_data->save();
	    Toastr::success('message', 'customer active successfully!');
	   	return redirect()->back();     
		}

		public function destroy(Request $request){
        $deleteId = Customer::find($request->hidden_id);
        $deleteId->delete();
        Toastr::success('message', 'customer  delete successfully!');
     	  return redirect()->back();
    	}

}
