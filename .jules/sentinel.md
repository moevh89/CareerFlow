## 2024-05-27 - Setup Hijacking Vulnerability
**Vulnerability:** Setup Hijacking (`public/setup.php`)
**Learning:** The check to prevent re-execution of the setup script was placed *after* the POST handler. This allowed an unauthenticated attacker to bypass the check and overwrite the `.env` file or re-execute migrations by sending a POST request to an already configured application.
**Prevention:** Always place access control and state-validation checks at the very beginning of a script, immediately after bootstrapping (loading env vars/autoloader), and *before* processing any user input or state-modifying logic. Use `die()` or `exit()` immediately after redirection.
## 2024-05-24 - IDOR in Foreign Keys (company_id)
**Vulnerability:** A user could submit a POST request to create an application with a `company_id` belonging to another user, and the API would accept it (Insecure Direct Object Reference).
**Learning:** The frontend only shows the user's companies, but the backend must re-verify that any foreign key ID submitted in a payload belongs to the authenticated user. Relying solely on the frontend state is a security risk.
**Prevention:** Always verify ownership of referenced entities via `SELECT id FROM <table> WHERE id = ? AND user_id = ?` (with `Auth::id()`) before inserting them as foreign keys into new records.
