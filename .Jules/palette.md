## 2026-07-08 - Added explicit labels to forms
**Learning:** Using placeholders as labels is an accessibility anti-pattern because they disappear on focus and are often too low contrast. Inputs should always have explicit `<label>` elements.
**Action:** Always verify forms have explicit `<label>` elements bound to the input via `for` and `id`.
## 2026-07-09 - Alpine.js Modals Accessibility
**Learning:** Adding keyboard accessibility (Escape to close) and auto-focus (`$nextTick`) drastically improves modal usability in Alpine.js. Additionally, proper ARIA attributes (`role="dialog"`, `aria-modal="true"`, `aria-labelledby`) are essential for screen readers to understand custom modals.
**Action:** When implementing custom modals, ensure focus management, keyboard navigation (Escape), and ARIA semantics are always included.
