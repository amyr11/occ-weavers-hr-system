<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

use function Spatie\LaravelPdf\Support\pdf;

class FileInformationSheetController extends Controller
{
    public function __invoke(Employee $employee)
    {
        return pdf()
            ->view('pdf.file_information_sheet', ['employee' => $employee])
            ->name($employee->employee_number . '-' . $employee->full_name . '.pdf')
            ->download();
    }
}
