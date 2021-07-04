<?php

namespace App\Http\Controllers\editor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Faq;
use File;

class FaqController extends Controller
{
    public function create(){
    	return view('backEnd.faq.create');
    }
    public function store(Request $request){
    	$this->validate($request,[
    		'title'=>'required',
    		'subtitle'=>'required',
    		'text'=>'required',
    		'status'=>'required',
    	]);


    	$store_data = new Faq();
    	$store_data->title = $request->title;
    	$store_data->subtitle = $request->subtitle;
    	$store_data->text = $request->text;
    	$store_data->status = $request->status;
    	$store_data->save();
        Toastr::success('message', 'Faq add successfully!');
    	return redirect('editor/faq/manage');
    }
    public function manage(){
    	$show_data = Faq::get();
        return view('backEnd.faq.manage',compact('show_data'));
    }
    public function edit($id){
        $edit_data = Faq::find($id);
        return view('backEnd.faq.edit',compact('edit_data'));
    }
     public function update(Request $request){
        $this->validate($request,[
            'status'=>'required',
        ]);

        $update_data = Faq::find($request->hidden_id);
        $update_data->title = $request->title;
        $update_data->subtitle = $request->subtitle;
        $update_data->text = $request->text;
        $update_data->status = $request->status;
        $update_data->save();
        Toastr::success('message', 'Faq  update successfully!');
        return redirect('editor/faq/manage');
    }

    public function inactive(Request $request){
        $unpublish_data = Faq::find($request->hidden_id);
        $unpublish_data->status=0;
        $unpublish_data->save();
        Toastr::success('message', 'Faq  uppublished successfully!');
        return redirect('editor/faq/manage');
    }

    public function active(Request $request){
        $publishId = Faq::find($request->hidden_id);
        $publishId->status=1;
        $publishId->save();
        Toastr::success('message', 'Faq  uppublished successfully!');
        return redirect('editor/faq/manage');
    }
     public function destroy(Request $request){
        $delete_data = Faq::find($request->hidden_id); 
        $delete_data->delete();
        Toastr::success('message', 'Faq delete successfully!');
        return redirect('editor/faq/manage');
    }
}
