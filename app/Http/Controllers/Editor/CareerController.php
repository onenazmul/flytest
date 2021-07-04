<?php

namespace App\Http\Controllers\Editor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Career;
class CareerController extends Controller
{
    public function create(){
    	return view('backEnd.career.create');
    }
    public function store(Request $request){
    	$this->validate($request,[
    		'title'=>'required',
    		'exprience'=>'required',
    		'text'=>'required',
    		'status'=>'required',
    	]);
    	$store_data = new Career();
    	$store_data->title = $request->title;
    	$store_data->slug =   strtolower(str_replace(array(" ","/",), "-", $request->title));
    	$store_data->exprience = $request->exprience;
    	$store_data->text = $request->text;
    	$store_data->status = $request->status;
    	$store_data->save();
        Toastr::success('message', 'Career add successfully!');
    	return redirect('editor/career/manage');
    }
    public function manage(){
    	$show_data = Career::get();
        return view('backEnd.career.manage',compact('show_data'));
    }
    public function edit($id){
        $edit_data = Career::find($id);
        return view('backEnd.career.edit',compact('edit_data'));
    }
     public function update(Request $request){
        $this->validate($request,[
            'status'=>'required',
        ]);

        $update_data = Career::find($request->hidden_id);

        $update_data->title = $request->title;
        $update_data->slug =   strtolower(str_replace(array(" ","/",), "-", $request->title)) ;
        $update_data->exprience = $request->exprience;
        $update_data->text = $request->text;
        $update_data->status = $request->status;
        $update_data->save();
        Toastr::success('message', 'Career  update successfully!');
        return redirect('editor/career/manage');
    }

    public function inactive(Request $request){
        $unpublish_data = Career::find($request->hidden_id);
        $unpublish_data->status=0;
        $unpublish_data->save();
        Toastr::success('message', 'Career  uppublished successfully!');
        return redirect('editor/career/manage');
    }

    public function active(Request $request){
        $publishId = Career::find($request->hidden_id);
        $publishId->status=1;
        $publishId->save();
        Toastr::success('message', 'Career  uppublished successfully!');
        return redirect('editor/career/manage');
    }
     public function destroy(Request $request){
        $delete_data = Career::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('message', 'Career delete successfully!');
        return redirect('editor/career/manage');
    }
}
