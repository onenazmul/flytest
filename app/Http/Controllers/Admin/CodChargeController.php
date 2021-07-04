<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Codcharge;
use File;

class CodChargeController extends Controller
{
        public function add(){
    	return view('backEnd.codcharge.add');

    }
    public function store(Request $request){
    	$this->validate($request,[
            'codcharge'=>'required',
    		'status'=>'required',
    	]);
        
    	$store_data                    = new Codcharge();
    	$store_data->codcharge   	   = $request->codcharge;
    	$store_data->status            = $request->status;
    	$store_data->save();
    	Toastr::success('message', 'Cod charge add successfully!');
    	return redirect('/admin/codcharge/manage');
    }
     public function manage(){
        $show_data = Codcharge::
             orderBy('id','DESC')
            ->get();
    	return view('backEnd.codcharge.manage',compact('show_data'));
    }
     public function edit($id){
        $edit_data = Codcharge::find($id);
        return view('backEnd.codcharge.edit',compact('edit_data'));
    }
      public function update(Request $request){
      	$update_data = Codcharge::find($request->hidden_id);

        $update_data->codcharge   	    = $request->codcharge;
    	$update_data->status            = $request->status;
    	$update_data->save();
        Toastr::success('message', 'Cod charge Update successfully!');
        return redirect('admin/codcharge/manage');
    }

    public function inactive(Request $request){
        $unpublish_data = Codcharge::find($request->hidden_id);
        $unpublish_data->status=0;
        $unpublish_data->save();
        Toastr::success('message', 'Cod charge active successfully!');
        return redirect('/admin/codcharge/manage');
    }

    public function active(Request $request){
        $publishId = Codcharge::find($request->hidden_id);
        $publishId->status=1;
        $publishId->save();
        Toastr::success('message', 'Cod charge active successfully!');
        return redirect('/admin/codcharge/manage');
    }

     public function destroy(Request $request){
        $destroy_id = Codcharge::find($request->hidden_id);
        $destroy_id->delete();
        Toastr::success('message', 'Cod charge  delete successfully!');
        return redirect('/admin/codcharge/manage');         
    }
}
