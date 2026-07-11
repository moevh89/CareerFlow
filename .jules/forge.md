
## 2024-05-19 - Repeated Input Decoding and CSRF Validation

**Learning:** There was a recurring code smell across multiple controllers (`AuthController`, `ApplicationController`, `CompanyController`, `ContactController`) where `json_decode(file_get_contents('php://input'), true)` and the adjacent CSRF validation check were duplicated.

**Action:** Consolidated the repetitive logic into `getJson()` and `getValidatedJson()` methods in the base `App\Core\Controller` class, allowing derived controllers to read and validate JSON input safely with a single method call, reducing duplication and improving readability.
