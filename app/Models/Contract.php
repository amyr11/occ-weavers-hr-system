<?php

namespace App\Models;

use App\Observers\ContractObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Pluralizer;

#[ObservedBy([ContractObserver::class])]
class Contract extends Model
{
    use HasFactory;

    protected $appends = ['duration_string'];

    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_number', 'employee_number');
    }

    public function employeeJob()
    {
        return $this->belongsTo(EmployeeJob::class);
    }

    public function getDurationStringAttribute()
    {
        $time = Carbon::parse($this->start_date)->diff($this->end_date);
        $years = $time->y;
        $years_string = $years > 0 ? $years . ' ' . Pluralizer::plural('year', $years): '';
        $months = $time->m;
        $months_string = $months > 0 ? $months . ' ' . Pluralizer::plural('month', $months): '';
        $days = $time->d;
        $days_string = $days > 0 ? $days . ' ' . Pluralizer::plural('day', $days) : '';
        $duration = implode(', ', array_filter([$years_string, $months_string, $days_string]));
        return $duration;
    }
}
