<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    public $table = 'departments';
    protected $fillable = [
        'name',
        'description',
        'trademark_id'
    ];
    public function trademark() 
{
    return $this->belongsTo(Trademark::class);
}
}
