<?php

require "vendor/autoload.php";

use Eventum\Container;
use Eventum\Enum\Language;

$eventRepository = Container::getEventRepository();

$event = $eventRepository->loadById(
    $argv[1],
    Language::from($argv[2]),
);

echo "#$event->id {$event->date->format("Y-m-d H:i")} $event->title\n";
