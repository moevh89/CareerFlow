## 2026-07-19 - Duplicated JSON and CSRF boilerplate

**Learning:** Multiple controllers manually decode JSON from `php://input` and validate CSRF tokens, causing massive repetition and cluttering the business logic. `AuthController` was also not extending the base `Controller` and duplicated the `jsonResponse` method.

**Action:** Extracted `getJson()` and `validateCsrf()` helper methods into the base `App\Core\Controller` class. Made `AuthController` extend the base controller to reuse methods. Always look for cross-controller boilerplate to abstract into the base class.

## 2026-07-20 - Abstract database connection boilerplate

**Learning:** Multiple controllers were repeatedly calling Database::getInstance()->getConnection() and importing the Database class, causing duplication.

**Action:** Extracted the db() helper method into the base App\Core\Controller class to remove boilerplate and unused imports.
