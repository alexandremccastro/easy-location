<?php

namespace App\Http\Controller;

use App\Repositories\LocationRepository;

class HomeController
{
  private LocationRepository $locationRepository;

  public function __construct()
  {
    $this->locationRepository = new LocationRepository();
  }

  public function home()
  {
    $result = $this->locationRepository->filter(request()->all());
    [$locations, $pagination] = array_values($result);

    return view('home', compact('locations', 'pagination'));
  }
}
