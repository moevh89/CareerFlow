# Atlas Journal

## 2024-07-08 - Eigener Autoloader statt Composer

**Learning:** Entgegen üblicher PHP-Projekte (und internem Memory) verwendet dieses Projekt keinen Composer, sondern einen eigenen Autoloader (`public/index.php`). Ein `composer install` ist daher weder möglich noch nötig.

**Action:** In der Installationsanleitung (README) explizit erwähnen, dass kein Composer benötigt wird, um Verwirrung bei neuen Entwicklern zu vermeiden.

## 2024-07-11 - Lokales SQLite Setup vs MySQL Setup.php

**Learning:** Die Web-Oberfläche `setup.php` unterstützt ausschließlich MariaDB/MySQL. Das Projekt leitet User ohne eingerichtete Datenbank zwar dorthin um, aber für lokale SQLite-Umgebungen schlägt dies fehl. Lokale SQLite-Datenbanken müssen stattdessen zwingend über ein PHP-CLI-Skript initialisiert werden, indem die Klassen (`Dotenv.php`, `Database.php`, `Migrator.php`) explizit geladen werden und `App\Core\Migrator::migrate()` aufgerufen wird, nachdem `.env` geladen und der `data/` Ordner erstellt wurde.

**Action:** In der README (und künftigen Setup-Dokumentationen) explizit das CLI-Kommando zur SQLite-Initialisierung für die lokale Entwicklung aufnehmen, damit Entwickler nicht fälschlicherweise in der MySQL-Maske von `setup.php` stranden.
