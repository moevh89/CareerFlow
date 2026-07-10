# Atlas Journal

## 2024-07-08 - Eigener Autoloader statt Composer

**Learning:** Entgegen üblicher PHP-Projekte (und internem Memory) verwendet dieses Projekt keinen Composer, sondern einen eigenen Autoloader (`public/index.php`). Ein `composer install` ist daher weder möglich noch nötig.

**Action:** In der Installationsanleitung (README) explizit erwähnen, dass kein Composer benötigt wird, um Verwirrung bei neuen Entwicklern zu vermeiden.

## 2024-07-08 - SPA statt PHP Views

**Learning:** Obwohl das Backend eine Controller-Struktur verwendet, gibt es keine klassischen PHP-Views. Das Backend agiert stattdessen als reine JSON REST API. Das Frontend ist eine Single-Page-Application (SPA), die vollständig im Ordner `public/` (`index.html`, `js/app.js`) liegt. Dies kann neue Entwickler überraschen, die nach Blade-, Twig- oder PHP-Templates suchen.

**Action:** In der README eine Sektion zur "Projektstruktur" hinzufügen, die diese klare Trennung (Backend = API in `src/`, Frontend = SPA in `public/`) dokumentiert, um Entwicklern die Orientierung zu erleichtern.
