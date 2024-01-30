<?php

declare(strict_types=1);

namespace Eventum\Entity;

readonly class Location
{
    public function __construct(
        public int $id,
        public string $name,
        public string $address,
    ) {
    }
}
