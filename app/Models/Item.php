<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $primaryKey  = 'item_id';
    protected $table = 'item';
    protected $with = 'biblio';

    public function biblio(){
        return $this->belongsTo(Biblio::class, 'biblio_id','biblio_id')->select(['biblio_id','title','publisher_id','publish_year']);
    }
}
