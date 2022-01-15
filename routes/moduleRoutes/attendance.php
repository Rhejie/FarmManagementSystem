<?php

Route::get('/attendance', [App\Http\Controllers\Leadman\AttendanceController::class, 'index'])->name('attendance.index');

Route::group(['prefix' => 'attendance', 'middleware' => 'auth'], function () {
    Route::get('/get-attendance', [App\Http\Controllers\Leadman\AttendanceController::class, 'getAttendance']);
    Route::post('/store-attendance', [App\Http\Controllers\Leadman\AttendanceController::class, 'storeAttendance']);
    Route::post('/update-attendance/{id}', [App\Http\Controllers\Leadman\AttendanceController::class, 'updateAttendance']);
});
