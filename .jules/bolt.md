## 2026-07-19 - Add DB indexes for FKs
**Learning:** In App\Core\Migrator, foreign key constraints do not automatically create indexes in the SQLite schema. This causes full table scans on frequently queried tables.
**Action:** Always manually explicitly define CREATE INDEX statements for foreign keys to prevent performance bottlenecks.

## 2023-10-27 - Optimize multiple COUNT(*) queries
**Learning:** Performing multiple aggregate queries (`COUNT(*)`) for different conditions on the same table causes multiple database roundtrips and full table scans.
**Action:** Combine these into a single query using conditional aggregation (`COUNT(CASE WHEN ... THEN 1 END)`) to scan the table only once.
