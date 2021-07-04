<?php

namespace App\Http\Controllers\Editor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Notice;
class NoticeController extends Controller
{
    
    public function create(){
    	return view('backEnd.notice.create');
    }
    public function store(Request $request){
    	$this->validate($request,[
    		'title'=>'required',
    		'text'=>'required',
    		'status'=>'required',
    	]);
    	$store_data = new Notice();
    	$store_data->title = $request->title;
    	$store_data->slug =   strtolower(str_replace(array(" ","/",), "-", $request->title));
    	$store_data->text = $request->text;
    	$store_data->status = $request->status;
    	$store_data->save();
        Toastr::success('message', 'Notice add successfully!');
    	return redirect('editor/notice/manage');
    }
    public function manage(){
    	$show_data = Notice::get();
        return view('backEnd.notice.manage',compact('show_data'));
    }
    public function edit($id){
        $edit_data = Notice::find($id);
        return view('backEnd.notice.edit',compact('edit_data'));
    }
     public function update(Request $request){
        $this->validate($request,[
            'status'=>'required',
        ]);

        $update_data = Notice::find($request->hidden_id);
        $update_data->title = $request->title;
        $update_data->slug =   strtolower(str_replace(array(" ","/",), "-", $request->title)) ;
        $update_data->text = $request->text;
        $update_data->status = $request->status;
        $update_data->save();
        Toastr::success('message', 'Notice  update successfully!');
        return redirect('editor/notice/manage');
    }

    public function inactive(Request $request){
        $unpublish_data = Notice::find($request->hidden_id);
        $unpublish_data->status=0;
        $unpublish_data->save();
        Toastr::success('message', 'Notice  uppublished successfully!');
        return redirect('editor/notice/manage');
    }
    public function active(Request $request){
        $publishId = Notice::find($request->hidden_id);
        $publishId->status=1;
        $publishId->save();
        Toastr::success('message', 'Notice  uppublished successfully!');
        return redirect('editor/notice/manage');
    }
     public function destroy(Request $request){
        $delete_data = Notice::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('message', 'Notice delete successfully!');
        return redirect('editor/notice/manage');
    }
}
