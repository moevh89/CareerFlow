document.addEventListener('alpine:init', () => {
    Alpine.data('appData', () => ({
        isLoggedIn: false,
        currentView: 'dashboard',
        csrfToken: '',
        toasts: [],
        authForm: { email: '', password: '' },
        dashboardData: {},
        applications: [],
        statuses: [
            {id: 1, name: 'Interessant'},
            {id: 2, name: 'Bewerbung geplant'},
            {id: 3, name: 'Bewerbung versendet'},
            {id: 4, name: 'Vorstellungsgespräch'},
            {id: 8, name: 'Zusage'},
            {id: 9, name: 'Absage'}
        ],
        showNewAppModal: false,
        newAppForm: { job_title: '' },

        async init() {
            await this.fetchCsrf();
            await this.checkAuth();
        },

        async fetchCsrf() {
            const res = await fetch('/api/csrf-token');
            const data = await res.json();
            this.csrfToken = data.csrf_token;
        },

        async checkAuth() {
            const res = await fetch('/api/me');
            if (res.ok) {
                this.isLoggedIn = true;
                this.loadDashboard();
                this.loadApplications();
            }
        },

        async login() {
            const res = await fetch('/api/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ ...this.authForm, csrf_token: this.csrfToken })
            });

            if (res.ok) {
                this.isLoggedIn = true;
                this.showToast('Erfolgreich angemeldet');
                this.loadDashboard();
                this.loadApplications();
            } else {
                this.showToast('Login fehlgeschlagen');
            }
        },

        async logout() {
            await fetch('/api/logout', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ csrf_token: this.csrfToken }) });
            this.isLoggedIn = false;
            this.authForm.password = '';
        },

        navigate(view) {
            this.currentView = view;
            if(view === 'dashboard') this.loadDashboard();
            if(view === 'board') this.loadApplications();
        },

        async loadDashboard() {
            const res = await fetch('/api/dashboard');
            if (res.ok) {
                this.dashboardData = await res.json();
            }
        },

        async loadApplications() {
            const res = await fetch('/api/applications');
            if (res.ok) {
                this.applications = await res.json();
            }
        },

        async createApplication() {
            const res = await fetch('/api/applications', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ ...this.newAppForm, csrf_token: this.csrfToken })
            });

            if (res.ok) {
                this.showToast('Bewerbung angelegt');
                this.showNewAppModal = false;
                this.newAppForm.job_title = '';
                this.loadApplications();
                this.loadDashboard();
            }
        },

        dragStart(e, app) {
            e.dataTransfer.setData('applicationId', app.id);
        },

        async drop(e, statusId) {
            const appId = e.dataTransfer.getData('applicationId');
            const app = this.applications.find(a => a.id == appId);

            if (app && app.status_id != statusId) {
                // Optimistic update
                app.status_id = statusId;

                const res = await fetch(`/api/applications/${appId}/status`, {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ status_id: statusId, csrf_token: this.csrfToken })
                });

                if (!res.ok) {
                    this.showToast('Fehler beim Aktualisieren');
                    this.loadApplications(); // Revert on failure
                } else {
                    this.loadDashboard(); // Update counts
                }
            }
        },

        showToast(message) {
            const id = Date.now();
            this.toasts.push({ id, message });
            setTimeout(() => {
                this.toasts = this.toasts.filter(t => t.id !== id);
            }, 3000);
        }
    }));
});
