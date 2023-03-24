<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public $table = 'positions';
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
    ];
}
