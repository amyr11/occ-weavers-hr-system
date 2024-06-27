<?php

namespace App\Models;

use App\Observers\EmployeeLeaveObserver;
use App\Observers\EmployeeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([EmployeeLeaveObserver::class])]
class EmployeeLeave extends Model
{
    use HasFactory;

    protected $appends = ['duration_in_days'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_number', 'employee_number');
    }

    public function getDurationInDaysAttribute()
    {
        // Replace this with the actual computation logic
        return \Carbon\Carbon::parse($this->start_date)->diffInDays(\Carbon\Carbon::parse($this->end_date)) + 1;
    }
}
