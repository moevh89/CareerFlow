## 2024-07-19 - Modal Accessibility Enhancement
**Learning:** Custom modals in Alpine.js require explicit accessibility implementations to ensure proper user experience and screen reader support.
**Action:** Always include accessibility features: `role="dialog"`, `aria-modal="true"`, `aria-labelledby`, an `@keydown.escape.window` event for closing, and use `$nextTick` with `x-ref` to automatically focus the primary input when building modals in this project.
## 2026-07-21 - Keyboard Accessibility for Custom Navigation
**Learning:** In Alpine.js applications, custom <div> based navigation items require role='button', tabindex='0', and explicit @keydown handlers (enter/space) to be fully accessible via keyboard.
**Action:** Always use semantic <button> or <a> tags, or explicitly add complete keyboard support and ARIA roles for custom <div> interactive elements.
