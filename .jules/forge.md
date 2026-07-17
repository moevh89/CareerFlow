## 2024-06-15 - Extracted JSON decoding and CSRF validation into Base Controller

**Learning:** There was a recurring code smell across all API controllers where `json_decode(file_get_contents('php://input'), true)` and manual CSRF token validation were duplicated in almost every endpoint method (store, update, login, register). This increased boilerplate and the risk of missing a CSRF check. Also, `jsonResponse` was calling `die()` without an explicit return statement in the controllers, which made control flow less obvious.

**Action:** Extracted this logic into `$this->getJson()` and `$this->validateCsrf($data)` in `App\Core\Controller`. This centralizes the logic and simplifies the controllers. I also enforced explicit `return` statements before `$this->jsonResponse()` calls to make the control flow explicit and prevent potential fall-through execution bugs.
