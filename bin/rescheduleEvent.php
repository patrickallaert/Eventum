<?php

require "vendor/autoload.php";

use Eventum\Container;

$eventRepository = Container::getEventRepository();

$eventRepository->reschedule(
    $argv[1],
    new DateTimeImmutable($argv[2]),
);
