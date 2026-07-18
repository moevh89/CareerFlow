
## 2024-05-18 - Extract JSON payload parsing and CSRF validation helpers

**Learning:** Controllers throughout the application duplicated logic for decoding `php://input` JSON and validating CSRF tokens. Additionally, `$this->jsonResponse` methods were often called without a `return` statement, relying on an implicit `die()` which makes control flow less obvious and harder to test.

**Action:** Extracted `getJson()` and `validateCsrf()` into the base `App\Core\Controller`. Updated all controllers to use these helpers and explicitly `return` when calling `$this->jsonResponse()`.
