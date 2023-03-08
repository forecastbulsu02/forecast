<?php

require __DIR__ . '/vendor/autoload.php';

use Kreait\Firebase\Factory;

$factory = (new Factory())
    ->withProjectId('data.json')
    ->withDatabaseUri('https://forecastbulsu-c2736-default-rtdb.firebaseio.com/');

$database = $factory->createDatabase();
