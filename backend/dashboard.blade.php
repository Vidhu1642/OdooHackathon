<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard - Traveloop</title>

  <style>
    *{
      margin:0;
      padding:0;
      box-sizing:border-box;
      font-family:Arial, Helvetica, sans-serif;
    }
    body{
      background:#f3f4f6;
      display:flex;
    }
    /* SIDEBAR */
    .sidebar{
      width:270px;
      height:100vh;
      background:#111827;
      color:white;
      padding:30px 20px;
      position:fixed;
      top:0;
      left:0;
      overflow-y:auto;
    }
    .logo{
      font-size:32px;
      font-weight:bold;
      margin-bottom:40px;
      color:#60a5fa;
    }
    .menu{
      list-style:none;
    }
    .menu li{
      margin:18px 0;
    }
    .menu a{
      text-decoration:none;
      color:white;
      font-size:17px;
      display:block;
      padding:14px;
      border-radius:12px;
      transition:0.3s;
    }
    .menu a:hover{
      background:#1f2937;
    }
    /* MAIN */
    .main{
      margin-left:270px;
      width:calc(100% - 270px);
      padding:40px;
    }
    /* TOPBAR */
    .topbar{
      display:flex;
      justify-content:space-between;
      align-items:center;
      margin-bottom:40px;
      flex-wrap:wrap;
      gap:20px;
    }
    .topbar h1{
      font-size:40px;
      color:#111827;
    }
    .topbar p{
      color:#6b7280;
      margin-top:8px;
    }
    .admin-profile{
      display:flex;
      align-items:center;
      gap:15px;
    }
    .admin-profile img{
      width:55px;
      height:55px;
      border-radius:50%;
      object-fit:cover;
    }
    /* STATS */
    .stats-grid{
      display:grid;
      grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
      gap:25px;
      margin-bottom:40px;
    }
    .stat-card{
      background:white;
      padding:30px;
      border-radius:25px;
      box-shadow:0 8px 20px rgba(0,0,0,0.08);
      transition:0.3s;
    }
    .stat-card:hover{
      transform:translateY(-5px);
    }
    .stat-card h3{
      color:#6b7280;
      margin-bottom:15px;
      font-size:16px;
    }
    .stat-card h2{
      font-size:42px;
      color:#111827;
      margin-bottom:10px;
    }
    .growth{
      color:#059669;
      font-weight:bold;
    }
    /* ANALYTICS */
    .analytics-grid{
      display:grid;
      grid-template-columns:2fr 1fr;
      gap:30px;
      margin-bottom:40px;
    }
    .chart-card{
      background:white;
      padding:30px;
      border-radius:25px;
      box-shadow:0 8px 20px rgba(0,0,0,0.08);
    }
    .chart-card h2{
      margin-bottom:25px;
      color:#111827;
    }
    /* CHART PLACEHOLDER */
    .chart-placeholder{
      height:320px;
      background:linear-gradient(to top, #dbeafe, #eff6ff);
      border-radius:20px;
      display:flex;
      justify-content:center;
      align-items:center;
      flex-direction:column;
      color:#2563eb;
      font-size:20px;
      font-weight:bold;
    }
    /* POPULAR DESTINATIONS */
    .destination-list{
      display:flex;
      flex-direction:column;
      gap:18px;
    }
    .destination-item{
      display:flex;
      justify-content:space-between;
      align-items:center;
      background:#f9fafb;
      padding:18px;
      border-radius:15px;
    }
    .destination-left{
      display:flex;
      align-items:center;
      gap:15px;
    }
    .destination-left img{
      width:60px;
      height:60px;
      border-radius:15px;
      object-fit:cover;
    }
    .destination-info h3{
      color:#111827;
      margin-bottom:5px;
    }
    .destination-info p{
      color:#6b7280;
      font-size:14px;
    }
    .trip-count{
      font-size:18px;
      font-weight:bold;
      color:#2563eb;
    }
    /* USERS TABLE */
    .table-card{
      background:white;
      padding:30px;
      border-radius:25px;
      box-shadow:0 8px 20px rgba(0,0,0,0.08);
      overflow-x:auto;
    }
    .table-card h2{
      margin-bottom:25px;
      color:#111827;
    }
    table{
      width:100%;
      border-collapse:collapse;
    }
    table th{
      background:#eff6ff;
      color:#2563eb;
      padding:16px;
      text-align:left;
      font-size:15px;
    }
    table td{
      padding:16px;
      border-bottom:1px solid #e5e7eb;
      color:#374151;
    }
    .status{
      padding:8px 14px;
      border-radius:20px;
      font-size:13px;
      font-weight:bold;
      display:inline-block;
    }
    .active{
      background:#dcfce7;
      color:#166534;
    }
    .inactive{
      background:#fee2e2;
      color:#991b1b;
    }
    /* ACTION BUTTONS */
    .action-btn{
      border:none;
      padding:10px 16px;
      border-radius:10px;
      cursor:pointer;
      font-size:14px;
      font-weight:bold;
      margin-right:8px;
    }
    .view-btn{
      background:#2563eb;
      color:white;
    }
    .delete-btn{
      background:#ef4444;
      color:white;
    }
    /* RESPONSIVE */
    @media(max-width:1100px){
      .sidebar{ display:none; }
      .main{ margin-left:0; width:100%; }
      .analytics-grid{ grid-template-columns:1fr; }
    }
  </style>
</head>
<body>

  <!-- SIDEBAR -->
  <div class="sidebar">
    <div class="logo">Traveloop Admin</div>
    <ul class="menu">
      <li><a href="{{ url('admin/dashboard') }}">🏠 Dashboard</a></li>
      <li><a href="{{ url('trips/create') }}">✈ Create Trip</a></li>
      <li><a href="{{ url('trips') }}">🧳 My Trips</a></li>
      <li><a href="{{ url('itinerary') }}">📅 Build Itinerary</a></li>
      <li><a href="{{ url('search') }}">🌍 City Search</a></li>
      <li><a href="{{ url('community') }}">🌐 Community Trips</a></li>
      <li><a href="{{ url('profile') }}">👤 Profile & Settings</a></li>
      <li>
          <form action="{{ route('logout') }}" method="POST" style="display:inline;">
              @csrf
              <button type="submit" style="background:none; border:none; color:white; font-size:17px; cursor:pointer; padding:14px; text-align:left; width:100%;">🚪 Logout</button>
          </form>
      </li>
    </ul>
  </div>

  <!-- MAIN -->
  <div class="main">
    <!-- TOPBAR -->
    <div class="topbar">
      <div>
        <h1>Admin Dashboard 📊</h1>
        <p>Monitor users, trips, engagement, and analytics</p>
      </div>
      <div class="admin-profile">
        <img src="{{ auth()->user()->avatar ?? 'https://i.pravatar.cc/150?img=15' }}" alt="Admin Avatar">
        <div>
          <h3>{{ auth()->user()->full_name ?? 'Admin User' }}</h3>
          <p style="color:#6b7280;">Super Administrator</p>
        </div>
      </div>
    </div>

    <!-- STATS -->
    <div class="stats-grid">
      <div class="stat-card">
        <h3>Total Users</h3>
        <h2>{{ number_format($stats['users'] ?? 0) }}</h2>
      </div>
      <div class="stat-card">
        <h3>Total Trips</h3>
        <h2>{{ number_format($stats['trips'] ?? 0) }}</h2>
      </div>
      <div class="stat-card">
        <h3>Total Notes</h3>
        <h2>{{ number_format($stats['notes'] ?? 0) }}</h2>
      </div>
      <div class="stat-card">
        <h3>Shared Itineraries</h3>
        <h2>{{ number_format($stats['itineraries'] ?? 0) }}</h2>
      </div>
    </div>

    <!-- ANALYTICS -->
    <div class="analytics-grid">
      <!-- CHART -->
      <div class="chart-card">
        <h2>User Engagement Analytics</h2>
        <div class="chart-placeholder">
          📈 Analytics Chart Placeholder
          <p style="margin-top:15px; color:#6b7280; font-size:15px;">Monthly active users and trip creation trends</p>
        </div>
      </div>

      <!-- DESTINATIONS -->
      <div class="chart-card">
        <h2>Popular Destinations 🌍</h2>
        <div class="destination-list">
          @forelse($popularLocations as $location)
            <div class="destination-item">
              <div class="destination-left">
                <!-- Fallback image used if location image is unavailable -->
                <img src="{{ $location->image_url ?? 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e' }}" alt="{{ $location->location }}">
                <div class="destination-info">
                  <h3>{{ $location->location }}</h3>
                </div>
              </div>
              <div class="trip-count">
                {{ number_format($location->count) }}
              </div>
            </div>
          @empty
            <p>No popular destinations yet.</p>
          @endforelse
        </div>
      </div>
    </div>

    <!-- USERS TABLE -->
    <div class="table-card">
      <h2>User Management 👥</h2>
      @if(session('success'))
        <div style="background:#dcfce7; color:#166534; padding:15px; border-radius:10px; margin-bottom:15px;">
            {{ session('success') }}
        </div>
      @endif
      @if(session('error'))
        <div style="background:#fee2e2; color:#991b1b; padding:15px; border-radius:10px; margin-bottom:15px;">
            {{ session('error') }}
        </div>
      @endif

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
        <tbody>
          @forelse($recentUsers as $user)
            <tr>
              <td>{{ $user->name ?? $user->full_name }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->trip_count ?? 0 }}</td>
              <td>
                @if($user->active ?? true)
                  <span class="status active">Active</span>
                @else
                  <span class="status inactive">Inactive</span>
                @endif
              </td>
              <td>
                <button class="action-btn view-btn" onclick="window.location='{{ url('admin/users/' . $user->id) }}'">View</button>
                <form action="{{ url('admin/users/' . $user->id) }}" method="POST" style="display:inline-block;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" style="text-align:center;">No users found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>