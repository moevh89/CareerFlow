document.addEventListener('alpine:init', () => {
    Alpine.data('appData', () => ({
        isLoggedIn: false,
        currentView: 'dashboard',
        csrfToken: '',
        toasts: [],
        authForm: { email: '', password: '' },
        dashboardData: {},
        applications: [],
        companies: [],
        contacts: [],
        showNewCompanyModal: false,
        showNewContactModal: false,
        newContactForm: { company_id: '', name: '', position: '', email: '', phone: '', linkedin_profile: '', notes: '' },
        newCompanyForm: { name: '', industry: '', location: '', website: '' },
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
                this.loadCompanies();
                this.loadContacts();
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
                this.loadCompanies();
                this.loadContacts();
            } else {
                this.showToast('Anmeldung fehlgeschlagen. Bitte prüfe deine Daten.');
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
            if(view === 'companies') this.loadCompanies();
            if(view === 'contacts') this.loadContacts();
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

        async loadCompanies() {
            const res = await fetch('/api/companies');
            if (res.ok) {
                this.companies = await res.json();
            }
        },

        async loadContacts() {
            const res = await fetch('/api/contacts');
            if (res.ok) {
                this.contacts = await res.json();
            }
        },

        async createCompany() {
            const res = await fetch('/api/companies', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ ...this.newCompanyForm, csrf_token: this.csrfToken })
            });

            if (res.ok) {
                this.showToast('Firma erfolgreich angelegt');
                this.showNewCompanyModal = false;
                this.newCompanyForm = { name: '', industry: '', location: '', website: '' };
                this.loadCompanies();
            } else {
                this.showToast('Fehler beim Anlegen der Firma');
            }
        },

        async createApplication() {
            const res = await fetch('/api/applications', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ ...this.newAppForm, csrf_token: this.csrfToken })
            });

            if (res.ok) {
                this.showToast('Bewerbung erfolgreich angelegt');
                this.showNewAppModal = false;
                this.newAppForm.job_title = '';
                this.loadApplications();
                this.loadDashboard();
            } else {
                this.showToast('Fehler beim Anlegen der Bewerbung');
            }
        },

        async createContact() {
            const res = await fetch('/api/contacts', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ ...this.newContactForm, csrf_token: this.csrfToken })
            });

            if (res.ok) {
                this.showToast('Kontakt erfolgreich angelegt');
                this.showNewContactModal = false;
                this.newContactForm = { company_id: '', name: '', position: '', email: '', phone: '', linkedin_profile: '', notes: '' };
                this.loadContacts();
            } else {
                this.showToast('Fehler beim Anlegen des Kontakts');
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
                    this.showToast('Fehler beim Aktualisieren des Status');
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
