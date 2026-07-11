## 2024-05-27 - Setup Hijacking Vulnerability
**Vulnerability:** Setup Hijacking (`public/setup.php`)
**Learning:** The check to prevent re-execution of the setup script was placed *after* the POST handler. This allowed an unauthenticated attacker to bypass the check and overwrite the `.env` file or re-execute migrations by sending a POST request to an already configured application.
**Prevention:** Always place access control and state-validation checks at the very beginning of a script, immediately after bootstrapping (loading env vars/autoloader), and *before* processing any user input or state-modifying logic. Use `die()` or `exit()` immediately after redirection.
## 2024-07-11 - [HIGH] Fix IDOR in ApplicationController
**Vulnerability:** Insecure Direct Object Reference (IDOR) where a user could specify a `company_id` that belongs to another user when creating an application via `ApplicationController@store`.
**Learning:** When linking an object (like `Application`) to another object (like `Company`), we must verify that the referenced object actually belongs to the authenticated user. Failing to verify the relationship's ownership leads to cross-user data leakage or unauthorized associations.
**Prevention:** Always validate that foreign key inputs (`company_id`, etc.) resolve to an entity owned by `Auth::id()` before using them in `INSERT` or `UPDATE` statements.
