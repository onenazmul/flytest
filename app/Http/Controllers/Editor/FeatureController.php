<?php

namespace App\Http\Controllers\editor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Feature;
use File;
class FeatureController extends Controller
{
    public function create(){
    	return view('backEnd.feature.create');
    }
    public function store(Request $request){
    	$this->validate($request,[
    		'title'=>'required',
    		'icon'=>'required',
    		'status'=>'required',
    	]);

    	$store_data = new Feature();
    	$store_data->title = $request->title;
        $store_data->icon = $request->icon;
    	$store_data->status = $request->status;
    	$store_data->save();
        Toastr::success('message', 'Featureadd successfully!');
    	return redirect('editor/feature/manage');
    }
    public function manage(){
    	$show_data = Feature::get();
        return view('backEnd.feature.manage',compact('show_data'));
    }
    public function edit($id){
        $edit_data = Feature::find($id);
        return view('backEnd.feature.edit',compact('edit_data'));
    }
     public function update(Request $request){
        $this->validate($request,[
            'title'=>'required',
            'status'=>'required',
        ]);
        $update_data = Feature::find($request->hidden_id);
        
        $update_data->title = $request->title;
        $update_data->icon = $request->icon;
        $update_data->status = $request->status;
        $update_data->save();
        Toastr::success('message', 'Feature update successfully!');
        return redirect('editor/feature/manage');
    }

    public function inactive(Request $request){
        $unpublish_data = Feature::find($request->hidden_id);
        $unpublish_data->status=0;
        $unpublish_data->save();
        Toastr::success('message', 'Feature uppublished successfully!');
        return redirect('editor/feature/manage');
    }

    public function active(Request $request){
        $publishId = Feature::find($request->hidden_id);
        $publishId->status=1;
        $publishId->save();
        Toastr::success('message', 'Feature uppublished successfully!');
        return redirect('editor/feature/manage');
    }
     public function destroy(Request $request){
        $delete_data = Feature::find($request->hidden_id);
        File::delete(public_path() . 'public/uploads/feature', $delete_data->image);  
        $delete_data->delete();
        Toastr::success('message', 'Featuredelete successfully!');
        return redirect('editor/feature/manage');
    }
}
