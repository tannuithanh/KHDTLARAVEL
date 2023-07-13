<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskLink extends Model
{
    public $table = 'task_links';
    use HasFactory;
    protected $fillable = [
        'id',
        'dependent_task_id',
        'related_task_id',
        'dependent_task_table',
        'related_task_table',
        'relationship_type',
        'day',
    ];
}
