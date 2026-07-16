## 2024-05-27 - Setup Hijacking Vulnerability
**Vulnerability:** Setup Hijacking (`public/setup.php`)
**Learning:** The check to prevent re-execution of the setup script was placed *after* the POST handler. This allowed an unauthenticated attacker to bypass the check and overwrite the `.env` file or re-execute migrations by sending a POST request to an already configured application.
**Prevention:** Always place access control and state-validation checks at the very beginning of a script, immediately after bootstrapping (loading env vars/autoloader), and *before* processing any user input or state-modifying logic. Use `die()` or `exit()` immediately after redirection.
## 2024-07-16 - Prevent IDOR in ApplicationController

**Vulnerability:** Insecure Direct Object Reference (IDOR) where any user could create an application assigned to any company ID, regardless of who owned the company record, because there was no authorization check for `company_id`.

**Learning:** When users provide foreign keys referencing objects they should own, the application must explicitly verify ownership by querying the referenced table with `user_id = Auth::id()` before inserting the data.

**Prevention:** Always add authorization checks before creating records with foreign keys referencing user-specific resources, such as companies or contacts.
