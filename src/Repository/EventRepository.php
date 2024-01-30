<?php

declare(strict_types=1);

namespace Eventum\Repository;

use Eventum\Entity\Event;
use Eventum\Entity\TranslatedString;
use Eventum\Enum\Language;

class EventRepository
{
    use LoadSaveDataTrait;

    public function __construct()
    {
        $this->filename = __DIR__ . "/../../var/data/json/events.json";
    }

    public function create(int $locationId, \DateTimeInterface $date, TranslatedString $title): int
    {
        $events = $this->loadData();

        $titles = [];

        foreach (Language::cases() as $language) {
            $titles[$language->value] = $title->in($language);
        }

        $events[] = [
            "locationId" => $locationId,
            "date" => $date->format("c"),
            "title" => $titles,
        ];

        $this->saveData($events);

        return \count($events);
    }

    /**
     * @param array{date:string,title:array<string,string>,locationId:int} $event
     */
    private static function buildEvent(int $id, array $event, Language $lang): Event
    {
        return new Event($id, new \DateTimeImmutable($event["date"]), $event["title"][$lang->value], $event["locationId"]);
    }

    public function loadById(int $id, Language $lang): Event
    {
        $data = $this->loadData();

        if (!isset($data[$id - 1])) {
            throw new \RuntimeException("Event with id: $id not found");
        }

        return self::buildEvent($id, $data[$id - 1], $lang);
    }

    /**
     * @return Event[]
     */
    private function loadEvents(?int $locationId, Language $lang): array
    {
        $results = [];

        foreach ($this->loadData() as $id => $event) {
            if ($locationId === null || $event["locationId"] === $locationId) {
                $results[] = self::buildEvent($id + 1, $event, $lang);
            }
        }

        \usort($results, static function (Event $a, Event $b): int {
            // @phan-suppress-next-line PhanPluginComparisonObjectOrdering
            return $a->date <=> $b->date;
        });

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
        $events = $this->loadData();

        if (!isset($events[$id - 1])) {
            throw new \RuntimeException("Event with id: $id not found");
        }

        $events[$id - 1]["date"] = $date->format("c");

        $this->saveData($events);
    }
}
