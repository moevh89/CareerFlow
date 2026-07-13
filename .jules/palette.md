## 2026-07-13 - Modal UX and Accessibility Enhancements
**Learning:** Alpine.js x-show modals lack native dialog accessibility features (role, aria-modal, focus trapping/management, escape key closing).
**Action:** When implementing custom modals with Alpine.js, always add `role="dialog"`, `aria-modal="true"`, `aria-labelledby="..."`, `@keydown.escape.window="..."`, and use `$nextTick` with `x-ref` to automatically focus the first input for a better user experience and keyboard accessibility.
