# Atlas Journal

## 2024-07-08 - Eigener Autoloader statt Composer

**Learning:** Entgegen üblicher PHP-Projekte (und internem Memory) verwendet dieses Projekt keinen Composer, sondern einen eigenen Autoloader (`public/index.php`). Ein `composer install` ist daher weder möglich noch nötig.

**Action:** In der Installationsanleitung (README) explizit erwähnen, dass kein Composer benötigt wird, um Verwirrung bei neuen Entwicklern zu vermeiden.

## 2026-07-22 - Manuelle SQLite Migration

**Learning:** Das webbasierte Setup (`/setup.php`) unterstützt ausschließlich MySQL/MariaDB. Bei lokaler Entwicklung mit SQLite muss die Datenbank initial manuell über die PHP-CLI migriert werden.

**Action:** Immer die CLI-Befehle zur Datenbankmigration in der Installationsanleitung dokumentieren, da das Frontend-Setup dies nicht abdeckt.
