<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MayarService extends Model
{
    //
    protected $fillable=['ServiceName','ServiceThumb','ServicePrice','ServiceProviderId','ServiceCatId','ServiceDesc','ServiceOrderdNum','ServiceStatus'];
}
