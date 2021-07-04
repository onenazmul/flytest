<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Nearestzone;
use App\Deliveryman;
use App\Agent; 
use DB;
class DeliverymanManageController extends Controller
{
    
    public function add(){
    $areas = Nearestzone::where('status',1)->get();
    $hub = Agent::where('status',1)->get();
    return view('backEnd.deliveryman.add',compact('areas','hub'));
   }
    public function save(Request $request){
    	$this->validate($request,[
    		'name'=>'required',
    		'email'=>'required',
    		'phone'=>'required',
    		'designation'=>'required',
    		'area'=>'required',
    		'image'=>'required',
    		'password'=>'required',
            'status'=>'required',
    	]);
        
    	// image upload
    	$file = $request->file('image');
    	$name = time().$file->getClientOriginalName();
    	$uploadPath = 'public/uploads/deliveryman/';
    	$file->move($uploadPath,$name);
    	$fileUrl =$uploadPath.$name;

    	$store_data					=	new Deliveryman();
    	$store_data->name 			=	$request->name;
    	$store_data->agentId 		=	$request->hub;
    	$store_data->email  		= 	$request->email;
    	$store_data->phone  		= 	$request->phone;
    	$store_data->designation 	= 	$request->designation;
    	$store_data->area 			= 	$request->area;
    	$store_data->password 		= 	bcrypt(request('password'));
    	$store_data->image 			= 	$fileUrl;
    	$store_data->status 		= 	$request->status;
    	$store_data->save();
        Toastr::success('message', 'Deliveryman add successfully!');
    	return redirect('admin/deliveryman/manage');
    }
   
   public function manage(){
    	$show_datas = DB::table('deliverymen')
    	->join('nearestzones', 'deliverymen.area', '=', 'nearestzones.id' )
    	->select('deliverymen.*', 'nearestzones.zonename')
        ->orderBy('id','DESC')
    	->get();
    	return view('backEnd.deliveryman.manage',compact('show_datas'));
    }

    public function edit($id){
        $edit_data = Deliveryman::find($id);
        $areas = Nearestzone::where('status',1)->get();
		$hub = Agent::where('status',1)->get();
    	return view('backEnd.deliveryman.edit',compact('edit_data','areas','hub'));
    }

    public function update(Request $request){
    	$this->validate($request,[
    		'name'=>'required',
    		'email'=>'required',
    		'phone'=>'required',
    		'designation'=>'required',
    		'area'=>'required',
    		'status'=>'required',
    	]);
    	$update_data = Deliveryman::find($request->hidden_id);
	
    	// image upload
    	$update_file = $request->file('image');
    	if ($update_file) {
	    	$name = time().$update_file->getClientOriginalName();
	    	$uploadPath = 'public/uploads/deliveryman/';
	    	$update_file->move($uploadPath,$name);
	    	$fileUrl =$uploadPath.$name;
    	}else{
    		$fileUrl = $update_data->image;
    	}

    	$update_data->name 			=	$request->name;

		$update_data->agentId 		=	$request->hub;
		
    	$update_data->email  		= 	$request->email;
    	$update_data->phone  		= 	$request->phone;
    	$update_data->designation 	= 	$request->designation;
    	$update_data->area 			= 	$request->area;
    	$update_data->password 		= 	bcrypt(request('password'));
    	$update_data->image 		= 	$fileUrl;
    	$update_data->status 		= 	$request->status;
    	$update_data->save();
        Toastr::success('message', 'Employee update successfully!');
    	return redirect('admin/deliveryman/manage');
    }

    public function inactive(Request $request){
        $inactive_data = Deliveryman::find($request->hidden_id);
        $inactive_data->status=0;
        $inactive_data->save();
        Toastr::success('message', 'Employee inactive successfully!');
        return redirect('admin/deliveryman/manage');      
    }

    public function active(Request $request){
        $inactive_data = Deliveryman::find($request->hidden_id);
        $inactive_data->status=1;
        $inactive_data->save();
        Toastr::success('message', 'Employee active successfully!');
        return redirect('admin/deliveryman/manage');        
    }

    public function destroy(Request $request){
        $destroy_id = Deliveryman::find($request->hidden_id);
        $destroy_id->delete();
        Toastr::success('message', 'Employee delete successfully!');
        return redirect('admin/deliveryman/manage');         
    }
}
