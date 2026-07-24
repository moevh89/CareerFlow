## 2026-07-19 - Duplicated JSON and CSRF boilerplate

**Learning:** Multiple controllers manually decode JSON from `php://input` and validate CSRF tokens, causing massive repetition and cluttering the business logic. `AuthController` was also not extending the base `Controller` and duplicated the `jsonResponse` method.

**Action:** Extracted `getJson()` and `validateCsrf()` helper methods into the base `App\Core\Controller` class. Made `AuthController` extend the base controller to reuse methods. Always look for cross-controller boilerplate to abstract into the base class.

## 2024-07-24 - Database Singleton Stale Connection in Tests

**Learning:** When writing integration tests that delete and recreate the SQLite database (`data/careerflow.sqlite`) within a single PHP script execution, the `App\Core\Database::getInstance()` singleton maintains a stale connection to the deleted file, causing `PDOException` (Integrity constraint violation) or generic database errors upon the next query, even after re-running migrations.

**Action:** When re-migrating or recreating the SQLite database within a single isolated PHP test script, clear the `App\Core\Database` singleton instance using Reflection (`$refl = new ReflectionClass(App\Core\Database::class); $prop = $refl->getProperty('instance'); $prop->setAccessible(true); $prop->setValue(null, null);`) to force a fresh connection.
