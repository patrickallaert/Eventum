<?php

declare(strict_types=1);

namespace Eventum\Repository;

use Eventum\Entity\Location;

readonly class LocationRepository
{
    public function __construct(private \PDO $db)
    {
    }

    public function resetData(): void
    {
        $this->db->exec(
            <<<'SQL'
            DROP TABLE IF EXISTS location;

            CREATE TABLE location (
                id SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(255) NOT NULL,
                address VARCHAR(255) NOT NULL
            );

            ALTER TABLE event ADD FOREIGN KEY (location_id) REFERENCES location(id);
            SQL
        );
    }

    public function create(string $name, string $address): int
    {
        $name = $this->db->quote($name);
        $address = $this->db->quote($address);

        $this->db->exec("INSERT INTO location (name, address) VALUES ($name, $address)");

        return (int) $this->db->lastInsertId();
    }

    public function loadById(int $id): Location
    {
        foreach (
            $this->db->query(
                "SELECT name, address FROM location WHERE id = $id",
                \PDO::FETCH_ASSOC,
            ) as $event) {
            return new Location($id, $event["name"], $event["address"]);
        }

        throw new \RuntimeException("Location with id: $id not found");
    }
}
