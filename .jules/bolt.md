## 2024-07-14 - SQLite Foreign Key Indexes
**Learning:** In SQLite, defining foreign key constraints does not automatically create indexes on those columns. This can lead to performance bottlenecks (like full table scans) when filtering or joining heavily queried tables like `applications` or `companies` by their foreign keys.
**Action:** Always manually define and create indexes for foreign key columns used in WHERE or JOIN clauses when using SQLite in migrations to ensure optimal query performance.
