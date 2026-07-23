# Atlas Journal

## 2024-07-08 - Eigener Autoloader statt Composer

**Learning:** Entgegen üblicher PHP-Projekte (und internem Memory) verwendet dieses Projekt keinen Composer, sondern einen eigenen Autoloader (`public/index.php`). Ein `composer install` ist daher weder möglich noch nötig.

**Action:** In der Installationsanleitung (README) explizit erwähnen, dass kein Composer benötigt wird, um Verwirrung bei neuen Entwicklern zu vermeiden.

## 2026-07-23 - SQLite Setup

**Learning:** Der webbasierte Setup-Prozess (`/setup.php`) unterstützt ausschließlich MySQL/MariaDB. Für die lokale Entwicklung mit SQLite muss die Datenbank über einen CLI-Befehl initialisiert werden, da sonst die automatische Weiterleitung zu `setup.php` fehlschlägt oder keine Tabellen angelegt werden.

**Action:** Die `README.md` muss den korrekten CLI-Befehl für die SQLite-Migration explizit im Abschnitt für die lokale Entwicklung anführen.
