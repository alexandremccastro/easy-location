<?php

use App\Controller\HomeController;
use Core\Routing\Route;

Route::get('/', [HomeController::class, 'home']);
Route::get('/users/{user}/edit', [HomeController::class, 'edit']);
