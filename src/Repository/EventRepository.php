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
        $this->filename = __DIR__ . "/../../var/data/xml/events.xml";
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

        return new \SimpleXMLElement("<events/>");
    }

    public function create(int $locationId, \DateTimeInterface $date, TranslatedString $title): int
    {
        $events = $this->loadData();

        $event = $events->addChild("event");
        $event->addChild("locationId", (string) $locationId);
        $event->addChild("date", $date->format("c"));

        $titles = $event->addChild("titles");

        foreach (Language::cases() as $language) {
            $titles->addChild("title", $title->in($language))->addAttribute("language", $language->value);
        }

        $this->saveData($events);

        return \count($events->children());
    }

    private static function buildEvent(int $id, \SimpleXMLElement $event, Language $lang): Event
    {
        return new Event(
            $id,
            new \DateTimeImmutable((string) $event->date),
            (string) $event->titles->xpath("title[@language='{$lang->value}']")[0], (int) $event->locationId,
        );
    }

    public function loadById(int $id, Language $lang): Event
    {
        $currentId = 0;

        foreach ($this->loadData()->event as $event) {
            if (++$currentId === $id) {
                return self::buildEvent($id, $event, $lang);
            }
        }

        throw new \RuntimeException("Event with id: $id not found");
    }

    /**
     * @return Event[]
     */
    private function loadEvents(?int $locationId, Language $lang): array
    {
        $results = [];

        $id = 0;

        foreach ($this->loadData()->children() as $event) {
            ++$id;
            if ($locationId === null || (int) $event->locationId === $locationId) {
                $results[] = self::buildEvent($id, $event, $lang);
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
        $currentId = 0;

        $data = $this->loadData();

        foreach ($data->event as $event) {
            if (++$currentId === $id) {
                $event->date = $date->format("c");
                $this->saveData($data);
                return;
            }
        }

        throw new \RuntimeException("Event with id: $id not found");
    }
}
