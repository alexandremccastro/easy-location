<?php

use Core\Helper\View;
use Core\Http\Request;

function redirect(string $uri)
{
  header("Location: $uri");
}

function view($fileName, $params)
{
  return View::render($fileName, $params);
}

function request(): object
{
  return Request::getInstance();
}

function formatMoney($value, $symbol = null): string
{
  if (is_numeric($value)) return number_format($value, 2) . " $symbol";
  return $value;
}

function formatKM($value): string
{

  if (is_numeric($value)) return number_format($value, 2) . ' KM';
  return $value;
}
