## 2026-07-08 - Added explicit labels to forms
**Learning:** Using placeholders as labels is an accessibility anti-pattern because they disappear on focus and are often too low contrast. Inputs should always have explicit `<label>` elements.
**Action:** Always verify forms have explicit `<label>` elements bound to the input via `for` and `id`.
