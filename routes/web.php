<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RubricController;

// Static admin profile view
Route::get('/admin/profile', function () {
    return view('admin.profile');
})->name('admin.profile');

Route::prefix('admin')->group(function () {
    // Admin pages
    Route::get('/create_assessor', [AdminController::class, 'createAssessor'])->name('admin.create_assessor');
    Route::get('/approve-reject', [AdminController::class, 'approveReject'])->name('admin.approve-reject');

    // Manage Account
    Route::get('/manage', [AdminController::class, 'manageAccount'])->name('admin.manage');
    Route::patch('/manage/{user}/toggle', [AdminController::class, 'toggleUser'])->name('admin.manage.toggle');
    Route::delete('/manage/{user}', [AdminController::class, 'destroyUser'])->name('admin.manage.destroy');

    // Scoring Rubric Configuration (Frontend Ready)
    Route::get('/rubrics', [RubricController::class, 'index'])->name('admin.rubrics.index');
    Route::post('/rubrics', [RubricController::class, 'store'])->name('admin.rubrics.store');
    Route::patch('/rubrics/{id}', [RubricController::class, 'update'])->name('admin.rubrics.update');
    Route::delete('/rubrics/{id}', [RubricController::class, 'destroy'])->name('admin.rubrics.destroy');
});
