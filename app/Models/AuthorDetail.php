<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorDetail extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $primaryKey  = 'author_id';
    protected $table = 'mst_author';
}
