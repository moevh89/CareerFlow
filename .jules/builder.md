## 2026-07-19 - Alpine.js Modals and API endpoints

**Learning:** When implementing frontend views, I needed to combine the existing PHP JSON REST endpoints with Alpine.js state. The backend already had `CompanyController` and the `api/companies` endpoints registered, but the frontend was missing the view and the integration in `app.js`.

**Action:** Before creating backend endpoints or writing new features from scratch, thoroughly check the router and existing controllers to see if the feature is only partially missing (e.g. only missing in the frontend). Also, remember to carefully clean up temporary artifacts (sqlite files, log files, `.env`) after testing, avoiding committing them.

## 2026-07-23 - Alpine.js Contacts Implementation

**Learning:** Implementing the Contacts frontend required mapping to an existing backend endpoint `ContactController` and ensuring full accessibility. I noticed that when querying for nullish variable properties inside Alpine.js views (like `contact.linkedin_profile`), optional chaining must be used inside data binding attributes (like `:href`) or `x-show` statements to prevent TypeErrors from breaking reactivity. Also, we can test frontend rendering in complete isolation via Playwright using Alpine.$data to mock local state instead of doing complex auth workflows.

**Action:** When implementing new UI screens with Alpine, continue injecting state programmatically via `page.evaluate()` for fast and reliable UI testing. Always use optional chaining on nullable data points in Alpine templates.
