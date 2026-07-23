## 2026-07-19 - Add DB indexes for FKs
**Learning:** In App\Core\Migrator, foreign key constraints do not automatically create indexes in the SQLite schema. This causes full table scans on frequently queried tables.
**Action:** Always manually explicitly define CREATE INDEX statements for foreign keys to prevent performance bottlenecks.
## 2024-07-23 - Combining aggregate queries
**Learning:** SQLite processes conditional aggregations (COUNT(CASE WHEN ...)) far more efficiently than multiple separate COUNT(*) statements on the same table. This avoids the N+1 anti-pattern on common dashboard stats.
**Action:** Always combine dashboard-like summary aggregations into single parameterized queries.
