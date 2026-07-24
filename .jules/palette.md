## 2024-07-19 - Modal Accessibility Enhancement
**Learning:** Custom modals in Alpine.js require explicit accessibility implementations to ensure proper user experience and screen reader support.
**Action:** Always include accessibility features: `role="dialog"`, `aria-modal="true"`, `aria-labelledby`, an `@keydown.escape.window` event for closing, and use `$nextTick` with `x-ref` to automatically focus the primary input when building modals in this project.

## 2024-10-27 - Sidebar Navigation Keyboard Accessibility
**Learning:** Custom 'div' based interactive navigation items require explicit roles, tabindexes, and keyboard event handlers in Alpine.js to be accessible to keyboard users.
**Action:** When creating custom interactive elements (like navigation links using 'div'), always include 'role="button"', 'tabindex="0"', and Alpine.js keyboard event handlers ('@keydown.enter' and '@keydown.space.prevent') for full keyboard accessibility.
