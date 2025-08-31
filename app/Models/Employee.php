<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'role',
        'status',
        'profile_picture',
        'phone_number',
        'salary',
        'join_date',
    ];

    protected $casts = [
    'salary' => 'decimal:2',
    'join_date' => 'date', 
];

public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function workLogs()
    {
        return $this->hasMany(WorkLog::class);
    }

}