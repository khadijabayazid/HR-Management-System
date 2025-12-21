<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobTitle extends Model
{
    protected $fillable = [
        'department_id',
        'title'
    ];
    
    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function employees(){
        return $this->hasMany(Employee::class);
    }
}
