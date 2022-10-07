<?php

namespace Core\Http;

use Core\Common\Singletron;

class Request extends Singletron
{
  /**
   * Returns a given key that is in get array
   *
   * @param string $key The param to in get array.
   * @return mixed|null The value in get array.
   */
  public function get(string $key)
  {
    return $_GET[$key] ?? null;
  }

  /**
   * Returns a given key that is in post array
   *
   * @param string $key The param to in post array.
   * @return mixed|null The value in post array.
   */
  public function post(string $key)
  {
    return $_POST[$key] ?? null;
  }

  /**
   * Returns all params in post and get array.
   *
   * @return array All the values of the current request.
   */
  public function all(): array
  {
    return array_merge($_GET, $_POST);
  }
}