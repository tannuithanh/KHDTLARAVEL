<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectDepartment extends Model
{
    public $table = 'project_department';
    use HasFactory;
    protected $fillable = [
        'id',
        'project_id',
        'department_id',
        'department_id1',
        'startdate',
        'enddate',
        'name',
        'status',
        'completion',
        'number_of_edits',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function works()
    {
        return $this->hasMany(Work_By_Project_Department::class, 'project_department_id');
    }
    public function isDelayed(){
    foreach ($this->works as $work) {
        if ($work->isDelayed()) {
            return true;
        }
    }
    return false;
    }
    public function updateCompletion()
{
    // Cập nhật completion của model này dựa trên completion trung bình của các Work_By_Project_Department liên quan
    $this->completion = round($this->works->average('completion'));

    $this->save();

    // Cập nhật completion của Project liên quan
    $this->project->updateCompletion();
}

}
