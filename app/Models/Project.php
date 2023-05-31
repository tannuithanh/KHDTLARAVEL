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
        'name_create',
        'start_date',
        'end_date',
        'status',
        'lock',
        'car_brands_id',
        'car_brands_child_id',
        'completion',
    ];
    
    public function projectDepartments()
    {
        return $this->hasMany(ProjectDepartment::class, 'project_id');
    }
    public function isDelayed(){
    foreach ($this->projectDepartments as $projectDepartment) {
        if ($projectDepartment->isDelayed()) {
            return true;
        }
    }
    return false;
    }
    public function updateCompletion()
{
    $this->completion = round($this->projectDepartments->average('completion'));

    $this->save();
}
}
