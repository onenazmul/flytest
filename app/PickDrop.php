<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PickDrop extends Model
{
    protected $fillable = ['address','area','note','estimate','phone'];
}
