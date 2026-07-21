# CareerFlow

CareerFlow ist ein einfacher, leichtgewichtiger Bewerbungsmanager. Die Anwendung basiert auf einem PHP 8.3 Backend (JSON REST API) und einem Alpine.js Frontend.

Sie wurde speziell so konzipiert, dass sie auf klassischem Shared Hosting läuft – ohne dass Node.js, Docker oder komplexe Build-Schritte erforderlich sind.

## 🚀 Features & Architektur

- **Backend:** PHP 8.3 im MVC-Muster
- **Frontend:** Alpine.js (ohne Build-Tools)
- **Datenbank:** MariaDB/MySQL (für Produktion) oder SQLite (für lokale Entwicklung)
- **Kein Composer:** Das Projekt verwendet einen eigenen, simplen Autoloader (`public/index.php`). Ein `composer install` ist daher **nicht** erforderlich.

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

   *Hinweis:* Standardmäßig ist in der `.env.example` SQLite als Treiber voreingestellt (`DB_DRIVER=sqlite`).

3. **Lokale SQLite-Datenbank initialisieren**
   Da das webbasierte Setup ausschließlich MySQL/MariaDB unterstützt, muss die lokale SQLite-Datenbank über die Kommandozeile initialisiert werden:

   ```bash
   mkdir -p data
   php -r "require 'src/Core/Dotenv.php'; require 'src/Core/Database.php'; require 'src/Core/Migrator.php'; App\Core\Dotenv::load('.env'); App\Core\Migrator::migrate();"
   ```

4. **Lokalen Server starten**
   Starte den integrierten PHP-Server. Wichtig: Das Document Root muss auf den Ordner `public` zeigen.

   ```bash
   php -S localhost:8000 -t public
   ```

5. **App aufrufen**
   Öffne `http://localhost:8000` im Browser.

## 🌍 Deployment auf Shared Hosting (Produktion)

1. Lade alle Dateien aus dem Projektverzeichnis auf deinen Webspace hoch.
2. Konfiguriere deinen Webserver (z. B. im Kundenmenü deines Hosters) so, dass das **Document Root** (das öffentliche Verzeichnis) auf den Ordner `public/` zeigt. Aus Sicherheitsgründen dürfen die anderen Ordner (`src/`, `data/`) nicht direkt über das Web erreichbar sein.
3. Ruf deine Domain im Browser auf (z. B. `https://deine-domain.de`).
4. Du wirst automatisch zum webbasierten **Setup-Prozess** (`/setup.php`) weitergeleitet. Dort kannst du bequem deine MariaDB/MySQL-Datenbankdaten eingeben. Das System generiert daraufhin die `.env`-Datei und legt automatisch alle benötigten Datenbanktabellen an.
