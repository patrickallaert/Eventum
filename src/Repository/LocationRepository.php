<?php

declare(strict_types=1);

namespace Eventum\Repository;

use Eventum\Entity\Location;

class LocationRepository
{
    use LoadSaveDataTrait;

    public function __construct()
    {
        $this->filename = __DIR__ . "/../../var/data/xml/locations.xml";
    }

    private function loadData(): \SimpleXMLElement
    {
        if (\file_exists($this->filename)) {
            $fileData = \simplexml_load_file($this->filename);

            if ($fileData === false) {
                throw new \RuntimeException("A problem occurred loading the file $this->filename");
            }

            return $fileData;
        }

        return new \SimpleXMLElement("<locations/>");
    }

    public function create(string $name, string $address): int
    {
        $locations = $this->loadData();

        $location = $locations->addChild("location");
        $location->addChild("name", $name);
        $location->addChild("address", $address);

        $this->saveData($locations);

        return \count($locations);
    }

    public function loadById(int $id): Location
    {
        $currentId = 0;

        foreach ($this->loadData()->location as $location) {
            if (++$currentId === $id) {
                return new Location($id, (string) $location->name, (string) $location->address);
            }
        }

        throw new \RuntimeException("Location with id: $id not found");
    }
}
