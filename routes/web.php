<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\MyJobApplicationController;
use App\Http\Controllers\MyJobController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobPostController;


Route::get('', fn() => to_route('jobs.index'));

Route::resource('jobs', JobPostController::class)->only('index', 'show');


Route::get('/login', fn() => to_route('auth.create'))->name('login');
Route::resource('auth', AuthController::class)->only('create', 'store');

Route::delete('/logout', fn() => to_route('auth.destroy'))->name('logout');
Route::delete('auth', [AuthController::class, 'destroy'])->name('auth.destroy');

Route::middleware('auth')->group(function () {
    Route::resource('job.application', JobApplicationController::class)->only(['create', 'store']);

    Route::resource('my-job-applications', MyJobApplicationController::class)->only(['index', 'destroy']);

    Route::resource('employer', EmployerController::class)->only(['create', 'store']);

    Route::middleware('employer')->resource('my-jobs', MyJobController::class);

    Route::middleware('employer')->get('job/trash', [MyJobController::class, 'trash'])->name('trash');
    Route::middleware('employer')->post('job/restore/{my_job}', [MyJobController::class, 'restore'])->name('my-jobs.restore');
    Route::middleware('employer')->delete('job/force-delete/{my_job}', [MyJobController::class, 'forceDelete'])->name('my_job.forceDelete');
});