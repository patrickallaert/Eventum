# Eventum

A backend-agnostic and framework-neutral PHP API that serves as an example for event and location management.

## Usage

### Location repository

```php
$locationRepository = Container::getLocationRepository();

// Create a new Location:
$locationId = $locationRepository->create("Pairi Daiza", "Domaine de Cambron, 7940 Brugelette");

// Load a Location by its ID:
$location = $locationRepository->loadById(1);

echo <<<EOF
Location ID:$location->id
Location name: $location->name
Location address: $location->address
EOF;

```

### Event repository

```php
$eventRepository = Container::getEventRepository();

// Create a new Event:
$eventRepository->create(
    $locationId,
    new DateTimeImmutable("2024-12-31 20:00"),
    new TranslatedString(
        fr: "Nuit de la Saint-Sylvestre",
        nl: "Oudejaarsavond",
    ),
);

// Load an Event by its ID using French:
$event = $eventRepository->loadById(10, Language::French);

echo <<<EOF
Event ID: $event->id
Event date: {$event->date->format("Y-m-d H:i")}
Event title: $event->title
EOF;

// Load all Events using Dutch:
$events = $eventRepository->loadAll(Language::Dutch);

// Load all Events happening at a specific LocationID using French:
$events = $eventRepository->loadAllByLocationId(3, Language::French);

// Reschedule an Event by its ID:
$eventRepository->reschedule(7, new DateTimeImmutable("2024-04-01 12:00"));
```

### Agenda repository

```php
$agendaRepository = Container::getAgendaRepository();

// Retrieve all Agenda entries using Dutch:
$agendaEntries = $agendaRepository->load(Language::Dutch);
```

An `AgendaEntry` is defined in [src/Entity/AgendaEntry.php](src/Entity/AgendaEntry.php) and is the composition of an `Event` and a `Location`.
