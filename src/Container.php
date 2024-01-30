<?php

declare(strict_types=1);

namespace Eventum;

use Eventum\Repository\AgendaRepository;
use Eventum\Repository\EventRepository;
use Eventum\Repository\LocationRepository;

class Container
{
    public static function getEventRepository(): EventRepository
    {
        return new EventRepository();
    }

    public static function getLocationRepository(): LocationRepository
    {
        return new LocationRepository();
    }

    public static function getAgendaRepository(): AgendaRepository
    {
        return new AgendaRepository(
            self::getEventRepository(),
            self::getLocationRepository(),
        );
    }
}
