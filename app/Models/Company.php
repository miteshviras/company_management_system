<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'title',
        'email',
        'password',
        'status'
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function scopeFilter($query)
    {
        if(request()->status != null){
            if (in_array(request()->status, [0, 1])) {
                $query->where('status', request()->status);
            }
        }
    }

    public function scopeSearch($query)
    {
        if (!empty(request()->search)) {
            $search = "%" . request()->search . "%";
            $query->where(function ($internalQuery) use ($search) {
                $internalQuery->where('title', 'like', $search)->orWhere('email', $search);
            });
        }
    }

    public function users(){
        return $this->belongsToMany(User::class,'users_companies');
    }
}
