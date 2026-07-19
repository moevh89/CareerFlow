## 2024-05-27 - Setup Hijacking Vulnerability
**Vulnerability:** Setup Hijacking (`public/setup.php`)
**Learning:** The check to prevent re-execution of the setup script was placed *after* the POST handler. This allowed an unauthenticated attacker to bypass the check and overwrite the `.env` file or re-execute migrations by sending a POST request to an already configured application.
**Prevention:** Always place access control and state-validation checks at the very beginning of a script, immediately after bootstrapping (loading env vars/autoloader), and *before* processing any user input or state-modifying logic. Use `die()` or `exit()` immediately after redirection.
## 2024-05-18 - [Fix Insecure Direct Object Reference (IDOR) in Application Creation]
**Vulnerability:** The application creation endpoint (`/api/applications`) allowed linking a new application to any company by providing its `company_id`. It did not check whether the company belonged to the authenticated user.
**Learning:** This is an Insecure Direct Object Reference (IDOR) vulnerability. It occurred because the application directly used the user-provided `company_id` without verifying the user's authorization to access or associate with that specific company object.
**Prevention:** Always validate that foreign keys provided in user input reference objects that the currently authenticated user owns or is authorized to access (e.g., checking against `Auth::id()`) before performing database operations like insertion or updates.
