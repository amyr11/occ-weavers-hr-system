<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Enums\Format;

use function Spatie\LaravelPdf\Support\pdf;

class FileInformationSheetController extends Controller
{
    public function __invoke(Employee $employee)
    {
        return pdf()
            ->view('pdf.file_information_sheet', ['employee' => $employee])
            ->format(Format::A4)
            ->margins(5, 10, 5, 10)
            ->name($employee->employee_number . '-' . $employee->full_name . '.pdf')
            ->download();
    }
}
