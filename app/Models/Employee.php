<?php

namespace App\Models;

use App\Observers\EmployeeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Remls\HijriDate\HijriDate;

#[ObservedBy([EmployeeObserver::class])]
class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'employee_number';

    protected $casts = [
        'birthdate' => 'date',
        'college_graduation_date' => 'date',
        'iqama_expiration_hijri' => HijriDate::class,
        'iqama_expiration_gregorian' => 'date',
        'passport_date_issue' => 'date',
        'passport_expiration' => 'date',
        'sce_expiration' => 'date',
        'company_start_date' => 'date',
        'final_exit_date' => 'date',
        'visa_expired_date' => 'date',
        'transferred_date' => 'date',
        'electronic_contract_start_date' => 'date',
        'electronic_contract_end_date' => 'date',
        'paper_contract_end_date' => 'date',
    ];

    protected $guarded = [];

    public function bonuses()
    {
        return $this->hasMany(Bonus::class, 'employee_number', 'employee_number');
    }

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

    public function employeeJob()
    {
        return $this->belongsTo(EmployeeJob::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function addLeaves(int $days)
    {
        $this->current_leave_days += $days;
    }
}
