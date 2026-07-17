# Atlas Journal

## 2024-07-08 - Eigener Autoloader statt Composer

**Learning:** Entgegen üblicher PHP-Projekte (und internem Memory) verwendet dieses Projekt keinen Composer, sondern einen eigenen Autoloader (`public/index.php`). Ein `composer install` ist daher weder möglich noch nötig.

**Action:** In der Installationsanleitung (README) explizit erwähnen, dass kein Composer benötigt wird, um Verwirrung bei neuen Entwicklern zu vermeiden.

## 2024-07-17 - Manuelles SQLite Setup für lokale Entwicklung

**Learning:** Die Web-basierte Installationsroutine (`setup.php`) unterstützt ausschließlich MariaDB/MySQL. Das standardmäßige SQLite-Setup für die lokale Entwicklung (in `.env.example` definiert) kann nicht über den Browser eingerichtet werden und führt zu einer Endlosschleife zum `/setup.php`, wenn die Datenbank nicht existiert. Die SQLite-Datenbank muss manuell initialisiert werden.

**Action:** In der README.md muss ein expliziter Schritt zur manuellen Initialisierung der SQLite-Datenbank via PHP-CLI (inklusive Anlegen des `data/` Verzeichnisses) hinzugefügt werden.
