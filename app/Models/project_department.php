<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class project_department extends Model
{
    public $table = 'project_department';
    use HasFactory;
    protected $fillable = [
        'id',
        'project_id',
        'department_id',
    ];
}
