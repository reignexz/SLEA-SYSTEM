<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/admin/profile', function () {
    return view('admin.profile');
})->name('admin.profile');

Route::prefix('admin')->group(function () {
    Route::get('/create_assessor', 'App\Http\Controllers\AdminController@createAssessor')->name('admin.create_assessor');
    Route::get('/approve-reject', 'App\Http\Controllers\AdminController@approveReject')->name('admin.approve-reject');
    Route::get('/manage', 'App\Http\Controllers\AdminController@manageAccount')->name('admin.manage');
});
