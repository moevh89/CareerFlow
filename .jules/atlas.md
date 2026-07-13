# Atlas Journal

## 2024-07-08 - Eigener Autoloader statt Composer

**Learning:** Entgegen üblicher PHP-Projekte (und internem Memory) verwendet dieses Projekt keinen Composer, sondern einen eigenen Autoloader (`public/index.php`). Ein `composer install` ist daher weder möglich noch nötig.

**Action:** In der Installationsanleitung (README) explizit erwähnen, dass kein Composer benötigt wird, um Verwirrung bei neuen Entwicklern zu vermeiden.

## 2024-11-20 - Lokales SQLite Setup vs. setup.php

**Learning:** Das webbasierte Setup (`setup.php`) unterstützt ausschließlich MariaDB/MySQL. Für die lokale Entwicklung mit SQLite muss die Datenbank manuell über das CLI initialisiert werden (`App\Core\Migrator::migrate()`), andernfalls bleibt man in einer Setup-Schleife stecken, weil `setup.php` versucht, MySQL-Datenbankzugangsdaten zu erzwingen.

**Action:** In der README.md muss bei den lokalen Installationsschritten (SQLite) explizit ein PHP-CLI-Befehl zur Initialisierung der Datenbankdokumentiert werden.
