<?php

use App\Core\App;

session_start();
require '../vendor/autoload.php';

define("URL_BASE", 'http://localhost:8080/');

$app = new App();
