<?php

namespace App\Http\Controllers\search;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use DB;

class liveSearchController extends Controller
{
   public function SearchWithoutData()
	 {
	  
	 }

    
    public function SearchData($keyword)
    {
	     $data['show_datas'] = Product::where('name','LIKE','%'.$keyword."%")->get();
	
		    $data = view('backEnd.livesearch.search', $data)->render();
		    if ($data != '') 
		    {
		    	echo $data;
		    }
     }
}
