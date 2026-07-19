## 2024-07-19 - Modal Accessibility Enhancement
**Learning:** Custom modals in Alpine.js require explicit accessibility implementations to ensure proper user experience and screen reader support.
**Action:** Always include accessibility features: `role="dialog"`, `aria-modal="true"`, `aria-labelledby`, an `@keydown.escape.window` event for closing, and use `$nextTick` with `x-ref` to automatically focus the primary input when building modals in this project.
