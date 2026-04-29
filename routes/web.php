<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome'); // The default Laravel landing page
});

// This line handles all the login/register/logout routes automatically
Auth::routes();

// THE BOUNCER: Everything inside this group requires you to be logged in!
Route::middleware(['auth'])->group(function () {

    // The Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/export/csv', [HomeController::class, 'exportCsv'])->name('export.csv');
    Route::get('/export/pdf', [HomeController::class, 'exportPdf'])->name('export.pdf');
    // Create Findings
    Route::get('/findings/create', [HomeController::class, 'create'])->name('findings.create');
    Route::post('/findings', [HomeController::class, 'store'])->name('findings.store');

    // View & Delete Findings
    Route::get('/findings/{id}', [HomeController::class, 'show'])->name('findings.show');
    Route::delete('/findings/{id}', [HomeController::class, 'destroy'])->name('findings.destroy');

    // Edit Findings
    Route::get('/findings/{id}/edit', [HomeController::class, 'edit'])->name('findings.edit');
    Route::put('/findings/{id}', [HomeController::class, 'update'])->name('findings.update');
    // Resolve Findings
    Route::patch('/findings/{id}/resolve', [HomeController::class, 'resolve'])->name('findings.resolve');

});
