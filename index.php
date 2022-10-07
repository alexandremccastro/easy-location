<?php

require_once __DIR__ . '/vendor/autoload.php';

use Core\App;

App::serve($_SERVER['REQUEST_URI']);
