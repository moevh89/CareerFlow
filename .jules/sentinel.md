## 2024-05-27 - Setup Hijacking Vulnerability
**Vulnerability:** Setup Hijacking (`public/setup.php`)
**Learning:** The check to prevent re-execution of the setup script was placed *after* the POST handler. This allowed an unauthenticated attacker to bypass the check and overwrite the `.env` file or re-execute migrations by sending a POST request to an already configured application.
**Prevention:** Always place access control and state-validation checks at the very beginning of a script, immediately after bootstrapping (loading env vars/autoloader), and *before* processing any user input or state-modifying logic. Use `die()` or `exit()` immediately after redirection.
## 2024-07-24 - IDOR in Foreign Key Relationships
**Vulnerability:** Insecure Direct Object Reference (IDOR) where a user could specify a `company_id` that belonged to another user when creating an application, because the application merely checked if the company existed without validating ownership.
**Learning:** In a multi-tenant relational schema (where multiple users have their own companies, applications, etc.), foreign key relationships derived from user input must always be validated against the currently authenticated user's ID before being used in an `INSERT` or `UPDATE` statement.
**Prevention:** Whenever accepting a foreign key (like `company_id`) in an API request, verify that the referenced record is owned by `Auth::id()` before using it.
