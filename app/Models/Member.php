<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    // public $primaryKey  = 'member_id';
    protected $table = 'member';
    // protected $with = 'guest';

    // public function guest(){
    //     return $this->hasMany(Guest::class, 'nim','member_id');
    // }
}
