<?php

namespace Core;

use Core\Exception\HttpException;
use Core\Routing\Route;

abstract class App
{
	/**
	 * App start point that loads all resources.
	 *
	 * @param string $requestURI That request that will be processed.
	 * @return void
	 */
  public static function serve(string $requestURI): void
  {
    try {
      self::loadResources('helpers');
      self::loadResources('routes');
      Route::dispatch($requestURI);
    } catch (HttpException|\Exception $e) {
      echo $e->getMessage();
    }
  }

	/**
	 * Load all files in a given directory.
	 *
	 * @param string $directory The directory that will be loaded.
	 * @return void
	 */
  private static function loadResources(string $directory)
  {
    $routes = scandir($directory);

    foreach ($routes as $route) {
      $filePath = join('/', [$directory, $route]);
      if (is_file($filePath)) @require_once $filePath;
    }
  }
}
