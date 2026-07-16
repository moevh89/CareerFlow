
## 2026-07-16 - Centralize JSON input reading and CSRF validation

**Learning:** Duplicate JSON parsing and explicit CSRF checks across controllers increase boilerplate and risk missing validation. Also, calling methods that terminate execution (like `die()` in `jsonResponse`) without an explicit `return` makes the control flow non-obvious to static analysis and human readers.

**Action:** Extract reusable `getJson()` and `validateCsrf()` methods to the base `Controller` class, and always use an explicit `return` statement when returning a JSON response to clearly signal the end of method execution.
