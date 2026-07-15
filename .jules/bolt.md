## 2026-07-15 - SQLite Missing Foreign Key Indexes
**Learning:** SQLite does not automatically create indexes on foreign key constraints. This creates a severe performance bottleneck for frequently queried tables and JOINs.
**Action:** Always manually create `CREATE INDEX` statements for foreign key columns when defining SQLite schemas.
