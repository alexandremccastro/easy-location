<?php

use App\Http\Controller\HomeController;
use Core\Routing\Route;

Route::get('/', function () {
  redirect('/home');
});

Route::get('/home', [HomeController::class, 'home']);
