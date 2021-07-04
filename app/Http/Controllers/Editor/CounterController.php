<?php

namespace App\Http\Controllers\editor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Counter;
use File;

class CounterController extends Controller
{
    public function create(){
    	return view('backEnd.counter.create');
    }
    public function store(Request $request){
    	$this->validate($request,[
    		'title'=>'required',
    		'quantity'=>'required',
    		'status'=>'required',
    	]);

    	

    	$store_data = new Counter();
    	$store_data->title = $request->title;
    	$store_data->quantity = $request->quantity;
    	$store_data->status = $request->status;
    	$store_data->save();
        Toastr::success('message', 'Counter add successfully!');
    	return redirect('editor/counter/manage');
    }
    public function manage(){
    	$show_data = Counter::get();
        return view('backEnd.counter.manage',compact('show_data'));
    }
    public function edit($id){
        $edit_data = Counter::find($id);
        return view('backEnd.counter.edit',compact('edit_data'));
    }
     public function update(Request $request){
        $this->validate($request,[
            'status'=>'required',
        ]);

        $update_data = Counter::find($request->hidden_id);
       
        $update_data->title = $request->title;
        $update_data->quantity = $request->quantity;
        $update_data->status = $request->status;
        $update_data->save();
        Toastr::success('message', 'Counter  update successfully!');
        return redirect('editor/counter/manage');
    }

    public function inactive(Request $request){
        $unpublish_data = Counter::find($request->hidden_id);
        $unpublish_data->status=0;
        $unpublish_data->save();
        Toastr::success('message', 'Counter  uppublished successfully!');
        return redirect('editor/counter/manage');
    }

    public function active(Request $request){
        $publishId = Counter::find($request->hidden_id);
        $publishId->status=1;
        $publishId->save();
        Toastr::success('message', 'Counter  uppublished successfully!');
        return redirect('editor/counter/manage');
    }
     public function destroy(Request $request){
        $delete_data = Counter::find($request->hidden_id);
        File::delete(public_path() . 'public/uploads/counter', $delete_data->image);  
        $delete_data->delete();
        Toastr::success('message', 'Counter delete successfully!');
        return redirect('editor/counter/manage');
    }
}
