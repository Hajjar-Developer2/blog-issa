<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MayarOrder extends Model
{
    
    // 	 	 	 
    protected $fillable=['OrderServiceId','OrderUpgradesId','OrderCustomerId','OrderStatus','OrderPrice'];
}
