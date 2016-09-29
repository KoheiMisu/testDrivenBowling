<?php

require_once('./vendor/autoload.php');

use App\Bird;

$Bird = new Bird();
echo $Bird->fly().PHP_EOL;
