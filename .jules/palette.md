## 2023-10-27 - Keyboard Navigation & Focus States
**Learning:** Using `<div>` elements for interactive navigation menus prevents native keyboard accessibility (Tab focus and Enter/Space activation). Custom focus states are often missing on interactive elements like buttons and inputs, making keyboard navigation difficult for users who rely on visual focus indicators.
**Action:** Always use semantic HTML elements like `<button>` or `<a>` for interactive elements. Ensure clear `:focus-visible` styles are defined in the global CSS for all interactive elements to support keyboard users.
