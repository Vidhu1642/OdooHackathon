/* ========================================
   TRAVELOOP - REUSABLE COMPONENTS
   ======================================== */

// ===== SIDEBAR COMPONENT =====
function Sidebar({ active = '' } = {}) {
  const isActive = (path) => active === path ? 'active' : '';

  return `
    <aside class="sidebar">
      <div class="sidebar-logo">✈ Traveloop</div>
      <nav class="sidebar-nav">
        <a href="Dashboard.html" class="${isActive('dashboard')}">
          <span class="nav-icon">🏠</span> Dashboard
        </a>
        <a href="My-Trip.html" class="${isActive('trips')}">
          <span class="nav-icon">📍</span> My Trips
        </a>
        <a href="Search.html" class="${isActive('search')}">
          <span class="nav-icon">🔍</span> Search
        </a>
        <a href="Profile.html" class="${isActive('profile')}">
          <span class="nav-icon">👤</span> Profile
        </a>
        <a href="Activity-Search.html" class="${isActive('activities')}">
          <span class="nav-icon">🎯</span> Activities
        </a>
        <a href="Trip-Notes.html" class="${isActive('notes')}">
          <span class="nav-icon">📝</span> Trip Notes
        </a>
        <a href="#" onclick="logout()">
          <span class="nav-icon">🚪</span> Logout
        </a>
      </nav>
    </aside>
  `;
}

// ===== AUTH LAYOUT (for login/signup) =====
function AuthLayout(content) {
  return `
    <div class="auth-container">
      <div class="auth-split">
        <div class="auth-brand">
          <h1>✈ Traveloop</h1>
          <p>Plan your perfect trip with AI-powered itineraries, real-time collaboration, and smart budgeting tools.</p>
          <div class="auth-features">
            <div class="auth-feature">✅ Create detailed itineraries</div>
            <div class="auth-feature">✅ Track expenses & budget</div>
            <div class="auth-feature">✅ Share & collaborate</div>
          </div>
        </div>
        <div class="auth-form-container">
          ${content}
        </div>
      </div>
    </div>
  `;
}

// ===== MAIN LAYOUT (with sidebar) =====
function MainLayout(content, sidebarActive = '') {
  return `
    <div class="app-layout">
      ${Sidebar({ active: sidebarActive })}
      <main class="main-content">
        ${content}
      </main>
    </div>
  `;
}

// ===== PAGE HEADER =====
function PageHeader({ title, subtitle = '', actions = '' } = {}) {
  return `
    <header class="page-header">
      <div class="page-header-text">
        <h1>${title}</h1>
        ${subtitle ? `<p class="text-muted">${subtitle}</p>` : ''}
      </div>
      ${actions ? `<div class="page-header-actions">${actions}</div>` : ''}
    </header>
  `;
}

// ===== TRIP CARD =====
function TripCard(trip) {
  return `
    <div class="trip-card card">
      <div class="trip-card-image">
        <img src="${escapeHtml(trip.cover_photo || 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e')}" alt="${escapeHtml(trip.name)}" />
        <span class="trip-card-status badge badge-${trip.status === 'Completed' ? 'success' : 'warning'}">${escapeHtml(trip.status || 'Upcoming')}</span>
      </div>
      <div class="trip-card-body">
        <h3>${escapeHtml(trip.name)}</h3>
        <p class="text-muted">${escapeHtml(trip.description || 'No description')}</p>
        <div class="trip-card-meta">
          <span>📍 ${escapeHtml(trip.destination || 'Not set')}</span>
          <span>📅 ${formatDate(trip.start_date)}</span>
          <span>💰 ${formatMoney(trip.budget)}</span>
        </div>
        <div class="trip-card-actions">
          <button class="btn btn-primary" onclick="window.location.href='Itinerary-View.html?trip_id=${trip.id}'">View</button>
          <button class="btn btn-warning" onclick="window.location.href='Itinerary.html?trip_id=${trip.id}'">Edit</button>
          <button class="btn btn-danger" onclick="deleteTrip(${trip.id})">Delete</button>
        </div>
      </div>
    </div>
  `;
}

// ===== MODAL COMPONENT =====
function Modal({ id, title, content, actions = '' } = {}) {
  return `
    <div class="modal-overlay" id="${id}-overlay" onclick="closeModal('${id}')">
      <div class="modal" onclick="event.stopPropagation()">
        <div class="modal-header">
          <h3>${title}</h3>
          <button class="modal-close" onclick="closeModal('${id}')">&times;</button>
        </div>
        <div class="modal-body">${content}</div>
        ${actions ? `<div class="modal-footer">${actions}</div>` : ''}
      </div>
    </div>
  `;
}

function openModal(id) {
  document.getElementById(id + '-overlay').classList.add('active');
}

function closeModal(id) {
  document.getElementById(id + '-overlay').classList.remove('active');
}

// ===== TABS COMPONENT =====
function Tabs({ tabs, activeTab, onChange } = {}) {
  return `
    <div class="tabs">
      ${tabs.map(tab => `
        <button class="tab ${activeTab === tab.id ? 'active' : ''}" data-tab="${tab.id}">
          ${tab.icon || ''} ${tab.label}
        </button>
      `).join('')}
    </div>
  `;
}

// ===== LOADING SKELETON =====
function LoadingSkeleton({ rows = 3, type = 'card' } = {}) {
  if (type === 'list') {
    return Array(rows).fill('<div class="skeleton skeleton-list"></div>').join('');
  }
  return `
    <div class="grid grid-2">
      ${Array(rows).fill('<div class="skeleton skeleton-card"></div>').join('')}
    </div>
  `;
}

// Logout helper
async function logout() {
  try {
    await TravelLoopAPI.auth.logout();
    app.state.user = null;
    app.navigate('/');
    showNotification('Logged out successfully');
  } catch (err) {
    showNotification(err.message, false);
  }
}

// Delete trip helper
async function deleteTrip(id) {
  if (confirm('Delete this trip permanently?')) {
    try {
      await TravelLoopAPI.trips.delete(id);
      showNotification('Trip deleted');
      // Re-render current view
      app.handleRoute();
    } catch (err) {
      showNotification(err.message, false);
    }
  }
}
