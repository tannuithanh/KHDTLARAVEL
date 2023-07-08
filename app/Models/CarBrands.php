<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarBrands extends Model
{
    public $table = 'car_brands';
    use HasFactory;
    
    protected $fillable = [
        'id',
        'name',
        'description',
        'describeWeek',
    ];
    public function projects()
{
    return $this->hasMany(Project::class, 'car_brands_id');
}
public function children()
{
    return $this->hasMany(CarBrandsChild::class, 'car_brands_id');
}
}
