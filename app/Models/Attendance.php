<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'check_in',
        'check_out',
        'status',
        'late_minutes',
        'notes',
        'edited_by'
    ];
    
    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    public function editor(){
        return $this->belongsTo(User::class, 'edited_by');
    }
}
