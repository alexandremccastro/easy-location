<?php

namespace Core\Database;

abstract class Repository
{
  protected array $items = [];

  public abstract function filter($params = []);
  public abstract function parse($data): object;

  public function collection(): array
  {
    return array_map(function ($item) {
      return $this->parse($item);
    }, $this->items);
  }

  public function paginate($page = 1, $perPage = 10): array
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