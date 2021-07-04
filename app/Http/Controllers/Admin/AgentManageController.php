<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Nearestzone;
use App\Agent;
use App\Parcel;
use DB;
class AgentManageController extends Controller
{
    public function add(){
    $areas = Nearestzone::where('status',1)->get();
    return view('backEnd.agent.add',compact('areas'));
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
    	$uploadPath = 'public/uploads/agent/';
    	$file->move($uploadPath,$name);
    	$fileUrl =$uploadPath.$name;

    	$store_data					=	new Agent();
    	$store_data->name 			=	$request->name;
    	$store_data->email  		= 	$request->email;
    	$store_data->phone  		= 	$request->phone;
    	$store_data->designation 	= 	$request->designation;
    	$store_data->area 			= 	$request->area;
    	$store_data->password 		= 	bcrypt(request('password'));
    	$store_data->image 			= 	$fileUrl;
    	$store_data->status 		= 	$request->status;
    	$store_data->save();
        Toastr::success('message', 'Agent add successfully!');
    	return redirect('admin/agent/manage');
    }
   
   public function manage(){
    	$show_datas = DB::table('agents')
    	->join('nearestzones', 'agents.area', '=', 'nearestzones.id' )
    	->select('agents.*', 'nearestzones.zonename')
        ->orderBy('id','DESC')
    	->get();
    	return view('backEnd.agent.manage',compact('show_datas'));
    }

    public function edit($id){
        $edit_data = Agent::find($id);
        $areas = Nearestzone::where('status',1)->get();
    	return view('backEnd.agent.edit',compact('edit_data','areas'));
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
    	$update_data = Agent::find($request->hidden_id);
    	// image upload
    	$update_file = $request->file('image');
    	if ($update_file) {
	    	$name = time().$update_file->getClientOriginalName();
	    	$uploadPath = 'public/uploads/agent/';
	    	$update_file->move($uploadPath,$name);
	    	$fileUrl =$uploadPath.$name;
    	}else{
    		$fileUrl = $update_data->image;
    	}

    	$update_data->name 			=	$request->name;
    	$update_data->email  		= 	$request->email;
    	$update_data->phone  		= 	$request->phone;
    	$update_data->designation 	= 	$request->designation;
    	$update_data->area 			= 	$request->area;
    	$update_data->password 		= 	bcrypt(request('password'));
    	$update_data->image 		= 	$fileUrl;
    	$update_data->status 		= 	$request->status;
    	$update_data->save();
        Toastr::success('message', 'Employee update successfully!');
    	return redirect('admin/agent/manage');
    }

    public function inactive(Request $request){
        $inactive_data = Agent::find($request->hidden_id);
        $inactive_data->status=0;
        $inactive_data->save();
        Toastr::success('message', 'Employee inactive successfully!');
        return redirect('admin/agent/manage');      
    }

    public function active(Request $request){
        $inactive_data = Agent::find($request->hidden_id);
        $inactive_data->status=1;
        $inactive_data->save();
        Toastr::success('message', 'Employee active successfully!');
        return redirect('admin/agent/manage');        
    }

    public function destroy(Request $request){
        $destroy_id = Agent::find($request->hidden_id);
        $destroy_id->delete();
        Toastr::success('message', 'Employee delete successfully!');
        return redirect('admin/agent/manage');         
    }
    
   	public function hubreport(Request $request){
		$dates=$request->startDate;
		$datee=$request->endDate;
		$id=$request->agent;
		$agent=Agent::get();
// 		dd($agent);
		if ($request->agent  && $request->startDate==null && $request->endDate==null) {
// 			$id=$request->agent;
			
			$parcelr =Parcel::where('agentId',$request->agent)->where('status',4)->count();
		  $parcelc =Parcel::where('agentId',$request->agent)->where('status',9)->count();
		  $parcelre =Parcel::where('agentId',$request->agent)->where('status',8)->count();
		  $parcelpa =Parcel::where('agentId',$request->agent)->where('status',1)->count();
	  
		  $parcelpictd =Parcel::where('agentId',$request->agent)->where('status',2)->count();
		  $parcelinterjit =Parcel::where('agentId',$id)->where('status',3)->count();
		  $parcelhold =Parcel::where('agentId',$request->agent)->where('status',5)->count();
		  $parcelrrtupa =Parcel::where('agentId',$request->agent)->where('status',6)->count();
		  $parcelrrhub =Parcel::where('agentId',$request->agent)->where('status',7)->count();
	  
		  $parcelpriceCOD =Parcel::where('agentId',$request->agent)->where('status','!=',9)->sum('cod');
	   //dd($parcelprice);
		  $deliveryCharge= $parcelprice =Parcel::where('agentId',$request->agent)->sum('deliveryCharge');
	  
		  $codCharge= $parcelprice =Parcel::where('agentId',$request->agent)->sum('codCharge');
	  
		  $Collectedamount =Parcel::where('agentId',$request->agent)->sum('cod');
	  
		  $parcelcount =Parcel::where('agentId',$request->agent)->count();

			$parcels = DB::table('parcels')
            ->join('merchants', 'merchants.id','=','parcels.merchantId')
			->where('parcels.agentId',$request->agent)
            ->orderBy('parcels.id','DESC')
            ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
            ->get();

		}
		elseif($request->agent!=NULL  && $request->startDate!=NULL && $request->endDate!=NULL){ 
		    $id=$request->agent;
			
			$parcelr =Parcel::where('agentId',$request->agent)->where('status',4)->whereBetween('present_date', [$request->startDate, $request->endDate])->count();
		  $parcelc =Parcel::where('agentId',$request->agent)->where('status',9)->whereBetween('present_date', [$request->startDate, $request->endDate])->count();
		  $parcelre =Parcel::where('agentId',$request->agent)->where('status',8)->whereBetween('present_date', [$request->startDate, $request->endDate])->count();
		  $parcelpa =Parcel::where('agentId',$request->agent)->where('status',1)->whereBetween('present_date', [$request->startDate, $request->endDate])->count();
	  
		  $parcelpictd =Parcel::where('agentId',$request->agent)->where('status',2)->whereBetween('present_date', [$request->startDate, $request->endDate])->count();
		  $parcelinterjit =Parcel::where('agentId',$id)->where('status',3)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();
		  $parcelhold =Parcel::where('agentId',$request->agent)->where('status',5)->whereBetween('present_date', [$request->startDate, $request->endDate])->count();
		  $parcelrrtupa =Parcel::where('agentId',$request->agent)->where('status',6)->whereBetween('present_date', [$request->startDate, $request->endDate])->count();
		  $parcelrrhub =Parcel::where('agentId',$request->agent)->where('status',7)->whereBetween('present_date', [$request->startDate, $request->endDate])->count();
	  
		  $parcelpriceCOD =Parcel::where('agentId',$request->agent)->where('status','!=',9)->whereBetween('present_date', [$request->startDate, $request->endDate])->sum('cod');
	  // dd($parcelprice);
		  $deliveryCharge= $parcelprice =Parcel::where('agentId',$request->agent)->whereBetween('present_date', [$request->startDate, $request->endDate])->sum('deliveryCharge');
	  
		  $codCharge= $parcelprice =Parcel::where('agentId',$request->agent)->whereBetween('updated_at', [$request->startDate, $request->endDate])->sum('codCharge');
	  
		  $Collectedamount =Parcel::where('agentId',$request->agent)->where('status',4)->whereBetween('present_date', [$request->startDate, $request->endDate])->sum('cod');
	  
		  $parcelcount =Parcel::where('agentId',$request->agent)->whereBetween('updated_at', [$request->startDate, $request->endDate])->count();

			$parcels = DB::table('parcels')
            ->join('merchants', 'merchants.id','=','parcels.merchantId')
			->where('parcels.agentId',$request->agent)->whereBetween('parcels.present_date', [$request->startDate, $request->endDate])
            ->orderBy('parcels.id','DESC')
            ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
            ->get();
		}
		else{
		$parcels = DB::table('parcels')
            ->join('merchants', 'merchants.id','=','parcels.merchantId')
            ->orderBy('parcels.id','DESC')
            ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
            ->get();
		}
		
		return view('backEnd.agent.report')->with('agent',@$agent)->with('parcels',@$parcels)->with('parcelr',@$parcelr)->with('parcelcount',@$parcelcount)->with('parcelc',@$parcelc)->with('parcelpriceCOD',@$parcelpriceCOD)->with('parcelpa',@$parcelpa)->with('parcelre',@$parcelre)->with('id',@$id)->with('parcelpictd',@$parcelpictd)->with('parcelinterjit',@$parcelinterjit)->with('parcelhold',@$parcelhold)->with('parcelrrtupa',@$parcelrrtupa)->with('parcelrrhub',@$parcelrrhub)->with('deliveryCharge',@$deliveryCharge)->with('codCharge',@$codCharge)->with('Collectedamount',@$Collectedamount)->with('aid',@$id)->with('dates',@$dates)->with('datee',@$datee);
	}
		public function asingreport(Request $request){
		$dates=$request->startDate;
		$datee=$request->endDate;
		$id=$request->agent;
		$agent=Agent::get();
// 		dd($agent);
		if ($request->agent  && $request->startDate==null && $request->endDate==null) {
// 			$id=$request->agent;
			
			$parcelr =Parcel::where('agentId',$request->agent)->where('status',4)->count();
		  $parcelc =Parcel::where('agentId',$request->agent)->where('status',9)->count();
		  $parcelre =Parcel::where('agentId',$request->agent)->where('status',8)->count();
		  $parcelpa =Parcel::where('agentId',$request->agent)->where('status',1)->count();
	  
		  $parcelpictd =Parcel::where('agentId',$request->agent)->where('status',2)->count();
		  $parcelinterjit =Parcel::where('agentId',$id)->where('status',3)->count();
		  $parcelhold =Parcel::where('agentId',$request->agent)->where('status',5)->count();
		  $parcelrrtupa =Parcel::where('agentId',$request->agent)->where('status',6)->count();
		  $parcelrrhub =Parcel::where('agentId',$request->agent)->where('status',7)->count();
	  
		  $parcelpriceCOD =Parcel::where('agentId',$request->agent)->where('status','!=',9)->sum('cod');
	   //dd($parcelprice);
		  $deliveryCharge= $parcelprice =Parcel::where('agentId',$request->agent)->sum('deliveryCharge');
	  
		  $codCharge= $parcelprice =Parcel::where('agentId',$request->agent)->sum('codCharge');
	  
		  $Collectedamount =Parcel::where('agentId',$request->agent)->sum('cod');
	  
		  $parcelcount =Parcel::where('agentId',$request->agent)->count();

			$parcels = DB::table('parcels')
            ->join('merchants', 'merchants.id','=','parcels.merchantId')
			->where('parcels.agentId',$request->agent)
            ->orderBy('parcels.id','DESC')
            ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
            ->get();

		}
		elseif($request->agent!=NULL  && $request->startDate!=NULL && $request->endDate!=NULL){ 
		    $id=$request->agent;
			
			$parcelr =Parcel::where('agentId',$request->agent)->where('status',4)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
		  $parcelc =Parcel::where('agentId',$request->agent)->where('status',9)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
		  $parcelre =Parcel::where('agentId',$request->agent)->where('status',8)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
		  $parcelpa =Parcel::where('agentId',$request->agent)->where('status',1)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
	  
		  $parcelpictd =Parcel::where('agentId',$request->agent)->where('status',2)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
		  $parcelinterjit =Parcel::where('agentId',$id)->where('status',3)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
		  $parcelhold =Parcel::where('agentId',$request->agent)->where('status',5)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
		  $parcelrrtupa =Parcel::where('agentId',$request->agent)->where('status',6)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
		  $parcelrrhub =Parcel::where('agentId',$request->agent)->where('status',7)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
	  
		  $parcelpriceCOD =Parcel::where('agentId',$request->agent)->where('status','!=',9)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('cod');
	  // dd($parcelprice);
		  $deliveryCharge= $parcelprice =Parcel::where('agentId',$request->agent)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('deliveryCharge');
	  
		  $codCharge= $parcelprice =Parcel::where('agentId',$request->agent)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('codCharge');
	  
		  $Collectedamount =Parcel::where('agentId',$request->agent)->where('status',4)->whereBetween('created_at', [$request->startDate, $request->endDate])->sum('cod');
	  
		  $parcelcount =Parcel::where('agentId',$request->agent)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();

			$parcels = DB::table('parcels')
            ->join('merchants', 'merchants.id','=','parcels.merchantId')
			->where('parcels.agentId',$request->agent)->whereBetween('parcels.created_at', [$request->startDate, $request->endDate])
            ->orderBy('parcels.id','DESC')
            ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
            ->get();
		}
		else{
		$parcels = DB::table('parcels')
            ->join('merchants', 'merchants.id','=','parcels.merchantId')
            ->orderBy('parcels.id','DESC')
            ->select('parcels.*','merchants.firstName','merchants.lastName','merchants.phoneNumber','merchants.emailAddress','merchants.companyName','merchants.status as mstatus','merchants.id as mid')
            ->get();
		}
		
		return view('backEnd.agent.asingreport')->with('agent',@$agent)->with('parcels',@$parcels)->with('parcelr',@$parcelr)->with('parcelcount',@$parcelcount)->with('parcelc',@$parcelc)->with('parcelpriceCOD',@$parcelpriceCOD)->with('parcelpa',@$parcelpa)->with('parcelre',@$parcelre)->with('id',@$id)->with('parcelpictd',@$parcelpictd)->with('parcelinterjit',@$parcelinterjit)->with('parcelhold',@$parcelhold)->with('parcelrrtupa',@$parcelrrtupa)->with('parcelrrhub',@$parcelrrhub)->with('deliveryCharge',@$deliveryCharge)->with('codCharge',@$codCharge)->with('Collectedamount',@$Collectedamount)->with('aid',@$id)->with('dates',@$dates)->with('datee',@$datee);
	}
}
