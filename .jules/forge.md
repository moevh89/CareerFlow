## 2026-07-19 - Duplicated JSON and CSRF boilerplate

**Learning:** Multiple controllers manually decode JSON from `php://input` and validate CSRF tokens, causing massive repetition and cluttering the business logic. `AuthController` was also not extending the base `Controller` and duplicated the `jsonResponse` method.

**Action:** Extracted `getJson()` and `validateCsrf()` helper methods into the base `App\Core\Controller` class. Made `AuthController` extend the base controller to reuse methods. Always look for cross-controller boilerplate to abstract into the base class.

## 2026-07-23 - Duplicated database connection boilerplate

**Learning:** Multiple controllers were manually retrieving the database connection using `Database::getInstance()->getConnection()`, causing repetition and unnecessary imports.

**Action:** Extracted the `Database::getInstance()->getConnection()` logic into a protected `db()` helper method within the base `App\Core\Controller` class. This allowed replacing all calls with `$this->db()` and removing unused `use App\Core\Database;` imports from the controllers.
