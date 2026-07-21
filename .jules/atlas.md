# Atlas Journal

## 2024-07-08 - Eigener Autoloader statt Composer

**Learning:** Entgegen üblicher PHP-Projekte (und internem Memory) verwendet dieses Projekt keinen Composer, sondern einen eigenen Autoloader (`public/index.php`). Ein `composer install` ist daher weder möglich noch nötig.

**Action:** In der Installationsanleitung (README) explizit erwähnen, dass kein Composer benötigt wird, um Verwirrung bei neuen Entwicklern zu vermeiden.

## 2024-07-21 - Setup-Skript vs. lokale SQLite-Initialisierung

**Learning:** Das webbasierte Setup (`setup.php`) unterstützt ausschließlich MySQL/MariaDB. Bei der Verwendung der standardmäßigen SQLite-Konfiguration für die lokale Entwicklung müssen der `data/`-Ordner manuell erstellt und die Migrationen per PHP-CLI ausgeführt werden. Ohne diese Initialisierung bleibt die Anwendung im Setup-Redirect-Loop gefangen.

**Action:** In der README (oder künftigen Setup-Dokumentationen) muss zwingend zwischen dem webbasierten Produktions-Setup (MySQL) und der manuellen, lokalen Initialisierung per CLI (SQLite) unterschieden werden.
