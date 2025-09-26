<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssessorController;
use App\Http\Controllers\RubricController;

// Login and registration routes will be implemented by your teammate

// Dashboard route (placeholder)
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard');

// Static admin profile view
Route::get('/admin/profile', function () {
    return view('admin.profile');
})->name('admin.profile');

Route::prefix('admin')->group(function () {
    // Admin dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Admin pages
    Route::get('/create_assessor', [AdminController::class, 'createAssessor'])->name('admin.create_assessor');
    Route::get('/approve-reject', [AdminController::class, 'approveReject'])->name('admin.approve-reject');
    Route::get('/submission-oversight', [AdminController::class, 'submissionOversight'])->name('admin.submission-oversight');
    Route::get('/submission-oversight/export', [AdminController::class, 'exportSamplePdf'])->name('admin.submission-oversight.export');
    Route::get('/final-review', [AdminController::class, 'finalReview'])->name('admin.final-review');
    Route::get('/award-report', [AdminController::class, 'awardReport'])->name('admin.award-report');
    Route::get('/system-monitoring', [AdminController::class, 'systemMonitoring'])->name('admin.system-monitoring');

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

// Assessor routes
Route::prefix('assessor')->group(function () {
    // Assessor dashboard and profile
    Route::get('/dashboard', [AssessorController::class, 'dashboard'])->name('assessor.dashboard');
    Route::get('/profile', [AssessorController::class, 'profile'])->name('assessor.profile');
    Route::patch('/profile', [AssessorController::class, 'updateProfile'])->name('assessor.profile.update');
    Route::patch('/password', [AssessorController::class, 'updatePassword'])->name('assessor.password.update');
    Route::post('/profile-picture', [AssessorController::class, 'updateProfilePicture'])->name('assessor.profile.picture');
    
    // Assessor submission management
    Route::get('/pending-submissions', [AssessorController::class, 'pendingSubmissions'])->name('assessor.pending-submissions');
    Route::get('/submissions', [AssessorController::class, 'submissions'])->name('assessor.submissions');
    Route::get('/final-review', [AssessorController::class, 'finalReview'])->name('assessor.final-review');
    
    // API routes for submission review
    Route::get('/submissions/{id}/details', [AssessorController::class, 'getSubmissionDetails'])->name('assessor.submission.details');
    Route::post('/submissions/{id}/action', [AssessorController::class, 'handleSubmissionAction'])->name('assessor.submission.action');
    Route::get('/documents/{id}/download', [AssessorController::class, 'downloadDocument'])->name('assessor.document.download');
});
