<?php

namespace App\Http\Controllers\editor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Partner;
use File;
class PartnerController extends Controller
{
     
    public function create(){
        return view('backEnd.partner.create');
    }
    public function store(Request $request){
        $this->validate($request,[
            'image'=>'required',
            'status'=>'required',
        ]);

        // image upload
        $file = $request->file('image');
        $name = $file->getClientOriginalName();
        $uploadPath = 'public/uploads/partner/';
        $file->move($uploadPath,$name);
        $fileUrl =$uploadPath.$name;

        $store_data = new Partner();
        $store_data->image = $fileUrl;
        $store_data->status = $request->status;
        $store_data->save();
        Toastr::success('message', 'Partner add successfully!');
        return redirect('/editor/partner/manage');
    }
    public function manage(){
        $show_data = Partner::get();
        return view('backEnd.partner.manage',compact('show_data'));
    }
    public function edit($id){
        $edit_data = Partner::find($id);
        return view('backEnd.partner.edit',compact('edit_data'));
    }
     public function update(Request $request){
        $this->validate($request,[
            'status'=>'required',
        ]);

        $update_data = Partner::find($request->hidden_id);
        $update_image = $request->file('image');
        if ($update_image) {
           $file = $request->file('image');
            $name = $file->getClientOriginalName();
            $uploadPath = 'public/uploads/partner/';
            File::delete(public_path() . 'public/uploads/partner', $update_data->image);
            $file->move($uploadPath,$name);
            $fileUrl =$uploadPath.$name;
        }else{
            $fileUrl = $update_data->image;
        }

        $update_data->image = $fileUrl;
        $update_data->status = $request->status;
        $update_data->save();
        Toastr::success('message', 'Partner  update successfully!');
        return redirect('/editor/partner/manage');
    }

    public function inactive(Request $request){
        $unpublish_data = Partner::find($request->hidden_id);
        $unpublish_data->status=0;
        $unpublish_data->save();
        Toastr::success('message', 'Partner  uppublished successfully!');
        return redirect('/editor/partner/manage');
    }

    public function active(Request $request){
        $publishId = Partner::find($request->hidden_id);
        $publishId->status=1;
        $publishId->save();
        Toastr::success('message', 'Partner  uppublished successfully!');
        return redirect('/editor/partner/manage');
    }
     public function destroy(Request $request){
        $delete_data = Partner::find($request->hidden_id);
        File::delete(public_path() . 'public/uploads/partner', $delete_data->image);  
        $delete_data->delete();
        Toastr::success('message', 'Partner delete successfully!');
        return redirect('/editor/partner/manage');
    }
}
