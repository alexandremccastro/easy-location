<?php

namespace App\Classes;

class Location
{
  private string $name;
  private string $latitude;
  private string $longitude;
  private string $price;
  private string $distance;

  public function __construct(string $name, string $latitude, string $longitude, string $price, $distance)
  {
    $this->name = $name;
    $this->latitude = $latitude;
    $this->longitude = $longitude;
    $this->price = $price;
    $this->distance = $distance;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getLatitude(): string
  {
    return $this->latitude;
  }

  public function getLongitude(): string
  {
    return $this->longitude;
  }

  public function getDistance(): string
  {

    return $this->distance;
  }

  public function getPrice(): string
  {
    return $this->price;
  }
}

