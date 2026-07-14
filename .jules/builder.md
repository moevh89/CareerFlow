
## 2024-07-14 - Alpine.js Template Security and Robustness

**Learning:** When implementing frontend features with Alpine.js, user-provided text must always be rendered using the `x-text` directive (e.g., `<span x-text="company.name"></span>`) to automatically HTML-escape the content and prevent XSS attacks. Additionally, when using dynamic variables in directives like `:href`, it is critical to use optional chaining (`?.`) or fallback checks (`<template x-if="...">`) to prevent `TypeError`s if a variable is null, which could break the entire component's reactivity.

**Action:** Always verify that user input is never rendered using raw string interpolation in the DOM, and safeguard dynamic bindings involving nested object properties.
