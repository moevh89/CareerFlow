document.addEventListener('alpine:init', () => {
    Alpine.data('appData', () => ({
        isLoggedIn: false,
        currentView: 'dashboard',
        authMode: 'login', // 'login' or 'register'
        csrfToken: '',
        toasts: [],
        authForm: { name: '', email: '', password: '' },
        dashboardData: {},
        applications: [],
        funnelChartInstance: null,
        statuses: [
            {id: 1, name: 'Interessant'},
            {id: 2, name: 'Bewerbung geplant'},
            {id: 3, name: 'Bewerbung versendet'},
            {id: 4, name: 'Eingangsbestätigung'},
            {id: 5, name: 'Vorstellungsgespräch'},
            {id: 6, name: 'Zweitgespräch'},
            {id: 7, name: 'Angebot erhalten'},
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
            try {
                const res = await fetch('api/csrf-token');
                const data = await res.json();
                this.csrfToken = data.csrf_token;
            } catch (e) {
                console.error("CSRF fetch error", e);
            }
        },

        async checkAuth() {
            try {
                const res = await fetch('api/me');
                if (res.ok) {
                    this.isLoggedIn = true;
                    this.loadDashboard();
                    this.loadApplications();
                }
            } catch(e) {}
        },

        async login() {
            const res = await fetch('api/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email: this.authForm.email, password: this.authForm.password, csrf_token: this.csrfToken })
            });

            if (res.ok) {
                this.isLoggedIn = true;
                this.showToast('Erfolgreich angemeldet');
                this.authForm.password = '';
                this.loadDashboard();
                this.loadApplications();
            } else {
                const err = await res.json();
                this.showToast(err.error || 'Anmeldung fehlgeschlagen. Bitte prüfe deine Daten.');
            }
        },

        async register() {
            const res = await fetch('api/register', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ ...this.authForm, csrf_token: this.csrfToken })
            });

            if (res.ok) {
                this.isLoggedIn = true;
                this.showToast('Account erfolgreich erstellt und angemeldet');
                this.authForm.password = '';
                this.loadDashboard();
                this.loadApplications();
            } else {
                const err = await res.json();
                this.showToast(err.error || 'Registrierung fehlgeschlagen.');
            }
        },

        async logout() {
            await fetch('api/logout', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ csrf_token: this.csrfToken }) });
            this.isLoggedIn = false;
            this.authForm.password = '';
            this.currentView = 'dashboard';
            if (this.funnelChartInstance) {
                this.funnelChartInstance.destroy();
                this.funnelChartInstance = null;
            }
        },

        navigate(view) {
            this.currentView = view;
            if(view === 'dashboard') this.loadDashboard();
            if(view === 'board') this.loadApplications();
        },

        async loadDashboard() {
            const res = await fetch('api/dashboard');
            if (res.ok) {
                this.dashboardData = await res.json();
                this.renderFunnelChart();
            }
        },

        async loadApplications() {
            const res = await fetch('api/applications');
            if (res.ok) {
                this.applications = await res.json();
            }
        },

        async createApplication() {
            const res = await fetch('api/applications', {
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

        dragStart(e, app) {
            e.dataTransfer.setData('applicationId', app.id);
        },

        async drop(e, statusId) {
            const appId = e.dataTransfer.getData('applicationId');
            const app = this.applications.find(a => a.id == appId);

            if (app && app.status_id != statusId) {
                // Optimistic update
                app.status_id = statusId;

                const res = await fetch(`api/applications/${appId}/status`, {
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

        renderFunnelChart() {
            // Need a slight delay to ensure canvas is visible if switching views
            setTimeout(() => {
                const ctx = document.getElementById('funnelChart');
                if (!ctx) return;

                if (this.funnelChartInstance) {
                    this.funnelChartInstance.destroy();
                }

                const funnel = this.dashboardData.funnel || {};

                this.funnelChartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Interessant', 'Versendet', 'Gespräche', 'Angebote', 'Zusagen'],
                        datasets: [{
                            label: 'Anzahl',
                            data: [
                                funnel.interested || 0,
                                funnel.applied || 0,
                                funnel.interviews || 0,
                                funnel.offers || 0,
                                funnel.accepted || 0
                            ],
                            backgroundColor: [
                                '#6b7280', // gray
                                '#8b5cf6', // purple
                                '#f59e0b', // orange
                                '#14b8a6', // teal
                                '#10b981'  // green
                            ],
                            borderRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        indexAxis: 'y', // Makes it a horizontal bar chart to simulate a funnel
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            x: { beginAtZero: true, ticks: { stepSize: 1 } }
                        }
                    }
                });
            }, 100);
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
