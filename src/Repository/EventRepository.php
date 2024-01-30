<?php

declare(strict_types=1);

namespace Eventum\Repository;

use Eventum\Entity\Event;
use Eventum\Entity\TranslatedString;
use Eventum\Enum\Language;

readonly class EventRepository
{
    public function __construct(private \PDO $db)
    {
    }

    public function resetData(): void
    {
        $this->db->exec(
            <<<'SQL'
            DROP VIEW IF EXISTS event_vw;
            DROP TABLE IF EXISTS event_translation;
            DROP TABLE IF EXISTS event;

            CREATE TABLE event (
                id SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                date DATETIME NOT NULL,
                location_id SMALLINT UNSIGNED
            );

            CREATE TABLE event_translation  (
                id SMALLINT UNSIGNED,
                language CHAR(2) NOT NULL,
                title VARCHAR(255) NOT NULL,
                FOREIGN KEY (id) REFERENCES event(id),
                PRIMARY KEY (id, language)
            );

            CREATE VIEW event_vw AS
            SELECT e.id, e.date, e.location_id, et.language, et.title
            FROM event e
            INNER JOIN event_translation et ON e.id = et.id
            ORDER BY e.date;
            SQL
        );
    }

    public function create(int $locationId, \DateTimeInterface $date, TranslatedString $title): int
    {
        $date = $this->db->quote($date->format("Y-m-d H:i:s"));

        $this->db->exec("INSERT INTO event (date, location_id) VALUES ($date, $locationId)");

        $eventId = (int) $this->db->lastInsertId();

        foreach (Language::cases() as $lang) {
            $language = $this->db->quote($lang->value);
            $value = $this->db->quote($title->in($lang));
            $this->db->exec("INSERT INTO event_translation (id, language, title) VALUES ($eventId, $language, $value)");
        }

        return $eventId;
    }

    /**
     * @param array{date:string,title:string,location_id:int} $event
     */
    private static function buildEvent(int $id, array $event): Event
    {
        return new Event($id, new \DateTimeImmutable($event["date"]), $event["title"], $event["location_id"]);
    }

    public function loadById(int $id, Language $lang): Event
    {
        foreach (
            $this->db->query(
                "SELECT date, location_id, title FROM event_vw WHERE language = '$lang->value' AND id = $id",
                \PDO::FETCH_ASSOC,
            ) as $event) {
            return self::buildEvent($id, $event);
        }

        throw new \RuntimeException("Event with id: $id not found");
    }

    /**
     * @return Event[]
     */
    private function loadEvents(?int $locationId, Language $lang): array
    {
        $results = [];

        foreach (
            $this->db->query(
                "SELECT id, date, location_id, title FROM event_vw WHERE language = '$lang->value' " .
                ($locationId !== null ? "AND location_id = $locationId " : ""),
                \PDO::FETCH_ASSOC,
            ) as $event) {
            $results[] = self::buildEvent($event["id"], $event);
        }

        return $results;
    }

    /**
     * @return Event[]
     */
    public function loadAllByLocationId(int $locationId, Language $lang): array
    {
        return $this->loadEvents($locationId, $lang);
    }

    /**
     * @return Event[]
     */
    public function loadAll(Language $lang): array
    {
        return $this->loadEvents(null, $lang);
    }

    public function reschedule(int $id, \DateTimeInterface $date): void
    {
        $date = $this->db->quote($date->format("Y-m-d H:i:s"));

        $this->db->exec("UPDATE event SET date = $date WHERE id = $id");
    }
}
