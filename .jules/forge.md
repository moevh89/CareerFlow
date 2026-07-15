## 2026-07-15 - Manual JSON parsing and CSRF Validation in Controllers

**Learning:** The codebase repeatedly decodes `php://input` and manually validates CSRF tokens across multiple controller methods, leading to duplicated code and higher maintenance overhead.

**Action:** Extracted this logic into `getJson()` and `validateCsrf($data)` helper methods in the base `Controller` class, allowing child controllers to cleanly handle request data and CSRF validation.
