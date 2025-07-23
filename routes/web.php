<?php

use Illuminate\Support\Facades\Route;

Route::get('/admin/profile', function () {
    return view('admin.profile');
})->name('admin.profile');
