<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trademark extends Model
{
    use HasFactory;
    public $table = 'trademark';
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
    ];
    public function departments() 
{
    return $this->hasMany(Department::class);
}
}
