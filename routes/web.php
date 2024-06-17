<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobPostController;


Route::get('', fn() => to_route('jobs.index'));

Route::resource('jobs', JobPostController::class)->only('index', 'show');