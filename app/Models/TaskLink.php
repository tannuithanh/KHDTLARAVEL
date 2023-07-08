<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
