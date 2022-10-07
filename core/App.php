<?php

namespace Core;

use Core\Exception\HttpException;
use Core\Routing\Route;

abstract class App
{
  public static function serve($requestURI): void
  {
    try {
      self::loadResources('helpers');
      self::loadResources('routes');
      Route::dispatch($requestURI);
    } catch (HttpException|\Exception $e) {
      echo $e->getMessage();
    }
  }

  private static function loadResources(string $directory)
  {
    $routes = scandir($directory);

    foreach ($routes as $route) {
      $filePath = join('/', [$directory, $route]);
      if (is_file($filePath)) @require_once $filePath;
    }
  }
}
