<?php

namespace Core\Database;

abstract class Repository
{
	/**
	 * @var array The items available in the repository.
	 */
  protected array $items = [];

  public abstract function filter($params = []);
  public abstract function parse($data): object;

	/**
	 * Maps all repository items and transform them in parsed collection.
	 *
	 * @return array All items parsed.
	 */
  public function collection(): array
  {
    return array_map(function ($item) {
      return $this->parse($item);
    }, $this->items);
  }

	/**
	 * Paginates all items from the repository.
	 *
	 * @param int $page The current page.
	 * @param int $perPage The quantity of items per page.
	 * @return array All items paginated.
	 */
  public function paginate(int $page = 1, int $perPage = 10): array
  {
    $data = array_slice($this->items, ($page - 1) * $perPage, $perPage);
    $total = count($this->items);
    $totalPages = ceil($total / $perPage);

    return [
      'data' => $data,
      'pagination' => [
        'page' => $page,
        'perPage' => $perPage,
        'total' => $total,
        'totalPages' => $totalPages
      ]
    ];
  }
}