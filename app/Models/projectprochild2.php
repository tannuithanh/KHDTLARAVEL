<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projectprochild2 extends Model
{
    public $table = 'projectprochild2';
    use HasFactory;
    protected $fillable = [
        'id',
        'projectprochild1_id',
        'name',
        'department_id',
        'user_id',
        'startdate',
        'enddate',
        'completion',
        'note',
        'status',
        'lock',
        'created_at',
        'updated_at'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function tasks() {
        return $this->hasMany(Task::class, 'projectprochild2_id');
    }
    public function projectProChild1() {
        return $this->belongsTo(ProjectProChild1::class, 'projectprochild1_id');
    }
    public function updateCompletion() {
        $totalTasksCount = $this->tasks()->count();
        if ($totalTasksCount > 0) {
            $completedTasksCount = $this->tasks()->where('status', 'completed')->count();
            $this->completion = $completedTasksCount / $totalTasksCount;
            $this->save();
        }
    
        // Update the parent level 2 project
        $this->projectProChild1->updateCompletion();
    }
}
