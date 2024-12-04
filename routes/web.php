<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NASAController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

Route::prefix('api')->group(function () {
    Route::get('/instruments', [NASAController::class, 'getInstruments']);
    Route::get('/activities', [NASAController::class, 'getActivities']);
    Route::get('/instruments/usage', [NASAController::class, 'getInstrumentUsage']);
    Route::post('/instruments/usage', [NASAController::class, 'getInstrumentUsageByInstrument'])
        ->withoutMiddleware([VerifyCsrfToken::class]);
});
