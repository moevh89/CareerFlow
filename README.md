# CareerFlow

CareerFlow ist ein einfacher, leichtgewichtiger Bewerbungsmanager. Die Anwendung basiert auf einem PHP 8.3 Backend (JSON REST API) und einem Alpine.js Frontend.

Sie wurde speziell so konzipiert, dass sie auf klassischem Shared Hosting läuft – ohne dass Node.js, Docker oder komplexe Build-Schritte erforderlich sind.

## 🚀 Features & Architektur

- **Backend:** PHP 8.3 im MVC-Muster
- **Frontend:** Alpine.js (ohne Build-Tools)
- **Datenbank:** MariaDB/MySQL (für Produktion) oder SQLite (für lokale Entwicklung)
- **Kein Composer:** Das Projekt verwendet einen eigenen, simplen Autoloader (`public/index.php`). Ein `composer install` ist daher **nicht** erforderlich.

## 📁 Projektstruktur

Da dieses Projekt auf ein externes Framework verzichtet, ist die Codebasis wie folgt aufgeteilt:

- `public/` – **Document Root.** Muss vom Webserver ausgeliefert werden. Enthält den Autoloader, den Router (`index.php`), das Frontend (`index.html`, `js/`, `css/`) sowie das Setup-Skript (`setup.php`).
- `src/` – **Backend-Logik.** Darf nicht öffentlich über das Web erreichbar sein.
  - `Controllers/` – Endpunkte für die JSON-REST-API.
  - `Core/` – Grundlagen des eigenen Frameworks (Router, Datenbankverbindung, Auth-Logik).
- `data/` – **Lokale Datenbank.** Speicherort für die SQLite-Datenbank (`careerflow.sqlite`), falls SQLite für die Entwicklung verwendet wird. Darf nicht öffentlich erreichbar sein.

## 🛠️ Systemvoraussetzungen

- PHP 8.3 oder neuer
- MariaDB / MySQL (oder SQLite PDO-Erweiterung für lokale Entwicklung)
- Ein Webserver (Apache/Nginx) oder der integrierte PHP-Server für lokale Tests

## 💻 Lokale Entwicklung & Installation

1. **Repository klonen**

   ```bash
   git clone <repository-url> careerflow
   cd careerflow
   ```

2. **Umgebungsvariablen konfigurieren**
   Kopiere die Beispielkonfiguration:

   ```bash
   cp .env.example .env
   ```

   *Hinweis:* Standardmäßig ist in der `.env.example` SQLite als Treiber voreingestellt (`DB_DRIVER=sqlite`). Die Datenbankdatei wird dann im Ordner `data/` erwartet (den Ordner ggf. anlegen).

3. **Lokalen Server starten**
   Starte den integrierten PHP-Server. Wichtig: Das Document Root muss auf den Ordner `public` zeigen.

   ```bash
   php -S localhost:8000 -t public
   ```

4. **App aufrufen**
   Öffne `http://localhost:8000` im Browser. Wenn die Datenbank noch nicht konfiguriert ist, leitet dich die App zum Setup-Prozess weiter.

## 🌍 Deployment auf Shared Hosting (Produktion)

1. Lade alle Dateien aus dem Projektverzeichnis auf deinen Webspace hoch.
2. Konfiguriere deinen Webserver (z. B. im Kundenmenü deines Hosters) so, dass das **Document Root** (das öffentliche Verzeichnis) auf den Ordner `public/` zeigt. Aus Sicherheitsgründen dürfen die anderen Ordner (`src/`, `data/`) nicht direkt über das Web erreichbar sein.
3. Ruf deine Domain im Browser auf (z. B. `https://deine-domain.de`).
4. Du wirst automatisch zum webbasierten **Setup-Prozess** (`/setup.php`) weitergeleitet. Dort kannst du bequem deine MariaDB/MySQL-Datenbankdaten eingeben. Das System generiert daraufhin die `.env`-Datei und legt automatisch alle benötigten Datenbanktabellen an.
