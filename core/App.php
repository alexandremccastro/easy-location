<?php

namespace Core;

use Core\Exception\HttpException;
use Core\Routing\Route;

abstract class App
{
  public static function serve($requestURI): void
  {
    $routes = scandir('routes');

    foreach ($routes as $route) {
      $filePath = join('/', ['routes', $route]);
      if (is_file($filePath)) @require_once $filePath;
    }

    try {
      Route::dispatch($requestURI);
    } catch (HttpException|\Exception $e) {
      echo $e->getMessage();
    }
  }
}
