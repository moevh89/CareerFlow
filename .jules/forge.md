## 2024-05-14 - Controller Input & CSRF Validation Duplication

**Learning:** Controllers in this project frequently read from `php://input` to process JSON request bodies. Nearly every POST/PATCH request repeats the exact same `json_decode` logic followed by manual CSRF token verification. Additionally, some standalone controllers (like `AuthController`) duplicated common helper methods (like `jsonResponse`) instead of extending the base `Controller`.

**Action:** Extracted the JSON decoding and CSRF validation logic into base `Controller` methods (`getJson` and `getValidatedJson`). This significantly reduces boilerplate in endpoint methods and enforces consistent input handling. Ensured `AuthController` extends the base controller to share this functionality and eliminate duplicated response logic. Future controllers should always inherit from `App\Core\Controller` and use these helper methods for data ingestion.
