# Atlas Journal

## 2024-07-08 - Eigener Autoloader statt Composer

**Learning:** Entgegen üblicher PHP-Projekte (und internem Memory) verwendet dieses Projekt keinen Composer, sondern einen eigenen Autoloader (`public/index.php`). Ein `composer install` ist daher weder möglich noch nötig.

**Action:** In der Installationsanleitung (README) explizit erwähnen, dass kein Composer benötigt wird, um Verwirrung bei neuen Entwicklern zu vermeiden.

## 2026-07-25 - SQLite Setup Dokumentation

**Learning:** Der webbasierte Setup-Prozess (`setup.php`) unterstützt ausschließlich MySQL/MariaDB. Für die lokale Entwicklung mit SQLite muss die Datenbank manuell über ein CLI-Kommando initialisiert werden, da Anwender ansonsten in einer Endlosschleife im Setup-Prozess für MySQL feststecken.

**Action:** In der README (oder ähnlichen Installationsanleitungen) muss explizit die manuelle CLI-Migration (`mkdir -p data && php -r "..."`) für SQLite erwähnt werden, bevor der lokale Server gestartet wird.
