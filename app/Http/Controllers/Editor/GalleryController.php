<?php

namespace App\Http\Controllers\Editor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Gallery;
use File;
class GalleryController extends Controller
{
    public function create(){
        return view('backEnd.gallery.create');
    }
    public function store(Request $request){
        $this->validate($request,[
            'title'=>'required',
            'image'=>'required',
            'status'=>'required',
        ]);

        // image upload
        $file = $request->file('image');
        $name = $file->getClientOriginalName();
        $uploadPath = 'public/uploads/gallery/';
        $file->move($uploadPath,$name);
        $fileUrl =$uploadPath.$name;

        $store_data = new Gallery();
        $store_data->image = $fileUrl;
        $store_data->title = $request->title;
        $store_data->status = $request->status;
        $store_data->save();
        Toastr::success('message', 'Banner add successfully!');
        return redirect('editor/gallery/manage');
    }
    public function manage(){
        $show_data = Gallery::get();
        return view('backEnd.gallery.manage',compact('show_data'));
    }
    public function edit($id){
        $edit_data = Gallery::find($id);
        return view('backEnd.gallery.edit',compact('edit_data'));
    }
     public function update(Request $request){
        $this->validate($request,[
            'status'=>'required',
        ]);
        $update_data = Gallery::find($request->hidden_id);
        $update_image = $request->file('image');
        if ($update_image) {
           $file = $request->file('image');
            $name = $file->getClientOriginalName();
            $uploadPath = 'public/uploads/gallery/';
            File::delete(public_path() . 'public/uploads/gallery', $update_data->image);
            $file->move($uploadPath,$name);
            $fileUrl =$uploadPath.$name;
        }else{
            $fileUrl = $update_data->image;
        }

        $update_data->image = $fileUrl;
        $update_data->title = $request->title;
        $update_data->status = $request->status;
        $update_data->save();
        Toastr::success('message', 'Banner  update successfully!');
        return redirect('editor/gallery/manage');
    }

    public function inactive(Request $request){
        $unpublish_data = Gallery::find($request->hidden_id);
        $unpublish_data->status=0;
        $unpublish_data->save();
        Toastr::success('message', 'Banner  uppublished successfully!');
        return redirect('editor/gallery/manage');
    }

    public function active(Request $request){
        $publishId = Gallery::find($request->hidden_id);
        $publishId->status=1;
        $publishId->save();
        Toastr::success('message', 'Banner  uppublished successfully!');
        return redirect('editor/gallery/manage');
    }
     public function destroy(Request $request){
        $delete_data = Gallery::find($request->hidden_id);
        File::delete(public_path() . 'public/uploads/gallery', $delete_data->image);  
        $delete_data->delete();
        Toastr::success('message', 'Banner delete successfully!');
        return redirect('editor/gallery/manage');
    }
}
