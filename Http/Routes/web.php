<?php

use Modules\IfaTours\Http\Controllers\Frontend\TourController;

Route::get('tours', [TourController::class, 'index'])->name('tours.index');
Route::get('/tours/{tour}', [TourController::class, 'show'])->name('tours.show');
