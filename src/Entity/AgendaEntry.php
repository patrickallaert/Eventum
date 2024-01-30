<?php

declare(strict_types=1);

namespace Eventum\Entity;

readonly class AgendaEntry
{
    public function __construct(
        public Event $event,
        public Location $location,
    ) {
    }
}
