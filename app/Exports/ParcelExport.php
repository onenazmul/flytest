<?php
namespace App\Exports;
use App\Parcel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Session;
class ParcelExport implements FromCollection

{

    /**

    * @return \Illuminate\Support\Collection

    */

    public function collection()

    {
        
        $startDate = request()->input('startDate');
        $endDate   = request()->input('endDate') ;
        $status   = request()->input('status') ;
        return Parcel::where('merchantId',Session::get('merchantId'))->where('status',$status)->orWhereBetween('created_at', [ $startDate, $endDate ] )->select('recipientName','percelType','recipientPhone','cod','recipientAddress','reciveZone','productWeight')->get();

    }
    public function map($parcel) : array {

        return [

            $parcel->recipientName,
            $parcel->user->recipientPhone,
            $parcel->user->recipientAddress,

        ] ;

 

 

    }

}