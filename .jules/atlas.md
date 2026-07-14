# Atlas Journal

## 2024-07-08 - Eigener Autoloader statt Composer

**Learning:** Entgegen üblicher PHP-Projekte (und internem Memory) verwendet dieses Projekt keinen Composer, sondern einen eigenen Autoloader (`public/index.php`). Ein `composer install` ist daher weder möglich noch nötig.

**Action:** In der Installationsanleitung (README) explizit erwähnen, dass kein Composer benötigt wird, um Verwirrung bei neuen Entwicklern zu vermeiden.

## 2024-07-14 - SQLite Setup via CLI

**Learning:** Das webbasierte Setup (`setup.php`) unterstützt ausschließlich MySQL/MariaDB. Wenn das Projekt mit der Standard-`.env.example` (SQLite) gestartet wird und die Datenbanktabellen nicht existieren, leitet das System automatisch zum Setup um. Dort würde ein lokaler Entwickler fälschlicherweise versuchen, SQLite-Zugangsdaten einzugeben, oder gezwungen werden, seine `.env` auf MySQL zu überschreiben.

**Action:** Für die lokale Entwicklung mit SQLite muss zwingend dokumentiert werden, dass die Datenbank-Migrationen manuell via PHP CLI ausgeführt werden müssen (durch Aufruf von `App\Core\Migrator::migrate()`), *bevor* die Anwendung im Browser aufgerufen wird.
