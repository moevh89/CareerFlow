## 2024-05-27 - Setup Hijacking Vulnerability
**Vulnerability:** Setup Hijacking (`public/setup.php`)
**Learning:** The check to prevent re-execution of the setup script was placed *after* the POST handler. This allowed an unauthenticated attacker to bypass the check and overwrite the `.env` file or re-execute migrations by sending a POST request to an already configured application.
**Prevention:** Always place access control and state-validation checks at the very beginning of a script, immediately after bootstrapping (loading env vars/autoloader), and *before* processing any user input or state-modifying logic. Use `die()` or `exit()` immediately after redirection.

## 2024-07-23 - IDOR in Foreign Key Assignment
**Vulnerability:** Missing Authorization Check on Foreign Keys (`ApplicationController::store`)
**Learning:** Even if an endpoint requires authentication to be accessed, accepting foreign key IDs (like `company_id`) in POST payloads without verifying that the authenticated user owns or is authorized to use that foreign object leads to Insecure Direct Object Reference (IDOR) vulnerabilities.
**Prevention:** Always ensure foreign keys provided in user input are validated against the currently authenticated user (`Auth::id()`) before being inserted or used in database queries.
