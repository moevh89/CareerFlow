## 2024-05-27 - Setup Hijacking Vulnerability
**Vulnerability:** Setup Hijacking (`public/setup.php`)
**Learning:** The check to prevent re-execution of the setup script was placed *after* the POST handler. This allowed an unauthenticated attacker to bypass the check and overwrite the `.env` file or re-execute migrations by sending a POST request to an already configured application.
**Prevention:** Always place access control and state-validation checks at the very beginning of a script, immediately after bootstrapping (loading env vars/autoloader), and *before* processing any user input or state-modifying logic. Use `die()` or `exit()` immediately after redirection.
## 2024-12-04 - [Missing returns in controller execution flow]
**Vulnerability:** Execution flow in controllers continued even after security checks (like CSRF validation) failed, because `jsonResponse` lacked an explicit `return` and relied on `die()`.
**Learning:** Base methods that call `die()` can lead to confusing and error-prone control flow. Specifically, missing a `return` before a validation failure response allows the script to continue executing the rest of the method if the base method changes or is bypassed.
**Prevention:** Always explicitly use `return` before calling response helpers like `$this->jsonResponse()` in controllers to guarantee control flow stops, regardless of the helper's internal implementation.
