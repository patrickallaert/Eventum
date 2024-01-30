<?php

require "vendor/autoload.php";

use Eventum\Container;
use Eventum\Enum\Language;

$eventRepository = Container::getEventRepository();

foreach (
    $eventRepository->loadAll(
        Language::from($argv[1]),
    ) as $event
) {
    echo "#$event->id [{$event->date->format("Y-m-d H:i")}] $event->title\n";
}
