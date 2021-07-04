<?php

namespace App\Http\Controllers\editor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Price;
use File;
class PriceController extends Controller
{
    
    public function create(){
        return view('backEnd.price.create');
    }
    public function store(Request $request){
        $this->validate($request,[
            'icon'=>'required',
            'price'=>'required',
            'name'=>'required',
            'text'=>'required',
            'status'=>'required',
        ]);

        $store_data = new Price();
        $store_data->icon = $request->icon;
        $store_data->name = $request->name;
        $store_data->text = $request->text;
        $store_data->price = $request->price;
        $store_data->status = $request->status;
        $store_data->save();
        Toastr::success('message', 'Price add successfully!');
        return redirect('editor/price/manage');
    }
    public function manage(){
        $show_data = Price::get();
        return view('backEnd.price.manage',compact('show_data'));
    }
    public function edit($id){
        $edit_data = Price::find($id);
        return view('backEnd.price.edit',compact('edit_data'));
    }
     public function update(Request $request){
        $this->validate($request,[
            'status'=>'required',
        ]);

        $update_data = Price::find($request->hidden_id);
        $update_data->icon = $request->icon;
        $update_data->price = $request->price;
        $update_data->name = $request->name;
        $update_data->text = $request->text;
        $update_data->status = $request->status;
        $update_data->save();
        Toastr::success('message', 'Price update successfully!');
        return redirect('editor/price/manage');
    }

    public function inactive(Request $request){
        $unpublish_data = Price::find($request->hidden_id);
        $unpublish_data->status=0;
        $unpublish_data->save();
        Toastr::success('message', 'Price uppublished successfully!');
        return redirect('editor/price/manage');
    }

    public function active(Request $request){
        $publishId = Price::find($request->hidden_id);
        $publishId->status=1;
        $publishId->save();
        Toastr::success('message', 'Price uppublished successfully!');
        return redirect('editor/price/manage');
    }
     public function destroy(Request $request){
        $delete_data = Price::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('message', 'Price delete successfully!');
        return redirect('editor/price/manage');
    }
}
