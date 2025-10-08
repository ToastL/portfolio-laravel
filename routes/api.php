<?php

use App\Http\Controllers\Api\ProjectApiController;
use App\Http\Controllers\Api\ToolApiController;
use Illuminate\Support\Facades\Route;

Route::apiResource('projects', ProjectApiController::class)->only(['index', 'show']);
Route::apiResource('tools', ToolApiController::class)->only(['index', 'show']);
