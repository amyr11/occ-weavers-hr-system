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

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'paper_contract_start_date' => 'date',
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

    public static function getDurationString(int|null $duration)
    {
        return $duration != null ? $duration . ' ' . Pluralizer::plural('year', $duration) : null;
    }
}
