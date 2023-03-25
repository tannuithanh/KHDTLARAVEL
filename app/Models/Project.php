<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $table = 'project';
    use HasFactory;
    protected $fillable = [
        'id',
        'name_project',
        'describe_project',
        'name_create',
        'start_date',
        'end_date',
        'status',
        'privacy',
    ];
}
