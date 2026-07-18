## 2024-07-18 - Init

## 2026-07-18 - Modal Accessibility
**Learning:** Simple modal implementations often miss basic accessibility features like ARIA roles, Escape key support, and auto-focusing the primary input, which breaks keyboard navigation.
**Action:** When creating custom modals with Alpine.js in this project, always include role="dialog", aria-modal="true", aria-labelledby, an @keydown.escape.window event for closing, and use $nextTick with x-ref to automatically focus the primary input.
