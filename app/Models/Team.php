<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public $table = 'teams';
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'department_id',
    ];
}
