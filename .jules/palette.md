## 2026-07-14 - Custom Modals with Alpine.js require full ARIA + escape handling
**Learning:** When creating custom modals with Alpine.js in this project, accessibility features are crucial for a good UX. They must include: role="dialog", aria-modal="true", aria-labelledby, an @keydown.escape.window event for closing, and using $nextTick with x-ref to automatically focus the primary input when opening.
**Action:** Always include full accessibility attributes and keyboard interactions for all Alpine.js modals in this app.
