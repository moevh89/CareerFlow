## 2026-07-19 - Add DB indexes for FKs
**Learning:** In App\Core\Migrator, foreign key constraints do not automatically create indexes in the SQLite schema. This causes full table scans on frequently queried tables.
**Action:** Always manually explicitly define CREATE INDEX statements for foreign keys to prevent performance bottlenecks.

## 2024-07-21 - Combine Dashboard Status Queries
**Learning:** In the DashboardController, making multiple separate `COUNT(*)` queries against the same table (e.g., `applications`) creates unnecessary database round-trips.
**Action:** Always combine such queries into a single query using conditional aggregation (e.g., `COUNT(CASE WHEN ... THEN 1 END)`) to reduce database load and improve latency, while maintaining type safety by casting the results.
