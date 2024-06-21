<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'employee_number';

    protected $guarded = [];

    public function employeeStatus()
    {
        return $this->belongsTo(EmployeeStatus::class);
    }
}
