<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarBrandsChild extends Model
{
    use HasFactory;
    public $table = 'car_brands_child';
    use HasFactory;
    
    protected $fillable = [
        'id',
        'name',
        'car_brands_id',
        'created_at',
        'updated_at',
    ];
    public function projects() {
        return $this->hasMany(Project::class, 'car_brands_child_id');
    }
}
