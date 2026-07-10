# CareerFlow

CareerFlow ist ein einfacher, leichtgewichtiger Bewerbungsmanager. Die Anwendung basiert auf einem PHP 8.3 Backend (JSON REST API) und einem Alpine.js Frontend.

Sie wurde speziell so konzipiert, dass sie auf klassischem Shared Hosting läuft – ohne dass Node.js, Docker oder komplexe Build-Schritte erforderlich sind.

## 🚀 Features & Architektur

- **Backend:** PHP 8.3 im MVC-Muster
- **Frontend:** Alpine.js (ohne Build-Tools)
- **Datenbank:** MariaDB/MySQL (für Produktion) oder SQLite (für lokale Entwicklung)
- **Kein Composer:** Das Projekt verwendet einen eigenen, simplen Autoloader (`public/index.php`). Ein `composer install` ist daher **nicht** erforderlich.

## 📂 Projektstruktur

Obwohl das Backend im MVC-Muster organisiert ist, gibt es im PHP-Code **keine Views**.

*   `src/`: Beinhaltet ausschließlich die Backend-Logik, welche als reine **JSON REST API** agiert.
*   `public/`: Beinhaltet das Single-Page-Application (SPA) Frontend (insbesondere `index.html` und `js/app.js`), das Web-Setup (`setup.php`) sowie den Einstiegspunkt (`index.php`).
*   `data/`: Standard-Verzeichnis für die SQLite-Datenbank bei lokaler Entwicklung.

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

   Die Anwendung wird über die `.env`-Datei konfiguriert. Folgende Variablen sind verfügbar:

   - `DB_DRIVER`: Datenbanktyp (`sqlite` für lokale Entwicklung, `mysql` für Produktion).
   - `DB_FILE`: Pfad zur SQLite-Datenbankdatei (nur wenn `DB_DRIVER=sqlite`). Standard: `data/careerflow.sqlite`.
   - `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`: Verbindungsdaten für MariaDB/MySQL (nur wenn `DB_DRIVER=mysql`).

   *Hinweis:* Standardmäßig ist SQLite als Treiber voreingestellt (`DB_DRIVER=sqlite`). Die Datenbankdatei wird dann im Ordner `data/` erwartet (den Ordner ggf. mit `mkdir data` anlegen).

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
