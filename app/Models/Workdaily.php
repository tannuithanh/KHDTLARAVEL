<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workdaily extends Model
{
    public $table = 'workdaily';
    use HasFactory;

    protected $fillable = [
        'id',
        'workweek_id',
        'categoryDaily',
        'describeDaily',
        'responsibility',
        'support',
        'department_id',
        'team_id',
        'date',
        'time',
        'status',
        'note',
        'inadequacy',
        'propose',
        'Result',
        'ResultByWookWeek',
    ];

}
