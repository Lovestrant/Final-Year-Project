<?php

require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

$serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/finalyearproject-86a41-firebase-adminsdk-r25ls-9fd3a9c8f9.json');

$factory = (new Factory)
->withServiceAccount($serviceAccount)
->withDatabaseUri('https://finalyearproject-86a41-default-rtdb.firebaseio.com');

//Initialize the realTime database
$database = $factory->createDatabase();

?>