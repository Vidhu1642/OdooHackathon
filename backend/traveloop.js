const TravelLoopAPI = (() => {
    const API_BASE = 'backend';

    const buildQuery = (endpoint, params) => {
        const query = new URLSearchParams(params);
        if (!query.toString()) {
            return '';
        }
        return `${endpoint.includes('?') ? '&' : '?'}${query.toString()}`;
    };

    async function request(endpoint, params = {}, method = 'POST') {
        const url = `${API_BASE}/${endpoint}` + (method === 'GET' ? buildQuery(endpoint, params) : '');
        const options = {
            method,
            credentials: 'include', // Important for PHP Sessions
            headers: { 'Content-Type': 'application/json' },
        };

        if (method !== 'GET' && Object.keys(params).length) {
            options.body = JSON.stringify(params);
        }

        const response = await fetch(url, options);
        const data = await response.json();
        if (!response.ok || data.success === false) {
            throw new Error(data.message || 'Backend request failed');
        }
        return data;
    }

    return {
        auth: {
            login: (email, password) => request('auth.php?action=login', { email, password }),
            register: (full_name, email, password) => request('auth.php?action=register', { full_name, email, password }),
            logout: () => request('auth.php?action=logout', {}, 'GET'),
            status: () => request('auth.php?action=status', {}, 'GET'),
        },
        trips: {
            list: () => request('trips.php?action=list', {}, 'GET'),
            get: trip_id => request('trips.php?action=get', { trip_id }, 'GET'),
            create: data => request('trips.php?action=create', data),
            update: data => request('trips.php?action=update', data),
            delete: trip_id => request('trips.php?action=delete', { trip_id }),
        },
        itinerary: {
            save: data => request('itinerary.php?action=save', data),
            load: itinerary_id => request('itinerary.php?action=load', { itinerary_id }, 'GET'),
            share: token => request('itinerary.php?action=share', { token }, 'GET'),
        },
        budget: {
            save: data => request('budget.php?action=save', data),
            get: trip_id => request('budget.php?action=get', { trip_id }, 'GET'),
        },
        notes: {
            list: () => request('notes.php?action=list', {}, 'GET'),
            get: note_id => request('notes.php?action=get', { note_id }, 'GET'),
            create: data => request('notes.php?action=create', data),
            update: data => request('notes.php?action=update', data),
            delete: note_id => request('notes.php?action=delete', { note_id }),
        },
        profile: {
            load: () => request('profile.php?action=load', {}, 'GET'),
            update: data => request('profile.php?action=update', data),
            delete: () => request('profile.php?action=delete'),
        },
        search: {
            query: q => request('search.php', { q }, 'GET'),
        },
        admin: {
            stats: () => request('admin.php', {}, 'GET'),
        }
    };
})();

function showNotification(message, success = true) {
    let toast = document.getElementById('appToast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'appToast';
        toast.setAttribute('role', 'status');
        toast.style.cssText = [
            'position:fixed',
            'right:20px',
            'bottom:20px',
            'z-index:9999',
            'max-width:360px',
            'padding:14px 18px',
            'border-radius:10px',
            'box-shadow:0 12px 30px rgba(15,23,42,.18)',
            'color:#fff',
            'font:600 14px/1.4 Arial,Helvetica,sans-serif',
            'opacity:0',
            'transform:translateY(12px)',
            'transition:opacity .2s ease, transform .2s ease'
        ].join(';');
        document.body.appendChild(toast);
    }

    toast.textContent = message;
    toast.style.background = success ? '#059669' : '#dc2626';
    toast.style.opacity = '1';
    toast.style.transform = 'translateY(0)';

    window.clearTimeout(showNotification.hideTimer);
    showNotification.hideTimer = window.setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(12px)';
    }, 3000);
}
