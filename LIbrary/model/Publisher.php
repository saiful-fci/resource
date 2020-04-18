<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
   	protected $table = 'publishers';
    public $timestamps = true;
    protected $fillable = ['id','publisher_name','publisher_mobile','publisher_email','publisher_address'];
}
