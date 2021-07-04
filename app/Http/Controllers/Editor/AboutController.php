<?php

namespace App\Http\Controllers\editor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\About;
use File;

class AboutController extends Controller
{
    public function create(){
    	return view('backEnd.about.create');
    }
    public function store(Request $request){
    	$this->validate($request,[
    		'image'=>'required',
    		'title'=>'required',
    		'subtitle'=>'required',
    		'text'=>'required',
    		'status'=>'required',
    	]);

    	// image upload
    	$file = $request->file('image');
    	$name = $file->getClientOriginalName();
    	$uploadPath = 'public/uploads/about/';
    	$file->move($uploadPath,$name);
    	$fileUrl =$uploadPath.$name;

    	$store_data = new About();
    	$store_data->title = $request->title;
    	$store_data->subtitle = $request->subtitle;
    	$store_data->text = $request->text;
    	$store_data->image = $fileUrl;
    	$store_data->status = $request->status;
    	$store_data->save();
        Toastr::success('message', 'About add successfully!');
    	return redirect('editor/about/manage');
    }
    public function manage(){
    	$show_data = About::get();
        return view('backEnd.about.manage',compact('show_data'));
    }
    public function edit($id){
        $edit_data = About::find($id);
        return view('backEnd.about.edit',compact('edit_data'));
    }
     public function update(Request $request){
        $this->validate($request,[
            'status'=>'required',
        ]);

        $update_data = About::find($request->hidden_id);
        $update_image = $request->file('image');
        if ($update_image) {
           $file = $request->file('image');
            $name = $file->getClientOriginalName();
            $uploadPath = 'public/uploads/about/';
            File::delete(public_path() . 'public/uploads/about', $update_data->image);
            $file->move($uploadPath,$name);
            $fileUrl =$uploadPath.$name;
        }else{
            $fileUrl = $update_data->image;
        }

        $update_data->image = $fileUrl;
        $update_data->title = $request->title;
        $update_data->subtitle = $request->subtitle;
        $update_data->text = $request->text;
        $update_data->status = $request->status;
        $update_data->save();
        Toastr::success('message', 'About  update successfully!');
        return redirect('editor/about/manage');
    }

    public function inactive(Request $request){
        $unpublish_data = About::find($request->hidden_id);
        $unpublish_data->status=0;
        $unpublish_data->save();
        Toastr::success('message', 'About  uppublished successfully!');
        return redirect('editor/about/manage');
    }

    public function active(Request $request){
        $publishId = About::find($request->hidden_id);
        $publishId->status=1;
        $publishId->save();
        Toastr::success('message', 'About  uppublished successfully!');
        return redirect('editor/about/manage');
    }
     public function destroy(Request $request){
        $delete_data = About::find($request->hidden_id);
        File::delete(public_path() . 'public/uploads/about', $delete_data->image);  
        $delete_data->delete();
        Toastr::success('message', 'About delete successfully!');
        return redirect('editor/about/manage');
    }
}
