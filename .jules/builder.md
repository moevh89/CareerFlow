## 2026-07-19 - Alpine.js Modals and API endpoints

**Learning:** When implementing frontend views, I needed to combine the existing PHP JSON REST endpoints with Alpine.js state. The backend already had `CompanyController` and the `api/companies` endpoints registered, but the frontend was missing the view and the integration in `app.js`.

**Action:** Before creating backend endpoints or writing new features from scratch, thoroughly check the router and existing controllers to see if the feature is only partially missing (e.g. only missing in the frontend). Also, remember to carefully clean up temporary artifacts (sqlite files, log files, `.env`) after testing, avoiding committing them.
