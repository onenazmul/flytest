<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Department;
use App\Employee;
use DB;
class EmployeeController extends Controller
{
   public function add(){
    $department = Department::where('status',1)->get();
    return view('backEnd.employee.add',compact('department'));
   }
    public function save(Request $request){
        
    	$this->validate($request,[
    		'name'=>'required',
    		'email'=>'required',
    		'phone'=>'required',
    		'designation'=>'required',
    		'department'=>'required',
    		'image'=>'required',
            'status'=>'required',
    	]);

    	// image upload
    	$file = $request->file('image');
    	$name = time().$file->getClientOriginalName();
    	$uploadPath = 'public/uploads/employee/';
    	$file->move($uploadPath,$name);
    	$fileUrl =$uploadPath.$name;

    	$store_data					=	new Employee();
    	$store_data->name 			=	$request->name;
    	$store_data->email  		= 	$request->email;
    	$store_data->phone  		= 	$request->phone;
    	$store_data->designation 	= 	$request->designation;
    	$store_data->department 	= 	$request->department;
    	$store_data->image 			= 	$fileUrl;
    	$store_data->status 		= 	$request->status;
    	$store_data->save();
        Toastr::success('message', 'Employee add successfully!');
    	return redirect('admin/employee/manage');
    }
   
   public function manage(){
    	$show_datas = DB::table('employees')
    	->join('departments', 'employees.department', '=', 'departments.id' )
    	->select('employees.*', 'departments.name as dname')
        ->orderBy('id','DESC')
    	->get();
    	return view('backEnd.employee.manage',compact('show_datas'));
    }

    public function edit($id){
        $edit_data = Employee::find($id);
        $department = Department::where('status',1)->get();
    	return view('backEnd.employee.edit',compact('edit_data','department'));
    }

    public function update(Request $request){
    	$this->validate($request,[
    		'name'=>'required',
    		'email'=>'required',
    		'phone'=>'required',
    		'designation'=>'required',
    		'department'=>'required',
    		'status'=>'required',
    	]);
    	$update_data = Employee::find($request->hidden_id);
    	// image upload
    	$update_file = $request->file('image');
    	if ($update_file) {
	    	$name = time().$update_file->getClientOriginalName();
	    	$uploadPath = 'public/uploads/employee/';
	    	$update_file->move($uploadPath,$name);
	    	$fileUrl =$uploadPath.$name;
    	}else{
    		$fileUrl = $update_data->image;
    	}

    	$update_data->name 			=	$request->name;
    	$update_data->email  		= 	$request->email;
    	$update_data->phone  		= 	$request->phone;
    	$update_data->designation 	= 	$request->designation;
    	$update_data->department 	= 	$request->department;
    	$update_data->image 		= 	$fileUrl;
    	$update_data->status 		= 	$request->status;
    	$update_data->save();
        Toastr::success('message', 'Employee update successfully!');
    	return redirect('admin/employee/manage');
    }

    public function inactive(Request $request){
        $inactive_data = Employee::find($request->hidden_id);
        $inactive_data->status=0;
        $inactive_data->save();
        Toastr::success('message', 'Employee inactive successfully!');
        return redirect('admin/employee/manage');      
    }

    public function active(Request $request){
        $inactive_data = Employee::find($request->hidden_id);
        $inactive_data->status=1;
        $inactive_data->save();
        Toastr::success('message', 'Employee active successfully!');
        return redirect('admin/employee/manage');        
    }

    public function destroy(Request $request){
        $destroy_id = Employee::find($request->hidden_id);
        $destroy_id->delete();
        Toastr::success('message', 'Employee delete successfully!');
        return redirect('admin/employee/manage');         
    }
}
