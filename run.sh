set -e

# 1. Load data in the database
php bin/insertData.php

# 2. Query the database

# /events
php bin/loadAllEvents.php fr
php bin/loadAllEvents.php nl

php bin/rescheduleEvent.php 2 "2024-10-31 23:00"

# /event/2
php bin/loadEvent.php 2 fr
php bin/loadEvent.php 2 nl

# /location/1
php bin/loadLocation.php 1

# /location/1/events
php bin/loadEventsByLocation.php 1 fr
php bin/loadEventsByLocation.php 1 nl

# /location/2
php bin/loadLocation.php 2

# /location/2/events
php bin/loadEventsByLocation.php 2 fr
php bin/loadEventsByLocation.php 2 nl

# /agenda
php bin/loadAgenda.php fr
php bin/loadAgenda.php nl
