# Atlas Journal

## 2024-07-08 - Eigener Autoloader statt Composer

**Learning:** Entgegen üblicher PHP-Projekte (und internem Memory) verwendet dieses Projekt keinen Composer, sondern einen eigenen Autoloader (`public/index.php`). Ein `composer install` ist daher weder möglich noch nötig.

**Action:** In der Installationsanleitung (README) explizit erwähnen, dass kein Composer benötigt wird, um Verwirrung bei neuen Entwicklern zu vermeiden.

## 2026-07-18 - SQLite Setup Einschränkungen

**Learning:** Das webbasierte Setup (`setup.php`) unterstützt ausschließlich MySQL/MariaDB. Die Initialisierung der lokalen SQLite-Datenbank erfordert die Ausführung der Methode `App\Core\Migrator::migrate()` über ein PHP CLI-Skript.

**Action:** Stelle sicher, dass die Setup-Anleitungen für die lokale Entwicklung immer den manuellen SQLite-Migrationsschritt mittels PHP CLI dokumentieren.
