# Atlas Journal

## 2024-07-08 - Eigener Autoloader statt Composer

**Learning:** Entgegen üblicher PHP-Projekte (und internem Memory) verwendet dieses Projekt keinen Composer, sondern einen eigenen Autoloader (`public/index.php`). Ein `composer install` ist daher weder möglich noch nötig.

**Action:** In der Installationsanleitung (README) explizit erwähnen, dass kein Composer benötigt wird, um Verwirrung bei neuen Entwicklern zu vermeiden.

## 2024-07-24 - Setup.php nur für MySQL

**Learning:** Das webbasierte Setup (setup.php) unterstützt ausschließlich MySQL/MariaDB. Für die lokale Entwicklung mit SQLite muss die Datenbank manuell über das PHP CLI initialisiert werden.

**Action:** In der Dokumentation sicherstellen, dass Entwickler bei lokaler SQLite-Nutzung den manuellen Migrationsbefehl anstelle des Setups im Browser verwenden.
