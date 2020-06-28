<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MayarMessage extends Model
{
    // 	 	
    protected $fillable=['MessageTarget','MessageSource','MessageValue','MessageStatus','MessageOrderId'];
}
