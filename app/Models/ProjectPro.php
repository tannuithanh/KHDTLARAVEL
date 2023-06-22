<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPro extends Model
{
    public $table = 'projectprofessional';
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'department_id',
        'user_id',
        'startdate',
        'enddate',
        'completion',
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
    public function projectProChild1s() {
        return $this->hasMany(ProjectProChild1::class, 'projectpro_id');
    }
    public function updateCompletion() {
        // Calculate the new completion based on this level 1 project's child projects
        $count = $this->projectProChild1s()->count();
        if ($count > 0) {
            $this->completion = $this->projectProChild1s()->sum('completion') / $count;
            $this->save();
        }
    }
}
