<?php

namespace App\Controller;

use Core\Common\View;

class HomeController
{
  public function home(): void
  {
    $name = 'Hello';

    View::render('home', compact('name'));
  }

  public function edit($id): void
  {
    $name = 'This is a test with a param' . $id;

    View::render('home', compact('name'));
  }
}
