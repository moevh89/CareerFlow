## 2024-05-24 - Missing SQLite Foreign Key Indexes
**Learning:** In SQLite, foreign key constraints do not automatically create indexes, causing full table scans on frequently queried relations.
**Action:** Explicitly add CREATE INDEX statements alongside table definitions for foreign keys to optimize query performance in SQLite.
