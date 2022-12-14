<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;

    public $primaryKey  = 'publisher_id';
    public $timestamps = false;
    protected $table = 'mst_publisher';
}
