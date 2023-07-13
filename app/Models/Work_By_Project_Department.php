<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work_By_Project_Department extends Model
{
    public $table = 'work_by_project_department';
    use HasFactory;
    protected $fillable = [
        'id',
        'project_department_id',
        'name_work',
        'responsibility',
        'startdate',
        'enddate',
        'status',
        'completion',
        'preceding_work_id', 
        'relationship_type' 
    ];
    public function updateDates($daysChange)
{
    $this->startdate = date('Y-m-d', strtotime("{$this->startdate} +{$daysChange} days"));
    $this->enddate = date('Y-m-d', strtotime("{$this->enddate} +{$daysChange} days"));

    $this->save();
}
    public function work_lv4_projects()
    {
        return $this->hasMany(work_lv4_project::class, 'work_by_project_department_id');
    }
    public function projectDepartment()
    {
        return $this->belongsTo(ProjectDepartment::class);
    }

    public function isDelayed()
{
    $today = date('Y-m-d');
    foreach ($this->work_lv4_projects as $work) {
        if ($work->enddate < $today && $work->completion < 100 && $work->status == 0) {
            return true;
        }
    }
    return false;
}
public function updateCompletion()
{
    $this->completion = round($this->work_lv4_projects->average('completion'));
    $this->save();
    $this->projectDepartment->updateCompletion();
}
    
}
