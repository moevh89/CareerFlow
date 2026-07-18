## 2024-05-27 - Setup Hijacking Vulnerability
**Vulnerability:** Setup Hijacking (`public/setup.php`)
**Learning:** The check to prevent re-execution of the setup script was placed *after* the POST handler. This allowed an unauthenticated attacker to bypass the check and overwrite the `.env` file or re-execute migrations by sending a POST request to an already configured application.
**Prevention:** Always place access control and state-validation checks at the very beginning of a script, immediately after bootstrapping (loading env vars/autoloader), and *before* processing any user input or state-modifying logic. Use `die()` or `exit()` immediately after redirection.
## 2024-05-28 - Insecure Direct Object Reference (IDOR) in Application Creation
**Vulnerability:** IDOR when creating an application with a company ID.
**Learning:** The `store` method in `ApplicationController` accepted a `company_id` from user input without verifying if the authenticated user owned that company. This allowed a user to link their application to another user's company by supplying its ID.
**Prevention:** Always verify ownership of referenced entities when accepting foreign keys (like `company_id`) from user input before inserting or updating records. Check against `Auth::id()`.
