<?php

namespace Core\Routing;

use Exeption;

class URI
{
  /**
   * @var string The URI location.
   */
  private string $location;

  /**
   * @var string Specify the route method.
   */
  private string $method;

  /**
   * @var array The actions that the route will execute.
   */
  private $actions;

  public function __construct(string $location, string $method, $actions)
  {
    $this->location = $location;
    $this->method = $method;
    $this->actions = $actions;
  }

  /**
   * Returns the URI location.
   *
   * @return string The URI location.
   */
  public function getLocation(): string
  {
    return $this->location;
  }

  /**
   * Sets the URI location.
   *
   * @param string $location The URI location.
   * @return void
   */
  public function setLocation(string $location): void
  {
    $this->location = $location;
  }

  /**
   * Returns the method that the URI accepts.
   *
   * @return string The method that the URI accepts.
   */
  public function getMethod(): string
  {
    return $this->method;
  }

  /**
   * Sets the method that the URI accepts.
   *
   * @param string $method The method that the URI accepts.
   * @return void
   */
  public function setMethod(string $method): void
  {
    $this->method = $method;
  }

  /**
   * Execute the action related to the URI.
   *
   * @param array $params Params to pass to execution function.
   * @return void
   */
  public function execute(array $params = []): void
  {
    if (is_array($this->actions)) {
      [$clazz, $method] = $this->actions;
      (new $clazz())->$method(...$params);
    } else if (is_callable($this->actions)) {
      $function = $this->actions;
      $function(...$params);
    }
  }

  /**
   * Returns the regex pattern of the URI.
   *
   * @return string The regex pattern of the URI.
   */
  public function getPattern(): string
  {
    return join('', ['/', $this->transformToRegex($this->location), '$/i']);
  }

  /**
   * Clean a given URL by removing any GET param.
   *
   * @param string $url The URL that will be cleaned
   * @return mixed|string The URI without get params
   */
  private function getCleanURI(string $url)
  {
    // Removes get params if they exists
    [$uri, ] = explode('?', $url);

    return $uri;
  }

  /**
   * Transform a common URI into a regex pattern.
   *
   * @param string $uri The URI that will be transformed
   * @return array|string|string[]|null A regex pattern
   */
  private function transformToRegex(string $uri)
  {
    return preg_replace(['/{.*}/i', '/\//i'], ['(.*)', '\/'], $this->getCleanURI($uri));
  }

  /**
   * Verify if the URI matches a given URL.
   *
   * @param string $url The matcher URL.
   * @return bool TRUE if the URI matches the URL, otherwise FALSE.
   */
  public function matches(string $url): bool
  {
    return preg_match($this->getPattern(), $this->getCleanURI($url));
  }
}
