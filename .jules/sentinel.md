## 2024-05-27 - Setup Hijacking Vulnerability
**Vulnerability:** Setup Hijacking (`public/setup.php`)
**Learning:** The check to prevent re-execution of the setup script was placed *after* the POST handler. This allowed an unauthenticated attacker to bypass the check and overwrite the `.env` file or re-execute migrations by sending a POST request to an already configured application.
**Prevention:** Always place access control and state-validation checks at the very beginning of a script, immediately after bootstrapping (loading env vars/autoloader), and *before* processing any user input or state-modifying logic. Use `die()` or `exit()` immediately after redirection.
## 2024-07-20 - IDOR in Application Creation
**Vulnerability:** Insecure Direct Object Reference (IDOR) during application creation (`ApplicationController@store`). A user could supply any `company_id` and create an application linked to another user's company, exposing it in their view.
**Learning:** Foreign keys passed directly from user input must always be validated to ensure they belong to the authenticated user.
**Prevention:** Always perform an ownership check against `Auth::id()` before using a user-supplied ID to create relations (e.g., `SELECT id FROM companies WHERE id = ? AND user_id = ?`).
