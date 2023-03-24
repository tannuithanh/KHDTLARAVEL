<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workweek extends Model
{
    public $table = 'workweek';
    use HasFactory;
    protected $fillable = [
        'id',
        'categoryWeek',
        'describeWeek',
        'describeWeek',
        'support',
        'department_id',
        'team_id',
        'startdate',
        'enddate',
        'note',
        'status',
        'inadequacy',
        'propose',
        'Result',
        'fileupload',

    ];
}
