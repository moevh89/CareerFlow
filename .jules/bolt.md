## 2024-05-24 - [Optimize Dashboard Queries]
**Learning:** By combining multiple sequential `COUNT(*)` queries into a single query using conditional counting (e.g. `COUNT(CASE WHEN ... THEN 1 END)`), database roundtrips can be significantly reduced in PHP/PDO applications resulting in faster response times for dashboard views.
**Action:** When a controller requires multiple simple aggregates from the same table, combine them into a single query instead of doing individual roundtrips.
