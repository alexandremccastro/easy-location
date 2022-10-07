<?php

use App\Http\Controller\API\LocationController;
use Core\Routing\Route;

Route::get('/api/locations', [LocationController::class, 'filter']);
