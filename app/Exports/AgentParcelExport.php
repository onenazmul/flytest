<?php
namespace App\Exports;
use App\Parcel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Session;
class AgentParcelExport implements FromCollection

{

    /**

    * @return \Illuminate\Support\Collection

    */

    public function collection()

    {
        
        $startDate = request()->input('startDate');
        $endDate   = request()->input('endDate') ;
        $status   = request()->input('status') ;
        return Parcel::where('agentId',Session::get('agentId'))->where('status',$status)->orWhereBetween('created_at', [ $startDate, $endDate ] )->select('recipientName','percelType','recipientPhone','cod','recipientAddress','reciveZone','productWeight')->get();

    }

}