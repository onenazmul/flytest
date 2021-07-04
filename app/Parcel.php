<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
  protected $fillable = ['invoiceNo','recipientName','recipientAddress','recipientPhone','merchantId','merchantAmount','merchantDue','cod','productWeight','note','trackingCode','deliveryCharge','codCharge','orderType','codType','percelType','status','reciveZone','agentAprove'];
}
