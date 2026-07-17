## 2024-07-17 - New Application Modal Accessibility
**Learning:** Adding semantic ARIA attributes and keyboard shortcuts for modal windows ensures the UI conforms to standard a11y practices, specifically in custom components built with Alpine.js.
**Action:** When creating custom modals with Alpine.js in this project, always include accessibility features: `role="dialog"`, `aria-modal="true"`, `aria-labelledby`, an `@keydown.escape.window` event for closing, and use `$nextTick` with `x-ref` to automatically focus the primary input.
