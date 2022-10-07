<?php

namespace Core\Common;

class Singletron
{
  /**
   * @var object The class instance;
   */
  public static object $instance;

  /**
   * Returns an instance of the object.
   *
   * @return object The object instance.
   */
  public static function getInstance(): object
  {
    if (empty(self::$instance)) {
      self::$instance = new static();
    }

    return self::$instance;
  }
}