## 2024-05-27 - Setup Hijacking Vulnerability
**Vulnerability:** Setup Hijacking (`public/setup.php`)
**Learning:** The check to prevent re-execution of the setup script was placed *after* the POST handler. This allowed an unauthenticated attacker to bypass the check and overwrite the `.env` file or re-execute migrations by sending a POST request to an already configured application.
**Prevention:** Always place access control and state-validation checks at the very beginning of a script, immediately after bootstrapping (loading env vars/autoloader), and *before* processing any user input or state-modifying logic. Use `die()` or `exit()` immediately after redirection.
## 2024-05-24 - IDOR in Application Creation
**Vulnerability:** Insecure Direct Object Reference (IDOR) where users could create an application assigned to another user's `company_id`.
**Learning:** `ApplicationController::store()` did not validate if the provided `company_id` belonged to the authenticated user (`Auth::id()`) before saving, similar to the missing validation fixed in `ContactController`.
**Prevention:** Always ensure foreign keys provided in user input reference objects that the currently authenticated user owns or is authorized to access. Add a check `SELECT id FROM table WHERE id = ? AND user_id = ?` before insertion.
