<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\CareersController;
use App\Http\Controllers\Api\TeacherController;


Route::post('/login', [TeacherController::class, 'login']);

Route::get('/Teacher', [TeacherController::class, 'index']);
Route::post('/Teacher', [TeacherController::class, 'store']);
Route::get('/Teacher/{id}', [TeacherController::class, 'show']);
Route::delete('/Teacher/{id}', [TeacherController::class, 'destroy']);



Route::get('/student', [StudentController::class, 'index']);

Route::get('/student/{id}', [StudentController::class, 'show']);

Route::post('/student', [StudentController::class, 'store']);

Route::put('/student/{id}', [StudentController:: class, 'update']);

Route::patch('/student/{id}', [StudentController:: class, 'updatePartial']);

Route::delete('/student/{id}', [StudentController:: class, 'destroy']);







Route::get('/careers', [CareersController::class, 'index']);

Route::get('/careers/{id}', [CareersController::class, 'show']);

Route::post('/careers', [CareersController::class, 'store']);

Route::put('/careers/{id}', [CareersController:: class, 'update']);

Route::delete('/careers/{id}', [CareersController:: class, 'destroy']);
