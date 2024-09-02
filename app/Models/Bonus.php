<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    use HasFactory;

    protected $casts = [
        'date_received' => 'date',
    ];

    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_number', 'employee_number');
    }
}
