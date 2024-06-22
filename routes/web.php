<?php

use App\Http\Controllers\FileInformationSheetController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('file-information-sheet/{employee}', FileInformationSheetController::class)->name('file-information-sheet');