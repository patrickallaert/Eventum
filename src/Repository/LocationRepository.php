<?php

declare(strict_types=1);

namespace Eventum\Repository;

use Eventum\Entity\Location;

class LocationRepository
{
    use LoadSaveDataTrait;

    public function __construct()
    {
        $this->filename = __DIR__ . "/../../var/data/json/locations.json";
    }

    public function create(string $name, string $address): int
    {
        $locations = $this->loadData();

        $locations[] = [
            "name" => $name,
            "address" => $address,
        ];

        $this->saveData($locations);

        return \count($locations);
    }

    public function loadById(int $id): Location
    {
        $loadData = $this->loadData();

        if (!isset($loadData[$id - 1])) {
            throw new \RuntimeException("Location with id: $id not found");
        }

        $locationData = $loadData[$id - 1];

        return new Location($id, $locationData["name"], $locationData["address"]);
    }
}
