<?php

namespace Core\Helper\Globals;

abstract class Server
{
  public static function getRequestURI()
  {
    return $_SERVER['REQUEST_URI'];
  }
}