## 2026-07-19 - Alpine.js Modals and API endpoints

**Learning:** When implementing frontend views, I needed to combine the existing PHP JSON REST endpoints with Alpine.js state. The backend already had `CompanyController` and the `api/companies` endpoints registered, but the frontend was missing the view and the integration in `app.js`.

**Action:** Before creating backend endpoints or writing new features from scratch, thoroughly check the router and existing controllers to see if the feature is only partially missing (e.g. only missing in the frontend). Also, remember to carefully clean up temporary artifacts (sqlite files, log files, `.env`) after testing, avoiding committing them.
## 2026-07-21 - Frontend Verification Dependencies in No-Node.js Repositories

**Learning:** When writing Playwright scripts to verify frontend changes locally in a repository that intentionally omits `package.json` (like this PHP/Alpine.js project), installing Playwright locally creates temporary `node_modules`, `package.json`, and `package-lock.json` files.

**Action:** When verifying frontend UI with Playwright in this no-Node.js repository, temporarily install the package locally (`npm install playwright` and `npx playwright install chromium`) for testing, but strictly delete `node_modules`, `package.json`, and `package-lock.json` before staging and committing.
## 2026-07-21 - Discovering partially implemented work

**Learning:** This repository has no BACKLOG.md, TODO.md, or ROADMAP.md files, and no explicit TODOs in the frontend files. I discovered the missing Contacts UI functionality by grepping the backend endpoints (specifically `src/Controllers/ContactController.php` and its registration in the router at `public/index.php`) and verifying it had no corresponding frontend component in `public/js/app.js` and `public/index.html`.

**Action:** When identifying pending backlog work, thoroughly check the router (`public/index.php`) and existing controllers to find partially implemented features, such as API endpoints that exist without corresponding Alpine.js frontend views.
