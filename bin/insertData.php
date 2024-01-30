<?php

require "vendor/autoload.php";

use Eventum\Container;
use Eventum\Entity\TranslatedString;

$locationRepository = Container::getLocationRepository();
$eventRepository = Container::getEventRepository();

$eventRepository->resetData();
$locationRepository->resetData();

$locationId = $locationRepository->create("Pairi Daiza", "Domaine de Cambron, 7940 Brugelette");

$eventRepository->create(
    $locationId,
    new DateTimeImmutable("2024-12-31 20:00"),
    new TranslatedString(
        fr: "Nuit de la Saint-Sylvestre",
        nl: "Oudejaarsavond",
    ),
);
$eventRepository->create(
    $locationId,
    new DateTimeImmutable("2024-10-31 20:00"),
    new TranslatedString(
        fr: "Fête d'Halloween à Pairi Daiza",
        nl: "Halloween Feest in Pairi Daiza",
    ),
);

$locationId = $locationRepository->create("Walibi", "Boulevard de l'Europe 100, 1300 Wavre");

$eventRepository->create(
    $locationId,
    new DateTimeImmutable("2024-06-01 12:00"),
    new TranslatedString(
        fr: "Fête du Poisson d'Avril",
        nl: "Aprilgrap feest",
    ),
);
$eventRepository->create(
    $locationId,
    new DateTimeImmutable("2024-06-30 23:00"),
    new TranslatedString(
        fr: "Fête de fin avril à Walibi",
        nl: "Eind april Feest in Walibi",
    ),
);
$eventRepository->create(
    $locationId,
    new DateTimeImmutable("2024-10-31 20:30"),
    new TranslatedString(
        fr: "Fête d'Halloween à Walibi",
        nl: "Halloween Feest in Walibi",
    ),
);

$locationId = $locationRepository->create("Grand-Place de Binche", "Grand-Place, 7130 Binche");

$eventRepository->create(
    $locationId,
    new DateTimeImmutable("2024-02-28 08:00"),
    new TranslatedString(
        fr: "Carnaval de Binche",
        nl: "Carnaval van Binche",
    ),
);
$eventRepository->create(
    $locationId,
    new DateTimeImmutable("2024-12-10 12:00"),
    new TranslatedString(
        fr: "Marché de Noël de Binche",
        nl: "Kerstmarkt Binche",
    ),
);
$eventRepository->create(
    $locationId,
    new DateTimeImmutable("2024-08-10 12:00"),
    new TranslatedString(
        fr: "Festival de Musique Folklorique de Binche",
        nl: "Folkloremuziekfestival Binche",
    ),
);
$eventRepository->create(
    $locationId,
    new DateTimeImmutable("2024-07-01 10:00"),
    new TranslatedString(
        fr: "Concours de Sculptures de Sable",
        nl: "Zandsculptuurwedstrijd",
    ),
);

$locationId = $locationRepository->create("Brussels Expo", "Place de Belgique 1, 1020 Bruxelles");

$eventRepository->create(
    $locationId,
    new DateTimeImmutable("2024-01-19 10:00"),
    new TranslatedString(
        fr: "Salon de l'Automobile de Bruxelles",
        nl: "AutoSalon van Brussel",
    ),
);
$eventRepository->create(
    $locationId,
    new DateTimeImmutable("2024-03-05 13:00"),
    new TranslatedString(
        fr: "Foire du Livre de Bruxelles",
        nl: "Boekenbeurs Brussel",
    ),
);
$eventRepository->create(
    $locationId,
    new DateTimeImmutable("2024-11-15 09:00"),
    new TranslatedString(
        fr: "Salon de l'Alimentation de Bruxelles",
        nl: "Voedingssalon Brussel",
    ),
);
