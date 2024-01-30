<?php

declare(strict_types=1);

namespace Eventum\Entity;

readonly class Event
{
    public function __construct(
        public int $id,
        public \DateTimeImmutable $date,
        public string $title,
        public int $locationId,
    ) {
    }
}
