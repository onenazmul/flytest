<?php
namespace App\Imports;
use App\Codcharge;
use App\Parcel;
use App\Deliverycharge;
use Maatwebsite\Excel\Concerns\ToModel;
use Session;
use Auth;
class AdminParcelimport implements ToModel
{
  public function model(array $row)
    {
    dd(Auth::user()->name);
    exit;
      if (!isset($row[0]) || !isset($row[1]) || !isset($row[2]) || !isset($row[3]) || !isset($row[4]) || !isset($row[5]) || !isset($row[6]) || !isset($row[7]) || !isset($row[8])) {
            return NULL;
        }
        $intialdcharge = Deliverycharge::find($row[8]);
        $initialcodcharge = Codcharge::where('status',1)->orderBy('id','DESC')->first();
       
      // fixed delivery charge
     if($row[6]>1 || $row[6]!=NULL){
        $extraweight = $row[6]-1;
        $deliverycharge =  ($intialdcharge->deliverycharge*1)+($extraweight*$intialdcharge->extradeliverycharge);
        $weight = $row[6];
     }else{
        $deliverycharge =$intialdcharge->deliverycharge;
       $weight = 1;
     }
     // fixed cod charge
     if($row[3] > 100){
    //    $extracodcharge = 0;
    //    $codcharge = Session::get('codcharge')+$extracodcharge;
    $codcharge = 0;
     }else{
    //   $codcharge= Session::get('codcharge');
    $codcharge = 0;
     }
       return new Parcel([
           'recipientName'    => $row[0],
           'percelType'       => 1,
           'recipientPhone'   => $row[2],
           'cod'              => $row[3],
           'recipientAddress' => $row[4],
           'hub_id'       => $row[5],
           'productWeight'    => $row[6],
           'merchantId'       => $row[7],
           'trackingCode'     => mt_rand(1111,9999),
           'deliveryCharge'   => $deliverycharge,
           'codCharge'        => $codcharge,
           'merchantAmount'   => ($row[3])-($deliverycharge+$codcharge),
           'merchantDue'      => $row[3]-($deliverycharge+$codcharge),
           'codType'          => $intialdcharge->id,
           'orderType'        => $initialcodcharge->id,
           'status'           => 2,
        ]);

    }
}




  