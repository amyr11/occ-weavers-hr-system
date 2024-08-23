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

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'paper_contract_end_date' => 'date',
    ];

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
        $time = $this->start_date->diff($this->end_date->addDay(1));
        $duration_days = $time->format('%a');

        if (($duration_days / 365) % 365 >= 1) {
            $end_date = $this->start_date->addYear(round($duration_days / 365));
            $time = $this->start_date->diff($end_date);
        }

        $days = $time->d;
        $months = $time->m;
        $years = $time->y;

        $years_string = $years > 0 ? $years . ' ' . Pluralizer::plural('year', $years) : '';
        $months_string = $months > 0 ? $months . ' ' . Pluralizer::plural('month', $months) : '';
        $days_string = $days > 0 ? $days . ' ' . Pluralizer::plural('day', $days) : '';
        $duration = implode(', ', array_filter([$years_string, $months_string, $days_string]));

        return $duration;
    }
}
