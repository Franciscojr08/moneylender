<?php

use MoneyLender\Core\Router;

require_once __DIR__ . "/vendor/autoload.php";

set_include_path(get_include_path().PATH_SEPARATOR.__DIR__.'/src/Views/');

$oRouter = new Router();
$oRouter->iniciar();