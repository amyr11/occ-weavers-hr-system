<?php

namespace App\Models;

use App\Observers\ContractObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([ContractObserver::class])]
class Contract extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_number', 'employee_number');
    }

    public function employeeJob()
    {
        return $this->belongsTo(EmployeeJob::class);
    }
}
