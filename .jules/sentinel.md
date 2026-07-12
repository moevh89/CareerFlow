## 2024-05-27 - Setup Hijacking Vulnerability
**Vulnerability:** Setup Hijacking (`public/setup.php`)
**Learning:** The check to prevent re-execution of the setup script was placed *after* the POST handler. This allowed an unauthenticated attacker to bypass the check and overwrite the `.env` file or re-execute migrations by sending a POST request to an already configured application.
**Prevention:** Always place access control and state-validation checks at the very beginning of a script, immediately after bootstrapping (loading env vars/autoloader), and *before* processing any user input or state-modifying logic. Use `die()` or `exit()` immediately after redirection.
## 2024-05-24 - [IDOR in Foreign Key Assignment]
**Vulnerability:** ApplicationController::store() allowed assigning an arbitrary company_id to a new application without verifying if the authenticated user owned that company. This is a form of Insecure Direct Object Reference (IDOR).
**Learning:** Even if the main entity (application) is correctly associated with Auth::id(), any foreign keys (like company_id) provided in the request payload must also be explicitly verified to belong to the authenticated user.
**Prevention:** Always add a SELECT query to verify ownership of referenced IDs before using them in INSERT or UPDATE queries, as done in ContactController::store().
