## 2026-07-12 - [Toast Accessibility in Alpine.js]
**Learning:** Dynamic toast notifications generated purely in JavaScript (like in Alpine.js SPAs) are often missed by screen readers unless the container explicitly has `aria-live` (e.g., `aria-live="polite"`) and `aria-atomic="true"` set.
**Action:** Always add `aria-live` and `aria-atomic` attributes to the container of dynamically appended elements designed to give user feedback, such as toast notifications or inline error messages.
