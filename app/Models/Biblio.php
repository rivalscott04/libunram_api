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
    protected $with = ['publisher','author'];

    public function publisher(){
        return $this->hasOne(Publisher::class, 'publisher_id', 'publisher_id');
    }

    public function author(){
        return $this->hasMany(Author::class, 'biblio_id', 'biblio_id');
    }
}
