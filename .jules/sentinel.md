## 2024-05-27 - Setup Hijacking Vulnerability
**Vulnerability:** Setup Hijacking (`public/setup.php`)
**Learning:** The check to prevent re-execution of the setup script was placed *after* the POST handler. This allowed an unauthenticated attacker to bypass the check and overwrite the `.env` file or re-execute migrations by sending a POST request to an already configured application.
**Prevention:** Always place access control and state-validation checks at the very beginning of a script, immediately after bootstrapping (loading env vars/autoloader), and *before* processing any user input or state-modifying logic. Use `die()` or `exit()` immediately after redirection.
## 2026-07-14 - Session Fixation and Missing Secure Cookie Attributes
**Vulnerability:** The application was vulnerable to Session Fixation because it didn't regenerate the session ID on login. It also lacked secure cookie attributes (HttpOnly, SameSite, Secure) for its session cookie, leaving it open to XSS theft and CSRF.
**Learning:** PHP's default session configurations are often insecure. `session_start()` alone does not protect against fixation, and default cookie params do not set `HttpOnly` or `SameSite`.
**Prevention:** Always call `session_regenerate_id(true)` upon authentication/privilege escalation. Always configure `session_set_cookie_params()` with secure attributes before calling `session_start()`.
