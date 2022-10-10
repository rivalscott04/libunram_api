<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biblio extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $primaryKey  = 'biblio_id';
    protected $table = 'biblio';
    protected $with = 'publisher';

    public function publisher(){
        return $this->hasOne(Publisher::class, 'publisher_id', 'publisher_id');
    }
}
