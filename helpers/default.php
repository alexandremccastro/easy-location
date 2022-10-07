<?php

use Core\Helper\View;
use Core\Http\Request;

/**
 * Redirects the user to another page.
 *
 * @param string $uri The target URI.
 * @return void
 */
function redirect(string $uri)
{
  header("Location: $uri");
}

/**
 * Loads a view file and create dynamic variables.
 *
 * @param string $fileName The file that will be loaded.
 * @param array $params The variables to be displayed in the view.
 * @return null
 */
function view(string $fileName, array $params = [])
{
  return View::render($fileName, $params);
}

function request(): object
{
  return Request::getInstance();
}

/**
 * Formats a coin value by placing the coin symbol in the end.
 *
 * @param $value The amount of the money.
 * @param $symbol The symbol of the coin.
 * @return string The formatted value.
 */
function formatMoney($value, $symbol = null): string
{
  if (is_numeric($value)) return number_format($value, 2) . " $symbol";
  return $value;
}

/**
 * Formats a distance by placing KM in the end.
 *
 * @param $value The distance in KM.
 * @return string The formatted distance in KM.
 */
function formatKM($value): string
{
  if (is_numeric($value)) return number_format($value, 2) . ' KM';
  return $value;
}
