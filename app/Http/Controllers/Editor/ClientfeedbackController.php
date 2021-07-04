<?php

namespace App\Http\Controllers\editor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Clientfeedback;

class ClientfeedbackController extends Controller
{
    public function create(){
    	return view('backEnd.clientfeedback.create');
    }
    public function store(Request $request){
    	$this->validate($request,[
    		'name'=>'required',
            'subtitle'=>'required',
    		'description'=>'required',
    		'status'=>'required',
    	]);
    	// image upload
        $file = $request->file('image');
        $name = time().'-'.$file->getClientOriginalName();
        $uploadPath = 'public/uploads/clientfeedback/';
        $file->move($uploadPath,$name);
        $fileUrl =$uploadPath.$name;
        
    	$store_data = new Clientfeedback();
        $store_data->name =  $request->name;
        $store_data->subtitle =  $request->subtitle;
        $store_data->description =  $request->description;
         $store_data->image     = $fileUrl;
    	$store_data->status  = $request->status;
    	$store_data->save();
        Toastr::success('message', 'Client feedback add successfully!');
    	return redirect('/editor/clientfeedback/manage');
    }
    public function manage(){
       $show_data =Clientfeedback::all();
        return view('backEnd.clientfeedback.manage', compact('show_data'));
    }

    public function edit($id){
        $edit_data =Clientfeedback::find($id);
        return view('backEnd.clientfeedback.edit', ['edit_data'=>$edit_data]);
    }

    public function update(Request $request){
        $this->validate($request,[
    		'name'=>'required',
            'subtitle'=>'required',
    		'description'=>'required',
    		'status'=>'required',
        ]);

        $update_data = Clientfeedback::find($request->hidden_id);
        $update_image = $request->file('image');
        if ($update_image) {
           $file = $request->file('image');
            
            $name = time().'-'.$file->getClientOriginalName();
            $uploadPath = 'public/uploads/clientfeedback/';
            $file->move($uploadPath,$name);
            $fileUrl =$uploadPath.$name;
        }else{
            $fileUrl = $update_data->image;
        }
        $update_data->name =  $request->name;
        $update_data->subtitle =  $request->subtitle;
        $update_data->image = $fileUrl;
        $update_data->description =  $request->description;
    	$update_data->status  = $request->status;
        $update_data->save();
        Toastr::success('message', 'Client feedback update successfully!');
        return redirect('/editor/clientfeedback/manage');
    }

    public function destroy(Request $request){
        $deleteId = Clientfeedback::find($request->hidden_id);
        $deleteId->delete();
        Toastr::success('message', 'Client feedback delete successfully!');
        return redirect('/editor/clientfeedback/manage');
    }

    public function inactive(Request $request){
        $unpublish_data =Clientfeedback::find($request->hidden_id);
        $unpublish_data->status=0;
        $unpublish_data->save();
        Toastr::success('message', 'Client feedback uppublished successfully!');
        return redirect('/editor/clientfeedback/manage');
    }

    public function active(Request $request){
        $publishId =Clientfeedback::find($request->hidden_id);
        $publishId->status=1;
        $publishId->save();
        Toastr::success('message', 'Client feedback uppublished successfully!');
        return redirect('/editor/clientfeedback/manage');
    }
}
