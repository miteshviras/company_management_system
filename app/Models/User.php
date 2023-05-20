<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'is_admin',
        'password',
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

    public function companies(){
        return $this->belongsToMany(Company::class,'users_companies');
    }

    public function scopeFilter($query)
    {
        if(request()->company != null){

                $query->whereHas('companies', function($internalQuery){
                    $internalQuery->where('company_id',request()->company);
                });

        }
    }

    public function scopeSearch($query)
    {
        if (!empty(request()->search)) {
            $search = "%" . request()->search . "%";
            $query->where(function ($internalQuery) use ($search) {
                $internalQuery->where('name', 'like', $search)->orWhere('email', $search);
            });
        }
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean'
    ];
}
