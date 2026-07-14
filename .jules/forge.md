## 2026-07-14 - Extract JSON and CSRF helpers

**Learning:** Duplicated JSON decoding and CSRF validation in controllers decreases maintainability and obscures control flow when explicit returns are missed.

**Action:** Extract 'getJson()' and 'validateCsrf($data)' to the base 'Controller' and ensure explicit returns on failure.
