## 2026-07-19 - Add DB indexes for FKs
**Learning:** In App\Core\Migrator, foreign key constraints do not automatically create indexes in the SQLite schema. This causes full table scans on frequently queried tables.
**Action:** Always manually explicitly define CREATE INDEX statements for foreign keys to prevent performance bottlenecks.
## 2026-07-24 - N+1 Queries in Controllers
**Learning:** Controller methods like `DashboardController::index()` previously ran multiple separate SQL `COUNT(*)` queries on the same table (e.g., `applications`) to fetch different status metrics for a single user, creating unnecessary database round-trips. Furthermore, when combining these using `COUNT(CASE WHEN ... THEN 1 END)`, special care must be taken with SQLite's `NULL` handling (e.g., `status_id IS NULL`), as `NOT IN (8, 9)` implicitly excludes `NULL` rows.
**Action:** Implemented a single aggregate query using conditional `COUNT(CASE WHEN ... THEN 1 END)`. Always check for adjacent queries hitting the same table and consolidate them to reduce round-trips, ensuring exact logical parity (especially regarding implicit `NULL` exclusions).
