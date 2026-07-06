<?php
namespace App\Core;

class Migrator {
    public static function migrate() {
        $db = Database::getInstance()->getConnection();

        $queries = [
            "CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                name VARCHAR(255),
                google_id VARCHAR(255) UNIQUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )",
            "CREATE TABLE IF NOT EXISTS companies (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                name VARCHAR(255) NOT NULL,
                industry VARCHAR(255),
                size VARCHAR(50),
                location VARCHAR(255),
                website VARCHAR(255),
                kununu_link VARCHAR(255),
                linkedin_link VARCHAR(255),
                logo VARCHAR(255),
                rating INTEGER DEFAULT 0,
                notes TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id)
            )",
            "CREATE TABLE IF NOT EXISTS contacts (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                company_id INTEGER NOT NULL,
                name VARCHAR(255) NOT NULL,
                position VARCHAR(255),
                email VARCHAR(255),
                phone VARCHAR(50),
                linkedin_profile VARCHAR(255),
                notes TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (company_id) REFERENCES companies(id)
            )",
            "CREATE TABLE IF NOT EXISTS statuses (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name VARCHAR(50) NOT NULL,
                color VARCHAR(20) DEFAULT '#cccccc',
                is_default BOOLEAN DEFAULT 0
            )",
            "CREATE TABLE IF NOT EXISTS applications (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                company_id INTEGER,
                job_title VARCHAR(255) NOT NULL,
                status_id INTEGER,
                salary_expectation VARCHAR(100),
                earliest_start_date DATE,
                work_location VARCHAR(255),
                job_ad_link VARCHAR(500),
                benefits TEXT,
                notes TEXT,
                application_date DATE,
                priority INTEGER DEFAULT 3,
                is_favorite BOOLEAN DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id),
                FOREIGN KEY (company_id) REFERENCES companies(id),
                FOREIGN KEY (status_id) REFERENCES statuses(id)
            )",
            "CREATE TABLE IF NOT EXISTS application_contacts (
                application_id INTEGER,
                contact_id INTEGER,
                PRIMARY KEY (application_id, contact_id),
                FOREIGN KEY (application_id) REFERENCES applications(id),
                FOREIGN KEY (contact_id) REFERENCES contacts(id)
            )",
            "CREATE TABLE IF NOT EXISTS interviews (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                application_id INTEGER NOT NULL,
                interview_date DATETIME NOT NULL,
                location VARCHAR(255),
                online_meeting_link VARCHAR(500),
                notes TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (application_id) REFERENCES applications(id)
            )",
            "CREATE TABLE IF NOT EXISTS documents (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                application_id INTEGER NOT NULL,
                filename VARCHAR(255) NOT NULL,
                filepath VARCHAR(500) NOT NULL,
                type VARCHAR(50),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (application_id) REFERENCES applications(id)
            )",
            "CREATE TABLE IF NOT EXISTS activity_log (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                application_id INTEGER NOT NULL,
                user_id INTEGER NOT NULL,
                action VARCHAR(255) NOT NULL,
                description TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (application_id) REFERENCES applications(id),
                FOREIGN KEY (user_id) REFERENCES users(id)
            )",
            "CREATE TABLE IF NOT EXISTS tags (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                name VARCHAR(50) NOT NULL,
                color VARCHAR(20) DEFAULT '#cccccc',
                FOREIGN KEY (user_id) REFERENCES users(id)
            )",
            "CREATE TABLE IF NOT EXISTS application_tags (
                application_id INTEGER,
                tag_id INTEGER,
                PRIMARY KEY (application_id, tag_id),
                FOREIGN KEY (application_id) REFERENCES applications(id),
                FOREIGN KEY (tag_id) REFERENCES tags(id)
            )"
        ];

        foreach ($queries as $query) {
            $db->exec($query);
        }

        // Seed statuses if empty
        $stmt = $db->query("SELECT COUNT(*) FROM statuses");
        if ($stmt->fetchColumn() == 0) {
            $defaultStatuses = [
                ['Interessant', '#6b7280'],
                ['Bewerbung geplant', '#3b82f6'],
                ['Bewerbung versendet', '#8b5cf6'],
                ['Eingangsbestätigung', '#10b981'],
                ['Vorstellungsgespräch', '#f59e0b'],
                ['Zweitgespräch', '#f97316'],
                ['Angebot erhalten', '#14b8a6'],
                ['Zusage', '#22c55e'],
                ['Absage', '#ef4444']
            ];

            $stmt = $db->prepare("INSERT INTO statuses (name, color, is_default) VALUES (?, ?, 1)");
            foreach ($defaultStatuses as $status) {
                $stmt->execute($status);
            }
        }
    }
}
