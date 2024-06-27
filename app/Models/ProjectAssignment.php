<?php

namespace App\Models;

use App\Observers\ProjectAssignmentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([ProjectAssignmentObserver::class])]
class ProjectAssignment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['from_project'];

    protected $casts = [
        'transfer_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_number', 'employee_number');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function getFromProjectAttribute()
    {
        // Check the previous project assignment if this is sorted by transfer date
        $previousAssignment = ProjectAssignment::where('employee_number', $this->employee_number)
            ->where('transfer_date', '<', $this->transfer_date)
            ->orderBy('transfer_date', 'desc')
            ->first();

        return $previousAssignment?->project;
    }
}
