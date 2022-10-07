<?php

namespace Core\Routing;

use Core\Exception\HttpException;

abstract class Route
{
  /**
   * The routes available in the application.
   */
  private static array $routes = [];

  public static function get(string $location, $actions)
  {
    self::addURI($location, 'get', $actions);
  }

  public static function post(string $location, $actions)
  {
    self::addURI($location, 'post', $actions);
  }

  public static function put(string $location, $actions = [])
  {
    self::addURI($location, 'put', $actions);
  }

  public static function patch(string $location, $actions)
  {
    self::addURI($location, 'patch', $actions);
  }

  public static function delete(string $location, $actions)
  {
    self::addURI($location, 'delete', $actions);
  }

  private static function addURI(string $location, string $method, $actions): void
  {
    self::$routes[] = new URI($location, $method, $actions);
  }

  /**
   * Loads the route that has matches with the URL
   *
   * @param string $url The URL that will be loaded.
   * @throws HttpException Not found exception if the route is not found.
   */
  public static function dispatch(string $url) : void
  {
    $matched = self::getMatched($url);

    if (!empty($matched)) {
      $params = self::parseParams($matched, $url);
      $matched->execute($params);
    } else {
      throw new HttpException('Not found.', 404);
    }
  }

  /**
   * Returns all route params contained in a given URL.
   *
   * @param URI $uri The URI that will be used for comparison.
   * @param string $url The URL that contains the params.
   * @return array Return the request params.
   */
  public static function parseParams(URI $uri, string $url): array
  {
    $uriPeaces = explode('/', $uri->getLocation());
    $requestURI = explode('/', $url);

    foreach ($uriPeaces as $index => $uri) {
      if (preg_match('/{.*}/i', $uri)) {
        $params[] = $requestURI[$index];
      }
    }

    return $params ?? [];
  }

  /**
   * Returns the route that matches the given URL.
   *
   * @param string $url The URL that will be verified.
   * @return false|mixed Returns the matched route.
   */
  public static function getMatched(string $url)
  {
    $matched = array_filter(self::$routes, function (URI $route) use ($url) {
      return $route->matches($url);
    });

    return current($matched);
  }
}
