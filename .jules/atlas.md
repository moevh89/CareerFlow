# Atlas Journal

## 2024-07-08 - Eigener Autoloader statt Composer

**Learning:** Entgegen üblicher PHP-Projekte (und internem Memory) verwendet dieses Projekt keinen Composer, sondern einen eigenen Autoloader (`public/index.php`). Ein `composer install` ist daher weder möglich noch nötig.

**Action:** In der Installationsanleitung (README) explizit erwähnen, dass kein Composer benötigt wird, um Verwirrung bei neuen Entwicklern zu vermeiden.

## 2024-07-20 - SQLite Lokales Setup

**Learning:** Das webbasierte Setup (`setup.php`) unterstützt ausschließlich MySQL/MariaDB. Lokale SQLite-Datenbanken können nicht über den Browser initialisiert werden, sondern müssen manuell über das PHP CLI migriert werden.

**Action:** Bei der Erwähnung des lokalen SQLite-Setups immer den PHP CLI Migrationsbefehl (`php -r "require 'src/Core/Dotenv.php'; require 'src/Core/Database.php'; require 'src/Core/Migrator.php'; App\Core\Dotenv::load('.env'); App\Core\Migrator::migrate();"`) dokumentieren, um Verwirrung bei den Nutzern zu vermeiden.
