# Atlas Journal

## 2024-07-08 - Eigener Autoloader statt Composer

**Learning:** Entgegen üblicher PHP-Projekte (und internem Memory) verwendet dieses Projekt keinen Composer, sondern einen eigenen Autoloader (`public/index.php`). Ein `composer install` ist daher weder möglich noch nötig.

**Action:** In der Installationsanleitung (README) explizit erwähnen, dass kein Composer benötigt wird, um Verwirrung bei neuen Entwicklern zu vermeiden.

## 2026-07-16 - Lokale SQLite Initialisierung

**Learning:** Das webbasierte Setup (`setup.php`) unterstützt ausschließlich MariaDB/MySQL. Die lokale SQLite-Datenbank muss manuell über das CLI initialisiert werden, was in der lokalen Entwicklung zu Verwirrung führen kann, wenn Entwickler auf `/setup.php` weitergeleitet werden.

**Action:** In der lokalen Installationsanleitung (README) den CLI-Befehl zur manuellen Initialisierung der SQLite-Datenbank ergänzen, um Entwickler vor dem fehlgeschlagenen webbasierten Setup zu bewahren.
