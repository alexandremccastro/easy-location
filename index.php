<?php

require_once __DIR__ . '/vendor/autoload.php';

use Core\App;
use Core\Helper\Globals\Server;

App::serve(Server::getRequestURI());
