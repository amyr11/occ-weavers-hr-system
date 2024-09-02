<?php

use App\Http\Controllers\FileInformationSheetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return redirect(route('filament.admin.auth.login'));
});

Route::get('/login', function () {
	return redirect(route('filament.admin.auth.login'));
})->name('login');
