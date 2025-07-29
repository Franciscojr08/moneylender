<?php

date_default_timezone_set('America/Manaus');

use MoneyLender\Core\Router;

require_once __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

set_include_path(get_include_path().PATH_SEPARATOR.__DIR__.'/src/Views/');

$oRouter = new Router();
$oRouter->iniciar();