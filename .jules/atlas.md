# Atlas Journal

## 2024-07-08 - Eigener Autoloader statt Composer

**Learning:** Entgegen üblicher PHP-Projekte (und internem Memory) verwendet dieses Projekt keinen Composer, sondern einen eigenen Autoloader (`public/index.php`). Ein `composer install` ist daher weder möglich noch nötig.

**Action:** In der Installationsanleitung (README) explizit erwähnen, dass kein Composer benötigt wird, um Verwirrung bei neuen Entwicklern zu vermeiden.

## 2024-07-08 - Lokale SQLite-Datenbank und setup.php

**Learning:** Die Weboberfläche zur Einrichtung (`setup.php`) ist ausschließlich für MySQL/MariaDB konzipiert. Bei der lokalen Entwicklung mit SQLite wird man in eine Endlosschleife zwischen `/` und `/setup.php` geschickt oder kann die Datenbank nicht über das Web-UI initialisieren. Die SQLite-Datenbank muss über ein CLI-Skript migriert werden, wofür die Autoloader-Klassen und `Dotenv` explizit geladen werden müssen.

**Action:** In der Installationsanleitung (README) für die lokale Entwicklung explizit den PHP CLI-Befehl zur Migration der SQLite-Datenbank (`App\Core\Migrator::migrate()`) dokumentieren.
