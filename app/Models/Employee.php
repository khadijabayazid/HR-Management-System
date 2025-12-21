<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'national_id',
        'job_title_id',
        'employment_type',
        'hire_date',
        
    ];

    public function jobTitle(){
        return $this->belongsTo(JobTitle::class);
    }

    public function attendances(){
        return $this->hasMany(Attendance::class);
    }
}
