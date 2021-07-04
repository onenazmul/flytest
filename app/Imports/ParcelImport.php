<?php
namespace App\Imports;
use App\Parcel;
use Maatwebsite\Excel\Concerns\ToModel;
use Session;
class ParcelImport implements ToModel
{
  public function model(array $row)
    {
    
      if (!isset($row[0]) || !isset($row[1]) || !isset($row[2]) || !isset($row[3]) || !isset($row[4]) || !isset($row[5]) || !isset($row[6])) {
            return NULL;
        }
      // fixed delivery charge
     if($row[6]>1 || $row[6]!=NULL){
        $extraweight = $row[6]-1;
        $deliverycharge = (Session::get('deliverycharge')*1)+($extraweight*Session::get('extradeliverycharge'));
        $weight = $row[6];
     }else{
        $deliverycharge = (Session::get('deliverycharge'));
       $weight = 1;
     }
     // fixed cod charge
     if($row[3] > 100){
       $extracodcharge = 0;
       $codcharge = Session::get('codcharge')+$extracodcharge;
     }else{
      $codcharge= Session::get('codcharge');
     }
       return new Parcel([
           'recipientName'    => $row[0],
           'percelType'       => $row[1],
           'recipientPhone'   => $row[2],
           'cod'              => $row[3],
           'recipientAddress' => $row[4],
           'reciveZone'       => $row[5],
           'productWeight'    => $row[6],
           'merchantId'       => Session::get('merchantId'),
           'trackingCode'     => mt_rand(1111,9999),
           'deliveryCharge'   => $deliverycharge,
           'codCharge'        => $codcharge,
           'merchantAmount'   => ($row[3])-($deliverycharge+$codcharge),
           'merchantDue'      => $row[3]-($deliverycharge+$codcharge),
           'codType'          => Session::get('codtype'),
           'orderType'        => Session::get('ordertype'),
           'status'           => 1,
        ]);

    }
}
