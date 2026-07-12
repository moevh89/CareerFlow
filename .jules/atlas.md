# Atlas Journal

## 2024-07-08 - Eigener Autoloader statt Composer

**Learning:** Entgegen üblicher PHP-Projekte (und internem Memory) verwendet dieses Projekt keinen Composer, sondern einen eigenen Autoloader (`public/index.php`). Ein `composer install` ist daher weder möglich noch nötig.

**Action:** In der Installationsanleitung (README) explizit erwähnen, dass kein Composer benötigt wird, um Verwirrung bei neuen Entwicklern zu vermeiden.

## 2024-07-12 - SQLite Setup für lokale Entwicklung

**Learning:** Das webbasierte Setup (`setup.php`) ist ausschließlich für MySQL/MariaDB konzipiert. Bei der lokalen Entwicklung mit SQLite muss die Datenbank manuell über ein kleines CLI-Script initialisiert werden (durch Aufruf von `App\Core\Migrator::migrate()` nach Laden von Config und Core-Klassen).

**Action:** In der README.md muss der manuelle Schritt zur SQLite-Migration für die lokale Entwicklung dokumentiert und der verwirrende Hinweis auf das webbasierte Setup in diesem Kontext entfernt werden.
