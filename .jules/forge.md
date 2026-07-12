## 2024-07-12 - Extracted duplicated CSRF validation

**Learning:** There was duplicate `json_decode` and CSRF validation logic repeated across all controllers that handle REST POST requests. Also, an earlier memory indicated that when calling `jsonResponse()`, controllers should explicitly precede it with a `return` statement.

**Action:** Created `getJson()` and `getValidatedJson()` helpers in `App\Core\Controller` to handle the JSON decoding and CSRF validation in a single place. Replaced the manual checks in controllers with these helpers. Made sure all `jsonResponse` calls explicitly use `return`.
## 2024-07-12 - Reverted getValidatedJson anti-pattern

**Learning:** Returning HTTP responses (and terminating scripts or throwing errors) deep within data retrieval helpers obscures control flow and violates the maintainability goal of making control flow explicit. It also creates security risks if the underlying response mechanism changes (e.g., returning objects instead of terminating).

**Action:** Replaced `getValidatedJson()` with a boolean helper `validateCsrf($data)`. This keeps the responsibility of fetching data separate from validation and keeps the explicit `return` statements for error handling clearly visible within the controller actions.
