<?php

Route::get('/qr-code', [App\Http\Controllers\HR\QrcodeController::class, 'index'])->name('qr-code.index');
