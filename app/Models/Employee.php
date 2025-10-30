<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'department_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'position',
        'gender',
        'hire_date',
        'salary',
        'password',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'hire_date' => 'date',
        'salary' => 'decimal:2',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    // Méthode pour obtenir le nom complet
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}