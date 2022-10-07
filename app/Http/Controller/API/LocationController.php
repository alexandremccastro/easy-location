<?php

namespace App\Http\Controller\API;

use App\Repositories\LocationRepository;

class LocationController
{
	private LocationRepository $locationRepository;

	public function __construct()
	{
		$this->locationRepository = new LocationRepository();
	}

	public function filter(): void
	{
		$result = $this->locationRepository->filter(request()->all());

		echo json_encode($result);
	}
}