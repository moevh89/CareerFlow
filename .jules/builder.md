## 2026-07-18 - Implement Companies UI

**Learning:** Missing tracking of local sqlite database leads to accidental commit.
**Action:** Always check `git status` for untracked files like `.sqlite` or `.db` generated during local testing and ensure they are removed or added to `.gitignore`.
