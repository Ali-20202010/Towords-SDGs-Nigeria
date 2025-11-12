<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SdgJsonController;

Route::get('/sdg', [SdgJsonController::class, 'goals']);
Route::get('/sdg/{goal}', [SdgJsonController::class, 'goal'])->whereNumber('goal');
