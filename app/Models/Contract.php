<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    // protected $appends = ['duration_in_years'];

    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_number', 'employee_number');
    }

    public function employeeJob()
    {
        return $this->belongsTo(EmployeeJob::class);
    }

    // public function getDurationInYearsAttribute()
    // {
    //     return intval(\Carbon\Carbon::parse($this->start_date)->diffInYears(\Carbon\Carbon::parse($this->end_date)));
    // }
}
