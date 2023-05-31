<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class work_lv4_project extends Model
{
    public $table = 'work_lv4_project';
    use HasFactory;
    protected $fillable = [
        'id',
        'work_by_project_department_id',
        'name_work',
        'responsibility',
        'startdate',
        'enddate',
        'status',
        'completion',
        'created_at',
        'updated_at'
    ];
    public function workByProjectDepartment()
    {
        return $this->belongsTo(Work_By_Project_Department::class, 'work_by_project_department_id');
    }

    public function updateCompletion()
{
    // Làm tròn giá trị completion trước khi lưu
    $this->completion = round($this->completion);

    $this->save();
    $this->workByProjectDepartment->updateCompletion();
}
}