# Atlas Journal

## 2024-07-08 - Eigener Autoloader statt Composer

**Learning:** Entgegen üblicher PHP-Projekte (und internem Memory) verwendet dieses Projekt keinen Composer, sondern einen eigenen Autoloader (`public/index.php`). Ein `composer install` ist daher weder möglich noch nötig.

**Action:** In der Installationsanleitung (README) explizit erwähnen, dass kein Composer benötigt wird, um Verwirrung bei neuen Entwicklern zu vermeiden.

## 2024-07-19 - SQLite Migration für lokale Entwicklung

**Learning:** Der webbasierte Setup-Prozess (`setup.php`) unterstützt ausschließlich MariaDB/MySQL. Bei der lokalen Entwicklung mit SQLite muss die Datenbank initial über das CLI angelegt und migriert werden. Andernfalls scheitert die Nutzung der Applikation, ohne dass das Setup funktioniert.

**Action:** In der README.md muss bei der lokalen Entwicklung ausdrücklich die Ausführung von `php -r "require 'src/Core/Dotenv.php'; require 'src/Core/Database.php'; require 'src/Core/Migrator.php'; App\Core\Dotenv::load('.env'); App\Core\Migrator::migrate();"` erwähnt werden, damit neue Contributors direkt startklar sind.
