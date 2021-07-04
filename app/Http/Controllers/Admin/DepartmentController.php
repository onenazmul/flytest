<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Department;
use File;

class DepartmentController extends Controller
{
    
    public function add(){
    	return view('backEnd.department.add');

    }
    public function store(Request $request){
    	$this->validate($request,[
            'name'=>'required',
    		'status'=>'required',
    	]);


    	$store_data                = new Department();
    	$store_data->name   	   = $request->name;
    	$store_data->status        = $request->status;
    	$store_data->save();
    	Toastr::success('message', 'Department add successfully!');
    	return redirect('/admin/department/manage');
    }
     public function manage(){
        $show_data = Department::
             orderBy('id','DESC')
            ->get();
    	return view('backEnd.department.manage',compact('show_data'));
    }
     public function edit($id){
        $edit_data = Department::find($id);
        return view('backEnd.department.edit',compact('edit_data'));
    }
      public function update(Request $request){
      	$update_data = Department::find($request->hidden_id);

        $update_data->name   	    = $request->name;
    	$update_data->status            = $request->status;
    	$update_data->save();
        Toastr::success('message', 'Department Update successfully!');
        return redirect('admin/department/manage');
    }

    public function inactive(Request $request){
        $unpublish_data = Department::find($request->hidden_id);
        $unpublish_data->status=0;
        $unpublish_data->save();
        Toastr::success('message', 'Department active successfully!');
        return redirect('/admin/department/manage');
    }

    public function active(Request $request){
        $publishId = Department::find($request->hidden_id);
        $publishId->status=1;
        $publishId->save();
        Toastr::success('message', 'Department active successfully!');
        return redirect('/admin/department/manage');
    }

     public function destroy(Request $request){
        $destroy_id = Department::find($request->hidden_id);
        $destroy_id->delete();
        Toastr::success('message', 'Department  delete successfully!');
        return redirect('/admin/department/manage');         
    }

}
