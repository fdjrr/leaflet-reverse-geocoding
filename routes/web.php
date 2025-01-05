<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('profile', 'profile')->name('profile');

    Route::prefix('category')->group(function () {
        Route::get('', \App\Livewire\Category\Index::class)->name('category.index');
        Route::get('create', \App\Livewire\Category\Create::class)->name('category.create');
        Route::get('{category:slug}/edit', \App\Livewire\Category\Edit::class)->name('category.edit');
    });

    Route::prefix('spot')->group(function () {
        Route::get('', \App\Livewire\Spot\Index::class)->name('spot.index');
        Route::get('view', \App\Livewire\Spot\View::class)->name('spot.view');
        Route::get('create', \App\Livewire\Spot\Create::class)->name('spot.create');
        Route::get('{spot:slug}/edit', \App\Livewire\Spot\Edit::class)->name('spot.edit');
    });
});

require __DIR__ . '/auth.php';
