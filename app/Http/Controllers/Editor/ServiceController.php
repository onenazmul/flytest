<?php

namespace App\Http\Controllers\editor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Service;
use File;
class ServiceController extends Controller
{

    public function create(){
    	return view('backEnd.service.create');
    }
    public function store(Request $request){
    	$this->validate($request,[
    		'icon'=>'required',
            'image'=>'required',
    		'title'=>'required',
    		'status'=>'required',
    	]);

    	// image upload
    	$file = $request->file('image');
    	$name = $file->getClientOriginalName();
    	$uploadPath = 'public/uploads/service/';
    	$file->move($uploadPath,$name);
    	$fileUrl =$uploadPath.$name;

    	$store_data = new Service();
    	$store_data->icon = $request->icon;
        $store_data->title = $request->title;
    	$store_data->text = $request->text;
    	$store_data->image = $fileUrl;
    	$store_data->status = $request->status;
    	$store_data->save();
        Toastr::success('message', 'Service add successfully!');
    	return redirect('editor/service/manage');
    }
    public function manage(){
    	$show_data = Service::get();
        return view('backEnd.service.manage',compact('show_data'));
    }
    public function edit($id){
        $edit_data = Service::find($id);
        return view('backEnd.service.edit',compact('edit_data'));
    }
     public function update(Request $request){
        $this->validate($request,[
            'status'=>'required',
        ]);

        $update_data = Service::find($request->hidden_id);
        $update_image = $request->file('image');
        if ($update_image) {
           $file = $request->file('image');
            $name = $file->getClientOriginalName();
            $uploadPath = 'public/uploads/service/';
            File::delete(public_path() . 'public/uploads/service', $update_data->image);
            $file->move($uploadPath,$name);
            $fileUrl =$uploadPath.$name;
        }else{
            $fileUrl = $update_data->image;
        }

        $update_data->icon = $request->icon;
        $update_data->image = $fileUrl;
        $update_data->title = $request->title;
        $update_data->text = $request->text;
        $update_data->status = $request->status;
        $update_data->save();
        Toastr::success('message', 'Service  update successfully!');
        return redirect('editor/service/manage');
    }

    public function inactive(Request $request){
        $unpublish_data = Service::find($request->hidden_id);
        $unpublish_data->status=0;
        $unpublish_data->save();
        Toastr::success('message', 'Service  uppublished successfully!');
        return redirect('editor/service/manage');
    }

    public function active(Request $request){
        $publishId = Service::find($request->hidden_id);
        $publishId->status=1;
        $publishId->save();
        Toastr::success('message', 'Service  uppublished successfully!');
        return redirect('editor/service/manage');
    }
     public function destroy(Request $request){
        $delete_data = Service::find($request->hidden_id);
        File::delete(public_path() . 'public/uploads/service', $delete_data->image);  
        $delete_data->delete();
        Toastr::success('message', 'Service delete successfully!');
        return redirect('editor/service/manage');
    }
}
