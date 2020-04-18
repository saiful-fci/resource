<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';
    public $timestamps = true;
    protected $fillable = ['id','fk_book_name_id','available_qty','price','status'];

    public function Books()
    {
    	return $this->belongsTo(BookName::class,'fk_book_name_id');
    }
}