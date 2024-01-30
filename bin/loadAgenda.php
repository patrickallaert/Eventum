<?php

require "vendor/autoload.php";

use Eventum\Container;
use Eventum\Enum\Language;

$agendaRepository = Container::getAgendaRepository();

foreach (
    $agendaRepository->load(
        Language::from($argv[1])
    ) as $agendaEntry
) {
    echo "{$agendaEntry->event->date->format("Y-m-d H:i")} | {$agendaEntry->event->title}", str_repeat(" ", 50 - mb_strlen($agendaEntry->event->title)), "| {$agendaEntry->location->name} ({$agendaEntry->location->address})\n";
}
