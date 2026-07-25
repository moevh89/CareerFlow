## 2024-05-27 - Setup Hijacking Vulnerability
**Vulnerability:** Setup Hijacking (`public/setup.php`)
**Learning:** The check to prevent re-execution of the setup script was placed *after* the POST handler. This allowed an unauthenticated attacker to bypass the check and overwrite the `.env` file or re-execute migrations by sending a POST request to an already configured application.
**Prevention:** Always place access control and state-validation checks at the very beginning of a script, immediately after bootstrapping (loading env vars/autoloader), and *before* processing any user input or state-modifying logic. Use `die()` or `exit()` immediately after redirection.
## 2024-07-25 - Prevent Insecure Direct Object Reference (IDOR) on Foreign Keys
**Vulnerability:** The application creation endpoint (`ApplicationController::store`) accepted a `company_id` without verifying if the authenticated user owned the specified company. This allowed users to associate their applications with companies created by other users (IDOR).
**Learning:** Foreign keys provided in user requests (like `company_id`) must always be validated against the current user's ID (`Auth::id()`) before being used in `INSERT` or `UPDATE` queries, as backend endpoints cannot trust the frontend to only send valid relationships.
**Prevention:** Always add authorization checks for related models during creation or modification, verifying ownership via `SELECT id FROM table WHERE id = ? AND user_id = ?`.
