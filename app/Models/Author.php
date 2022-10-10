<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $primaryKey  = 'author_id';
    protected $table = 'biblio_author';
    protected $with = 'author_detail';

    public function author_detail(){
        return $this->hasOne(AuthorDetail::class, 'author_id','author_id');
    }
}
