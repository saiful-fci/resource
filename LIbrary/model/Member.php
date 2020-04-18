<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
   	protected $table = 'Members';
    public $timestamps = true;
    protected $fillable = ['id','fk_custom_student_id'];
}