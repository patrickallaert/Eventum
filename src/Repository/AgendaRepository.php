<?php

declare(strict_types=1);

namespace Eventum\Repository;

use Eventum\Entity\AgendaEntry;
use Eventum\Enum\Language;

readonly class AgendaRepository
{
    public function __construct(
        private EventRepository $eventRepository,
        private LocationRepository $locationRepository,
    ) {
    }

    /**
     * @return AgendaEntry[]
     */
    public function load(Language $lang): array
    {
        $results = [];

        foreach ($this->eventRepository->loadAll($lang) as $event) {
            $results[] = new AgendaEntry($event, $this->locationRepository->loadById($event->locationId));
        }

        return $results;
    }
}
