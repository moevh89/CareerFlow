## 2026-07-19 - Alpine.js Modals and API endpoints

**Learning:** When implementing frontend views, I needed to combine the existing PHP JSON REST endpoints with Alpine.js state. The backend already had `CompanyController` and the `api/companies` endpoints registered, but the frontend was missing the view and the integration in `app.js`.

**Action:** Before creating backend endpoints or writing new features from scratch, thoroughly check the router and existing controllers to see if the feature is only partially missing (e.g. only missing in the frontend). Also, remember to carefully clean up temporary artifacts (sqlite files, log files, `.env`) after testing, avoiding committing them.

## 2026-07-22 - Frontend Implementation of Backend API Endpoint

**Learning:** The `/api/contacts` backend endpoints already existed in the routing (`public/index.php`) and controller (`src/Controllers/ContactController.php`), but there were no frontend UI components to consume them. Building out the frontend UI for pre-existing backend logic is a common pattern for partially implemented backlog features.

**Action:** When searching for pending backlog tasks, explicitly inspect `public/index.php` for routes that lack corresponding Alpine.js view components or functions in `public/js/app.js`.
