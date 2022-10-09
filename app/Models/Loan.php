<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'loan_date'
    ];
    public $primaryKey  = 'loan_id';
    protected $table = 'loan';

    public function item(){
        return $this->belongsTo(Item::class, 'item_code', 'item_code')->select('item_code','biblio_id');
    }
}
