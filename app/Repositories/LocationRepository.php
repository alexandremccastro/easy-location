<?php

namespace App\Repositories;

use App\Classes\Location;
use Core\Database\Repository;
use Core\Http\Client as HttpClient;

class LocationRepository extends Repository
{
  private array $dataSources = [
    'https://xlr8-interview-files.s3.eu-west-2.amazonaws.com/source_1.json',
    'https://xlr8-interview-files.s3.eu-west-2.amazonaws.com/source_2.json'
  ];

	/**
	 * Filter all data from the repository.
	 *
	 * @param $params The params to filter.
	 * @return array The list of items filtered.
	 */
  public function filter($params = []): array
  {
    $client = new HttpClient();

    foreach ($this->dataSources as $dataSource) {
      $result = $client->get($dataSource);
      [, $result] = array_values($result);
      $this->items = array_merge($this->items, $result);
    }

    $this->items = $this->collection();

    if (isset($params['orderBy'])) {
      for ($i = 0; $i < count($this->items); $i++) {
        for ($j = 0; $j < count($this->items) - 1; $j++) {

          if ($params['orderBy'] == 'price') {
            $verification = $this->orderByPrice($this->items[$j], $this->items[$i]);
          } else if ($params['orderBy'] == 'proximity') {
            $verification = $this->orderByProximity($this->items[$j], $this->items[$i]);
          }

          if (isset($verification) && $verification) {
            $temp = $this->items[$j];
            $this->items[$j] = $this->items[$i];
            $this->items[$i] = $temp;
          }
        }
      }
    }

    $page = $params['page'] ?? 1;
    $perPage = $params['perPage'] ?? 32;

    return $this->paginate($page, $perPage);
  }

	/**
	 * Parse all repository data into a better format.
	 *
	 * @param $data The data to be parsed.
	 * @return object A new location object.
	 */
  public function parse($data): object
  {
    @[$lat1, $long1] = explode(',', request()->get('coords'));

    if (count($data) == 4) {
      [$name, $lat2, $long2, $price] = $data;
    } else {
      [$name, ,$lat2, $long2, $price] = $data;

    }
    $distance = is_numeric($lat1) && is_numeric($lat2) ? $this->getDistance($lat1, $long1, $lat2, $long2) : 'unknown';

    return new Location($name, $lat ?? 0, $long ?? 0, $price, $distance);
  }

  private function orderByProximity(Location $location1, Location $location2): bool
  {
    return (float) $location1->getDistance() > (float) $location2->getDistance();
  }

  private function orderByPrice(Location $location1, Location $location2): bool
  {
    return  (float) $location1->getPrice() > (float) $location2->getPrice();
  }

	/**
	 * Returns an estimated distance between two coordinates.
	 *
	 * @param float $latitudeFrom Latitude from user.
	 * @param float $longitudeFrom Longitude from user.
	 * @param float $latitudeTo Latitude form the destination.
	 * @param float $longitudeTo Longitude form the destination.
	 * @return float The estimated distance between the two points
	 */
  private function getDistance(float $latitudeFrom, float $longitudeFrom, float $latitudeTo, float $longitudeTo): float
  {
		// convert from degrees to radians
		$latFrom = deg2rad($latitudeFrom);
		$lonFrom = deg2rad($longitudeFrom);
		$latTo = deg2rad($latitudeTo);
		$lonTo = deg2rad($longitudeTo);

		$lonDelta = $lonTo - $lonFrom;
		$a = pow(cos($latTo) * sin($lonDelta), 2) +
			pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
		$b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

		$angle = atan2(sqrt($a), $b);
		return $angle * 6371000 / 1000; // the earth radius
  }
}