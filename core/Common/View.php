<?php

namespace Core\Common;

abstract class View
{
  private static string $directory = 'views';

  /**
   * Render a view content and loads variables
   *
   * @param string $fileName The view that will be loaded.
   * @param array $params The params passed to the view.
   * @return void
   */
  public static function render(string $fileName, array $params = []): void
  {
    // Creates dynamic variable names
    foreach ($params as $name => $value) {
      $$name = $value;
    }

    $filePath = self::getPath($fileName);
    if (file_exists($filePath)) @require_once $filePath;
  }

  /**
   * Returns the full path of a view.
   *
   * @param $resource
   * @return string The full path of the view.
   */
  private static function getPath($resource): string
  {
    return join('/', [self::$directory, $resource]) . '.php';
  }
}
