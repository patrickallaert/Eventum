<?php

require "vendor/autoload.php";

use Eventum\Container;
use Eventum\Enum\Language;

$eventRepository = Container::getEventRepository();

foreach (
    $eventRepository->loadAllByLocationId(
        $argv[1],
        Language::from($argv[2]),
    ) as $event
) {
    echo "#$event->id [{$event->date->format("Y-m-d H:i")}] $event->title\n";
}
