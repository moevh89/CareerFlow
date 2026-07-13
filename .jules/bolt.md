## 2024-05-19 - Single Dashboard Query Aggregation
**Learning:** In the `DashboardController`, it's easy to write multiple separate `COUNT(*)` database queries. However, a single database query using conditional aggregation (`SUM(CASE WHEN ...)`) provides the same information with a single network roundtrip, increasing database and application backend efficiency.
**Action:** When calculating several metrics from the same table grouped by similar criteria (like `user_id`), always check if they can be grouped into one query using `CASE WHEN`.
