<?php

use Modules\IfaTours\Http\Controllers\Admin\TourController;
use Modules\IfaTours\Http\Controllers\Admin\TourLegController;

Route::group(['as' => 'admin.tours.'], function () {
    Route::get('/', [TourController::class, 'index'])->name('index');
    Route::get('/create', [TourController::class, 'create'])->name('create');
    Route::post('/', [TourController::class, 'store'])->name('store');
    Route::get('/{tour}/edit', [TourController::class, 'edit'])->name('edit');
    Route::put('/{tour}', [TourController::class, 'update'])->name('update');
    Route::delete('/{tour}', [TourController::class, 'destroy'])->name('destroy');

    Route::group(['prefix' => '{tour}/legs', 'as' => 'legs.'], function () {
        Route::get('/', [TourLegController::class, 'index'])->name('index');
        Route::get('/create', [TourLegController::class, 'create'])->name('create');
        Route::post('/', [TourLegController::class, 'store'])->name('store');
        Route::delete('/{leg}', [TourLegController::class, 'destroy'])->name('destroy');
    });
});

