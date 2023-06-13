<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workmonth extends Model
{
    public $table = 'workmonth';
    use HasFactory;
    protected $fillable = [
        'id',
        'startMonth',
        'endMonth',
        'categoryMonth',
        'describeMonth',
        'responsibility',
        'department_id',
        'team_id',
        'note',
        'support',
        'status',
        'inadequacy',
        'propose',
        'Result',

    ];
}
