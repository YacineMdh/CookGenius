<?php

require_once '../src/Utils/Autoloader.php';

require_once '../vendor/autoload.php';

use App\Utils\Autoloader;
use App\Core\Kernel;

Autoloader::register();


$kernel = new Kernel();
$kernel->run();


