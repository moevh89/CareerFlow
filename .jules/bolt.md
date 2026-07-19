## 2026-07-19 - Add DB indexes for FKs
**Learning:** In App\Core\Migrator, foreign key constraints do not automatically create indexes in the SQLite schema. This causes full table scans on frequently queried tables.
**Action:** Always manually explicitly define CREATE INDEX statements for foreign keys to prevent performance bottlenecks.
