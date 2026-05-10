/* ========================================
   TRAVELOOP - SPA APP SHELL & ROUTER
   ======================================== */

class TravelLoopApp {
  constructor() {
    this.state = {
      user: null,
      currentRoute: '/',
      isLoading: false
    };
    this.routes = {};
    this.listeners = [];
    this.init();
  }

  init() {
    window.addEventListener('popstate', () => this.handleRoute());
    document.addEventListener('click', e => {
      const link = e.target.closest('[data-link]');
      if (link) { e.preventDefault(); this.navigate(link.getAttribute('href')); }
    });
    this.checkAuth();
  }

  // ===== ROUTING =====
  registerRoute(path, renderFn) {
    this.routes[path] = renderFn;
  }

  navigate(path, replace = false) {
    if (replace) history.replaceState(null, '', path);
    else history.pushState(null, '', path);
    this.handleRoute();
  }

  async handleRoute() {
    const path = window.location.pathname;
    const search = window.location.search;
    const route = path + search;

    // Find matching route
    let handler = this.routes[route] || this.routes[path] || this.routes['*'];

    if (!handler) {
      // Try dynamic routes like /trip/1
      for (const [key, fn] of Object.entries(this.routes)) {
        if (key.includes(':')) {
          const pattern = key.replace(/:\w+/g, '([^/]+)');
          const regex = new RegExp(`^${pattern}$`);
          if (regex.test(path)) {
            handler = fn;
            break;
          }
        }
      }
    }

    // Default: 404 or home
    if (!handler) handler = () => this.render404();

    document.getElementById('app').innerHTML = '<div class="loading"><div class="spinner"></div></div>';
    try {
      await handler({ path, search });
    } catch (err) {
      console.error('Route error:', err);
      this.renderError(err.message);
    }
  }

  // ===== AUTH =====
  async checkAuth() {
    try {
      const res = await TravelLoopAPI.auth.status();
      this.state.user = res.user;
      this.notify();
    } catch {
      this.state.user = null;
    }
  }

  requireAuth(callback) {
    if (!this.state.user) {
      this.navigate('/');
      return false;
    }
    return true;
  }

  // ===== STATE =====
  subscribe(fn) { this.listeners.push(fn); }
  notify() { this.listeners.forEach(fn => fn(this.state)); }

  // ===== UTILITIES =====
  renderError(msg) {
    document.getElementById('app').innerHTML = `
      <div class="empty-state">
        <h3>⚠ Error</h3>
        <p>${escapeHtml(msg)}</p>
        <button class="btn btn-primary" onclick="app.navigate('/')">Go Home</button>
      </div>
    `;
  }

  render404() {
    document.getElementById('app').innerHTML = `
      <div class="empty-state">
        <h3>🔍 Page Not Found</h3>
        <p>The page you're looking for doesn't exist.</p>
        <button class="btn btn-primary" onclick="app.navigate('/')">Go Home</button>
      </div>
    `;
  }
}

// Global app instance
const app = new TravelLoopApp();

// ===== ROUTE REGISTRATIONS =====

// User Dashboard View
app.registerRoute('/', async () => {
  const user = app.state.user || { full_name: 'Traveler' };

  // 1. Render the initial layout structure while data loads
  document.getElementById('app').innerHTML = `
    <div style="margin-bottom: 30px;">
      <h1>Welcome back, ${escapeHtml(user.full_name)}! 👋</h1>
      <p style="color:#6b7280; margin-top:8px;">Here is your personal travel overview.</p>
    </div>
    
    <!-- STATS GRID -->
    <div id="userStatsGrid" class="stats-grid">
      <p style="color:#6b7280; padding: 20px;">Loading stats...</p>
    </div>

    <!-- RECENT TRIPS -->
    <div style="margin-top: 40px;">
      <h2 style="margin-bottom: 20px; color: #111827;">Your Recent Trips</h2>
      <div id="userRecentTrips" style="display:flex; flex-wrap:wrap; gap:20px;">
        <p style="color:#6b7280; padding: 20px;">Loading trips...</p>
      </div>
    </div>
  `;

  // 2. Fetch the actual user data from the backend API
  try {
    const res = await TravelLoopAPI.trips.list();
    const trips = res.trips || [];
    
    // Calculate dynamic stats
    const totalTrips = trips.length;
    const completed = trips.filter(t => t.status === 'Completed').length;
    const upcoming = trips.filter(t => t.status === 'Upcoming').length;
    const totalBudget = trips.reduce((sum, t) => sum + (Number(t.budget) || 0), 0);

    // Inject calculated stats
    document.getElementById('userStatsGrid').innerHTML = `
      <div class="stat-card"><h3>Total Trips</h3><h2>${totalTrips}</h2></div>
      <div class="stat-card"><h3>Completed Trips</h3><h2>${completed}</h2></div>
      <div class="stat-card"><h3>Upcoming Trips</h3><h2>${upcoming}</h2></div>
      <div class="stat-card"><h3>Total Budget Planned</h3><h2>${formatMoney(totalBudget)}</h2></div>
    `;

    // Inject recent trips loop
    const recentEl = document.getElementById('userRecentTrips');
    if (trips.length === 0) {
      recentEl.innerHTML = `
        <div style="background:white; width:100%; padding:40px; text-align:center; border-radius:25px; box-shadow:0 8px 20px rgba(0,0,0,0.08);">
          <h3 style="margin-bottom: 10px;">🌍 No trips yet</h3>
          <p style="color:#6b7280; margin-bottom: 20px;">Create your first trip to get started!</p>
          <button style="background:#2563eb; color:white; padding:12px 24px; border:none; border-radius:10px; cursor:pointer; font-weight:bold;" onclick="app.navigate('/create-trip')">+ Create Trip</button>
        </div>
      `;
    } else {
      recentEl.innerHTML = trips.slice(0, 4).map(trip => `
        <div style="background:white; border-radius:25px; overflow:hidden; box-shadow:0 8px 20px rgba(0,0,0,0.08); width: calc(33.333% - 14px); min-width: 280px;">
          <img src="${escapeHtml(trip.cover_photo || 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e')}" style="width:100%; height:180px; object-fit:cover;">
          <div style="padding:25px;">
            <h3 style="margin-bottom:10px; color:#111827;">${escapeHtml(trip.name)}</h3>
            <p style="color:#6b7280; margin-bottom:20px; font-size: 14px;">📍 ${escapeHtml(trip.destination || 'Not set')}</p>
            <div style="display:flex; justify-content:space-between; align-items:center;">
              <span style="font-weight:bold; color:#2563eb; font-size:18px;">${formatMoney(trip.budget)}</span>
              <span style="background:#dcfce7; color:#166534; padding:6px 12px; border-radius:20px; font-size:12px; font-weight:bold;">${escapeHtml(trip.status || 'Upcoming')}</span>
            </div>
          </div>
        </div>
      `).join('');
    }
  } catch (error) {
    document.getElementById('userStatsGrid').innerHTML = `<p style="color:red; padding: 20px;">Failed to load data: ${error.message}</p>`;
  }
});

// Admin Dashboard View
app.registerRoute('/admin', async () => {
  document.getElementById('app').innerHTML = `
    <!-- STATS -->
    <div class="stats-grid">
      <div class="stat-card">
        <h3>Total Users</h3>
        <h2 id="adminUsersValue">...</h2>
        <div class="growth">+18% This Month</div>
      </div>
      <div class="stat-card">
        <h3>Total Trips</h3>
        <h2 id="adminTripsValue">...</h2>
        <div class="growth">+12% This Month</div>
      </div>
      <div class="stat-card">
        <h3>Active Users</h3>
        <h2 id="adminActiveUsersValue">...</h2>
        <div class="growth">+9% This Week</div>
      </div>
      <div class="stat-card">
        <h3>Shared Itineraries</h3>
        <h2 id="adminItinerariesValue">...</h2>
        <div class="growth">+25% Growth</div>
      </div>
    </div>

    <!-- ANALYTICS -->
    <div class="analytics-grid">
      <div class="chart-card">
        <h2>User Engagement Analytics</h2>
        <div class="chart-placeholder">
          📈 Analytics Chart Placeholder
          <p style="margin-top:15px; color:#6b7280; font-size:15px;">
            Monthly active users and trip creation trends
          </p>
        </div>
      </div>

      <div class="chart-card">
        <h2>Popular Destinations 🌍</h2>
        <div class="destination-list" id="adminDestinationsList">
            <p style="padding:20px; color:#6b7280;">Loading destinations...</p>
        </div>
      </div>
    </div>

    <!-- USERS TABLE -->
    <div class="table-card">
      <h2>User Management 👥</h2>
      <table>
        <thead>
          <tr>
            <th>User</th>
            <th>Email</th>
            <th>Trips</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="adminUserTableBody">
            <tr><td colspan="5" style="text-align:center; padding:40px; color:#6b7280;">Loading user data...</td></tr>
        </tbody>
      </table>
    </div>
  `;

  // Fetch data after the view is mounted to the DOM
  if (typeof loadAdminStats === 'function') {
    await loadAdminStats();
  }
});
