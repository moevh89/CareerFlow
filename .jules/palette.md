## 2024-07-19 - Modal Accessibility Enhancement
**Learning:** Custom modals in Alpine.js require explicit accessibility implementations to ensure proper user experience and screen reader support.
**Action:** Always include accessibility features: `role="dialog"`, `aria-modal="true"`, `aria-labelledby`, an `@keydown.escape.window` event for closing, and use `$nextTick` with `x-ref` to automatically focus the primary input when building modals in this project.
## 2024-07-25 - Barrierefreiheit für Alpine.js Navigations-Elemente
**Learning:** Bei der Verwendung von `<div>`-Elementen als interaktive Navigationspunkte in Alpine.js fehlen standardmäßig Semantik und Tastatur-Zugänglichkeit (Tabbing und Bestätigung).
**Action:** Immer `role="button"`, `tabindex="0"` sowie explizite Event-Handler für `@keydown.enter` und `@keydown.space.prevent` hinzufügen, um vollständige Tastaturbedienung und Screenreader-Unterstützung zu gewährleisten.
