const TravelLoopAPI = (() => {
    const API_BASE = 'backend';

    const buildQuery = params => {
        const query = new URLSearchParams(params);
        return query.toString() ? `?${query.toString()}` : '';
    };

    async function request(endpoint, params = {}, method = 'POST') {
        const url = `${API_BASE}/${endpoint}` + (method === 'GET' ? buildQuery(params) : '');
        const options = {
            method,
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json',
            },
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
            create: data => request('trips.php?action=create', data),
            delete: trip_id => request('trips.php?action=delete', { trip_id }),
        },
        profile: {
            load: () => request('profile.php?action=load', {}, 'GET'),
            update: data => request('profile.php?action=update', data),
            delete: () => request('profile.php?action=delete', {}, 'GET'),
        },
        notes: {
            create: data => request('notes.php?action=create', data),
            update: data => request('notes.php?action=update', data),
            delete: note_id => request('notes.php?action=delete', { note_id }),
            list: () => request('notes.php?action=list', {}, 'GET'),
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
        search: {
            query: q => request('search.php', { q }, 'GET'),
        },
        admin: {
            stats: () => request('admin.php', {}, 'GET'),
        }
    };
})();

function showNotification(message, success = true) {
    window.alert(message);
}
