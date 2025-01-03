<?php

use App\Http\Controllers\Api\v1\SpotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('spots', SpotController::class);
});
