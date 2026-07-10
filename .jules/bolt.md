## 2024-05-18 - [Combine Multiple COUNT Queries]
**Learning:** In the `DashboardController`, the backend was executing three separate `SELECT COUNT(*)` queries sequentially for active applications, offers, and rejections. This anti-pattern increased database latency due to multiple round-trips.
**Action:** Always look for opportunities to combine multiple aggregate queries on the same table using conditional aggregation (`SUM(CASE WHEN ... THEN 1 ELSE 0 END)`), which effectively fetches all required counts in a single pass.
