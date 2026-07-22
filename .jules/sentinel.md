## 2024-05-27 - Setup Hijacking Vulnerability
**Vulnerability:** Setup Hijacking (`public/setup.php`)
**Learning:** The check to prevent re-execution of the setup script was placed *after* the POST handler. This allowed an unauthenticated attacker to bypass the check and overwrite the `.env` file or re-execute migrations by sending a POST request to an already configured application.
**Prevention:** Always place access control and state-validation checks at the very beginning of a script, immediately after bootstrapping (loading env vars/autoloader), and *before* processing any user input or state-modifying logic. Use `die()` or `exit()` immediately after redirection.

## 2026-07-22 - Application Controller IDOR
**Vulnerability:** IDOR in `ApplicationController::store`
**Learning:** The application creation endpoint allowed users to link applications to companies that didn't belong to them because it didn't verify the owner of the `company_id`.
**Prevention:** Always verify that foreign keys provided in user input reference objects owned by the currently authenticated user before inserting them into the database.
