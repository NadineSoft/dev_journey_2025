<?php

use App\Http\Controllers\ProfileController;
use App\Services\BirthdayExporter;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/birthdays', function () {
        return view('pages.birthdays.index');
    })->name('birthdays');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/export/csv',function(BirthdayExporter $exp) {
        $csv = $exp->toCsv(auth()->id());
        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="birthdays.csv"',
        ]);
    })->middleware('throttle:30,1')->name('export.csv');

    Route::get('/export/ics', function (BirthdayExporter $exp) {
        $ics = $exp->toIcs(auth()->id());
        return response($ics, 200, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="birthdays.ics"',
        ]);
    })->middleware('throttle:30,1')->name('export.ics');
});

require __DIR__.'/auth.php';
