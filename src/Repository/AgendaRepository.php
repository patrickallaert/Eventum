<?php

declare(strict_types=1);

namespace Eventum\Repository;

use Eventum\Entity\AgendaEntry;
use Eventum\Entity\Event;
use Eventum\Entity\Location;
use Eventum\Enum\Language;

readonly class AgendaRepository
{
    public function __construct(private \PDO $db)
    {
    }

    /**
     * @return AgendaEntry[]
     */
    public function load(Language $lang): array
    {
        $results = [];

        foreach (
            $this->db->query(
                <<<SQL
                SELECT e.id, e.date, e.location_id, e.title, l.name, l.address
                FROM event_vw e
                INNER JOIN location l ON l.id = e.location_id
                WHERE e.language = '$lang->value'
                SQL,
                \PDO::FETCH_ASSOC,
            ) as $row) {
            $results[] = new AgendaEntry(
                new Event($row["id"], new \DateTimeImmutable($row["date"]), $row["title"], $row["location_id"]),
                new Location($row["location_id"], $row["name"], $row["address"]),
            );
        }

        return $results;
    }
}
