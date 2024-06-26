<?php

namespace App\Models;

use App\Observers\EmployeeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([EmployeeObserver::class])]
class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'employee_number';

    protected $appends = ['current_job_title'];

    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function insuranceClass()
    {
        return $this->belongsTo(InsuranceClass::class);
    }

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class);
    }

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    public function leaves()
    {
        return $this->hasMany(EmployeeLeave::class, 'employee_number', 'employee_number');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'employee_number', 'employee_number');
    }

    public function getCurrentJobTitleAttribute()
    {
        return $this->contracts()->latest('end_date')->first()->employeeJob->job_title;
    }
}
