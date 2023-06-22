<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projectprochild1 extends Model
{
    public $table = 'projectprochild1';
    use HasFactory;
    protected $fillable = [
        'id',
        'projectpro_id',
        'name',
        'department_id',
        'user_id',
        'startdate',
        'enddate',
        'completion',
        'status',
        'note',
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
    public function projectPro() {
        return $this->belongsTo(ProjectPro::class, 'projectpro_id');
    }
    public function projectProChild2s() {
        return $this->hasMany(ProjectProChild2::class, 'projectprochild1_id');
    }
    public function updateCompletion() {
        // Calculate the new completion based on this level 2 project's child projects
        $count = $this->projectProChild2s()->count();
        $count = $this->projectProChild2s()->count();
        if ($count > 0) {
            $this->completion = $this->projectProChild2s()->sum('completion') / $count;
            $this->save();
        }
    
        // Check if parent project exists before trying to update it
        if ($this->projectPro) {
            $this->projectPro->updateCompletion();
        }
    }
}
