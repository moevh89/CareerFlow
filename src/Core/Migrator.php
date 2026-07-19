<?php
namespace App\Core;

class Migrator {
    public static function migrate() {
        $db = Database::getInstance()->getConnection();

        $queries = [
            "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                name VARCHAR(255),
                google_id VARCHAR(255) UNIQUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )",
            "CREATE TABLE IF NOT EXISTS companies (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                name VARCHAR(255) NOT NULL,
                industry VARCHAR(255),
                size VARCHAR(50),
                location VARCHAR(255),
                website VARCHAR(255),
                kununu_link VARCHAR(255),
                linkedin_link VARCHAR(255),
                logo VARCHAR(255),
                rating INT DEFAULT 0,
                notes TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id)
            )",
            "CREATE TABLE IF NOT EXISTS contacts (
                id INT AUTO_INCREMENT PRIMARY KEY,
                company_id INT NOT NULL,
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
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(50) NOT NULL,
                color VARCHAR(20) DEFAULT '#cccccc',
                is_default BOOLEAN DEFAULT 0
            )",
            "CREATE TABLE IF NOT EXISTS applications (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                company_id INT,
                job_title VARCHAR(255) NOT NULL,
                status_id INT,
                salary_expectation VARCHAR(100),
                earliest_start_date DATE,
                work_location VARCHAR(255),
                job_ad_link VARCHAR(500),
                benefits TEXT,
                notes TEXT,
                application_date DATE,
                priority INT DEFAULT 3,
                is_favorite BOOLEAN DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id),
                FOREIGN KEY (company_id) REFERENCES companies(id),
                FOREIGN KEY (status_id) REFERENCES statuses(id)
            )",
            "CREATE TABLE IF NOT EXISTS application_contacts (
                application_id INT,
                contact_id INT,
                PRIMARY KEY (application_id, contact_id),
                FOREIGN KEY (application_id) REFERENCES applications(id),
                FOREIGN KEY (contact_id) REFERENCES contacts(id)
            )",
            "CREATE TABLE IF NOT EXISTS interviews (
                id INT AUTO_INCREMENT PRIMARY KEY,
                application_id INT NOT NULL,
                interview_date DATETIME NOT NULL,
                location VARCHAR(255),
                online_meeting_link VARCHAR(500),
                notes TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (application_id) REFERENCES applications(id)
            )",
            "CREATE TABLE IF NOT EXISTS documents (
                id INT AUTO_INCREMENT PRIMARY KEY,
                application_id INT NOT NULL,
                filename VARCHAR(255) NOT NULL,
                filepath VARCHAR(500) NOT NULL,
                type VARCHAR(50),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (application_id) REFERENCES applications(id)
            )",
            "CREATE TABLE IF NOT EXISTS activity_log (
                id INT AUTO_INCREMENT PRIMARY KEY,
                application_id INT NOT NULL,
                user_id INT NOT NULL,
                action VARCHAR(255) NOT NULL,
                description TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (application_id) REFERENCES applications(id),
                FOREIGN KEY (user_id) REFERENCES users(id)
            )",
            "CREATE TABLE IF NOT EXISTS tags (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                name VARCHAR(50) NOT NULL,
                color VARCHAR(20) DEFAULT '#cccccc',
                FOREIGN KEY (user_id) REFERENCES users(id)
            )",
            "CREATE TABLE IF NOT EXISTS application_tags (
                application_id INT,
                tag_id INT,
                PRIMARY KEY (application_id, tag_id),
                FOREIGN KEY (application_id) REFERENCES applications(id),
                FOREIGN KEY (tag_id) REFERENCES tags(id)
            )",
            // Add missing explicit indexes for foreign keys to prevent full table scans in SQLite
            "CREATE INDEX IF NOT EXISTS idx_companies_user_id ON companies(user_id)",
            "CREATE INDEX IF NOT EXISTS idx_contacts_company_id ON contacts(company_id)",
            "CREATE INDEX IF NOT EXISTS idx_applications_user_id ON applications(user_id)",
            "CREATE INDEX IF NOT EXISTS idx_applications_company_id ON applications(company_id)",
            "CREATE INDEX IF NOT EXISTS idx_applications_status_id ON applications(status_id)",
            "CREATE INDEX IF NOT EXISTS idx_application_contacts_app_id ON application_contacts(application_id)",
            "CREATE INDEX IF NOT EXISTS idx_application_contacts_contact_id ON application_contacts(contact_id)",
            "CREATE INDEX IF NOT EXISTS idx_interviews_application_id ON interviews(application_id)",
            "CREATE INDEX IF NOT EXISTS idx_documents_application_id ON documents(application_id)",
            "CREATE INDEX IF NOT EXISTS idx_activity_log_application_id ON activity_log(application_id)",
            "CREATE INDEX IF NOT EXISTS idx_activity_log_user_id ON activity_log(user_id)",
            "CREATE INDEX IF NOT EXISTS idx_tags_user_id ON tags(user_id)",
            "CREATE INDEX IF NOT EXISTS idx_application_tags_app_id ON application_tags(application_id)",
            "CREATE INDEX IF NOT EXISTS idx_application_tags_tag_id ON application_tags(tag_id)"
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
