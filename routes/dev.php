<?php

use App\Http\Controllers\DevController;
use Illuminate\Support\Facades\Route;

Route::get('/dev/components', [DevController::class, 'components'])
    ->name('dev.components');
