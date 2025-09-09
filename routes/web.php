<?php

use App\Http\Controllers\AssignHomePageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AssignHomePageController::class, 'index']);
