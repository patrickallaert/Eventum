<?php

require "vendor/autoload.php";

use Eventum\Container;

$locationRepository = Container::getLocationRepository();

$location = $locationRepository->loadById($argv[1]);

echo "#$location->id $location->name ($location->address)\n";
