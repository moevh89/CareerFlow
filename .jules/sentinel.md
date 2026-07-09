## 2024-05-27 - Setup Hijacking Vulnerability
**Vulnerability:** Setup Hijacking (`public/setup.php`)
**Learning:** The check to prevent re-execution of the setup script was placed *after* the POST handler. This allowed an unauthenticated attacker to bypass the check and overwrite the `.env` file or re-execute migrations by sending a POST request to an already configured application.
**Prevention:** Always place access control and state-validation checks at the very beginning of a script, immediately after bootstrapping (loading env vars/autoloader), and *before* processing any user input or state-modifying logic. Use `die()` or `exit()` immediately after redirection.
## 2024-07-09 - IDOR and Information Leakage in ApplicationController
**Vulnerability:** IDOR (Insecure Direct Object Reference) and Information Leakage
**Learning:** `ApplicationController::store()` allowed creating applications with a `company_id` that did not belong to the user, because it lacked an authorization check. Furthermore, catching `\Exception $e` and returning `$e->getMessage()` in a JSON response can leak sensitive database query details or stack traces to an attacker.
**Prevention:** Always verify ownership for referenced foreign keys (like `company_id`) against the currently authenticated user (`Auth::id()`) before saving. Fail securely by logging exceptions internally with `error_log()` and returning a generic error message to the client.
