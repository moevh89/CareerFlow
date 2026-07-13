## 2026-07-13 - Alpine.js optional chaining

**Learning:** When using x-show to conditionally hide elements with null values, Alpine still evaluates bindings within that element (like :href). Calling string methods on potentially null variables (like `company.website.startsWith`) throws a TypeError and breaks reactivity.

**Action:** Always use optional chaining (e.g. `website?.startsWith`) when evaluating variables that can be null, even inside elements conditionally hidden by `x-show`.
