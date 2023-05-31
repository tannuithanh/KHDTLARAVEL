<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Events\UserChanged;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public $table = 'users';
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function userById($id){
        $support = User::get()->where('id',$id)->first();
        return $support;
    }
    protected $fillable = [
        'name',
        'email',
        'password',
        'msnv',
        'department_id',
        'team_id',
        'position_id',
        'is_admin',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected static function booted()
{
    static::created(function ($user) {
        event(new UserChanged($user));
    });

    static::updated(function ($user) {
        event(new UserChanged($user));
    });

    static::deleted(function ($user) {
        event(new UserChanged($user));
    });
}
}
