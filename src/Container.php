<?php

declare(strict_types=1);

namespace Eventum;

use Eventum\Repository\AgendaRepository;
use Eventum\Repository\EventRepository;
use Eventum\Repository\LocationRepository;

class Container
{
    private static function getDatabase(): \PDO
    {
        $dsn = \getenv("DB_DSN");
        $user = \getenv("DB_USER");
        $pass = \getenv("DB_PASS");

        if ($dsn === false || $user === false || $pass === false) {
            throw new \RuntimeException("ENV variables DB_DSN, DB_USER and DB_PASS must all be set!");
        }

        return new \PDO($dsn, $user, $pass);
    }

    public static function getEventRepository(): EventRepository
    {
        return new EventRepository(self::getDatabase());
    }

    public static function getLocationRepository(): LocationRepository
    {
        return new LocationRepository(self::getDatabase());
    }

    public static function getAgendaRepository(): AgendaRepository
    {
        return new AgendaRepository(
            self::getDatabase(),
        );
    }
}
