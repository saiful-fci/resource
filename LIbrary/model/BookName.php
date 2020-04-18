<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookName extends Model
{
    protected $table = 'books_name';
    public $timestamps = true;
    protected $fillable = ['id','book_name','book_title','fk_publisher_id','fk_author_id'];

    public function publishers()
    {
    	return $this->belongsTo(Publisher::class,'fk_publisher_id');
    }
    public function authors()
    {
    	return $this->belongsTo(Author::class,'fk_author_id');
    }

}