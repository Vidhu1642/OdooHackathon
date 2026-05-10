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
