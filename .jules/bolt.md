## 2026-07-09 - Unused CDN dependencies
**Learning:** Found a heavy (Chart.js) script loaded synchronously from CDN which was completely unused. Simple check for usage before adding comments/optimizing can yield big wins.
**Action:** Always run a codebase search (`grep -rin`) for a library name before trying to lazy-load or optimize its usage, as it might just be dead code that can be safely removed.
