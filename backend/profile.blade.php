<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Profile & Settings - Traveloop</title>

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
      width:260px;
      height:100vh;
      background:#1e3a8a;
      color:white;
      padding:30px 20px;
      position:fixed;
      left:0;
      top:0;
      overflow-y:auto;
    }

    .sidebar::-webkit-scrollbar{
      width:6px;
    }

    .sidebar::-webkit-scrollbar-thumb{
      background:rgba(255,255,255,0.3);
      border-radius:10px;
    }

    .logo{
      font-size:32px;
      font-weight:bold;
      margin-bottom:40px;
    }

    .menu{
      list-style:none;
    }

    .menu li{
      margin:20px 0;
    }

    .menu a{
      color:white;
      text-decoration:none;
      font-size:18px;
      padding:12px;
      display:block;
      border-radius:10px;
      transition:0.3s;
    }

    .menu a:hover{
      background:rgba(255,255,255,0.2);
    }

    /* MAIN */
    .main{
      margin-left:260px;
      width:calc(100% - 260px);
      padding:40px;
    }

    /* ALERTS */
    .alert-success {
      background-color: #10b981;
      color: white;
      padding: 15px 20px;
      border-radius: 12px;
      margin-bottom: 25px;
      font-weight: bold;
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
      font-size:38px;
      color:#111827;
    }

    .topbar p{
      color:#6b7280;
      margin-top:8px;
    }

    .save-btn{
      background:#2563eb;
      color:white;
      border:none;
      padding:15px 28px;
      border-radius:12px;
      font-size:16px;
      font-weight:bold;
      cursor:pointer;
      transition:0.3s;
    }

    .save-btn:hover{
      background:#1d4ed8;
    }

    /* PROFILE SECTION */
    .profile-container{
      display:grid;
      grid-template-columns:1fr 2fr;
      gap:30px;
    }

    /* LEFT PANEL */
    .profile-card{
      background:white;
      border-radius:25px;
      padding:35px;
      text-align:center;
      box-shadow:0 8px 20px rgba(0,0,0,0.08);
      height:fit-content;
    }

    .profile-card img{
      width:140px;
      height:140px;
      border-radius:50%;
      object-fit:cover;
      margin-bottom:20px;
      border:6px solid #dbeafe;
    }

    .profile-card h2{
      color:#111827;
      margin-bottom:10px;
    }

    .profile-card p{
      color:#6b7280;
      margin-bottom:25px;
    }

    .profile-stats{
      display:grid;
      grid-template-columns:1fr 1fr;
      gap:15px;
      margin-top:25px;
    }

    .stat-box{
      background:#eff6ff;
      padding:18px;
      border-radius:15px;
    }

    .stat-box h3{
      color:#2563eb;
      margin-bottom:8px;
      font-size:14px;
    }

    .stat-box span{
      font-size:22px;
      font-weight:bold;
      color:#111827;
    }

    /* RIGHT PANEL */
    .settings-card{
      background:white;
      border-radius:25px;
      padding:35px;
      box-shadow:0 8px 20px rgba(0,0,0,0.08);
      margin-bottom:30px;
    }

    .settings-card h2{
      margin-bottom:30px;
      color:#111827;
    }

    /* FORM */
    .form-grid{
      display:grid;
      grid-template-columns:1fr 1fr;
      gap:25px;
    }

    .input-group{
      display:flex;
      flex-direction:column;
    }

    .input-group label{
      margin-bottom:10px;
      font-weight:bold;
      color:#374151;
    }

    .input-group input,
    .input-group select,
    .input-group textarea{
      padding:15px;
      border:1px solid #d1d5db;
      border-radius:12px;
      font-size:15px;
    }

    .input-group textarea{
      resize:none;
      height:120px;
    }

    .full-width{
      grid-column:1/3;
    }

    /* SWITCH */
    .toggle-section{
      margin-top:25px;
    }

    .toggle-item{
      display:flex;
      justify-content:space-between;
      align-items:center;
      padding:18px;
      background:#f9fafb;
      border-radius:15px;
      margin-bottom:15px;
    }

    .toggle-info h3{
      margin-bottom:5px;
      color:#111827;
    }

    .toggle-info p{
      color:#6b7280;
      font-size:14px;
    }

    .switch{
      position:relative;
      width:60px;
      height:30px;
    }

    .switch input{
      display:none;
    }

    .slider{
      position:absolute;
      cursor:pointer;
      top:0;
      left:0;
      right:0;
      bottom:0;
      background:#d1d5db;
      border-radius:30px;
      transition:0.3s;
    }

    .slider::before{
      content:'';
      position:absolute;
      height:24px;
      width:24px;
      left:3px;
      bottom:3px;
      background:white;
      border-radius:50%;
      transition:0.3s;
    }

    input:checked + .slider{
      background:#2563eb;
    }

    input:checked + .slider::before{
      transform:translateX(30px);
    }

    /* DANGER ZONE */
    .danger-zone{
      border:2px solid #fee2e2;
      background:#fff5f5;
    }

    .danger-zone h2{
      color:#b91c1c;
    }

    .delete-btn{
      background:#ef4444;
      color:white;
      border:none;
      padding:15px 25px;
      border-radius:12px;
      font-size:15px;
      font-weight:bold;
      cursor:pointer;
      margin-top:20px;
    }

    /* RESPONSIVE */
    @media(max-width:1000px){
      .sidebar{
        display:none;
      }
      .main{
        margin-left:0;
        width:100%;
      }
      .profile-container{
        grid-template-columns:1fr;
      }
      .form-grid{
        grid-template-columns:1fr;
      }
      .full-width{
        grid-column:1/2;
      }
    }
  </style>
</head>
<body>

  <!-- SIDEBAR -->
  <div class="sidebar">
    <div class="logo">
      Traveloop
    </div>

    <ul class="menu">
      <li><a href="{{ url('/dashboard') }}">🏠 Dashboard</a></li>
      <li><a href="{{ url('/create-trip') }}">✈ Create Trip</a></li>
      <li><a href="{{ url('/my-trips') }}">🧳 My Trips</a></li>
      <li><a href="{{ url('/itinerary') }}">📅 Build Itinerary</a></li>
      <li><a href="{{ url('/itinerary-view') }}">🗺 Itinerary View</a></li>
      <li><a href="{{ url('/search') }}">🌍 City Search</a></li>
      <li><a href="{{ url('/activity-search') }}">🎯 Activity Search</a></li>
      <li><a href="{{ url('/budget') }}">💰 Budget Planner</a></li>
      <li><a href="{{ url('/packing') }}">🎒 Packing Checklist</a></li>
      <li><a href="{{ url('/community-trips') }}">🌐 Community Trips</a></li>
      <li><a href="{{ url('/trip-notes') }}">📝 Trip Notes</a></li>
      <li><a href="{{ url('/profile') }}">👤 Profile & Settings</a></li>
      <li><a href="{{ url('/admin') }}">📊 Admin Analytics</a></li>
      <li>
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
          @csrf
          <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">🚪 Logout</a>
        </form>
      </li>
    </ul>
  </div>

  <!-- MAIN -->
  <div class="main">
    
    @if (session('success'))
      <div class="alert-success">
        {{ session('success') }}
      </div>
    @endif

    <!-- START PROFILE UPDATE FORM -->
    <form action="{{ url('/profile/update') }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <!-- TOPBAR -->
      <div class="topbar">
        <div>
          <h1>Profile & Settings 👤</h1>
          <p>Manage your account and preferences</p>
        </div>
        
        <button type="submit" class="save-btn">
          Save Changes
        </button>
      </div>

      <!-- PROFILE -->
      <div class="profile-container">

        <!-- LEFT -->
        <div class="profile-card">
          <img src="{{ $user->avatar_url ?? 'https://i.pravatar.cc/150?img=12' }}" alt="Profile Photo">
          
          <h2>{{ $user->name ?? 'Alex Johnson' }}</h2>
          <p>{{ $user->headline ?? 'Travel Enthusiast & Adventure Explorer' }}</p>

          <input type="file" name="avatar" accept="image/*">

          <!-- STATS -->
          <div class="profile-stats">
            <div class="stat-box">
              <h3>Total Trips</h3>
              <span>{{ $user->total_trips ?? 18 }}</span>
            </div>
            <div class="stat-box">
              <h3>Countries</h3>
              <span>{{ $user->countries_visited ?? 12 }}</span>
            </div>
            <div class="stat-box">
              <h3>Activities</h3>
              <span>{{ $user->activities_count ?? 95 }}</span>
            </div>
            <div class="stat-box">
              <h3>Followers</h3>
              <span>{{ $user->followers_count ?? 420 }}</span>
            </div>
          </div>
        </div>

        <!-- RIGHT -->
        <div>
          <!-- ACCOUNT SETTINGS -->
          <div class="settings-card">
            <h2>Account Information</h2>
            
            <div class="form-grid">
              <div class="input-group">
                <label>Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name ?? 'Alex Johnson') }}" required>
              </div>

              <div class="input-group">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email', $user->email ?? 'alex@email.com') }}" required>
              </div>

              <div class="input-group">
                <label>Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '+1 987654321') }}">
              </div>

              <div class="input-group">
                <label>Language</label>
                <select name="language">
                  <option value="en" {{ old('language', $user->language ?? 'en') == 'en' ? 'selected' : '' }}>English</option>
                  <option value="fr" {{ old('language', $user->language ?? 'en') == 'fr' ? 'selected' : '' }}>French</option>
                  <option value="ja" {{ old('language', $user->language ?? 'en') == 'ja' ? 'selected' : '' }}>Japanese</option>
                </select>
              </div>

              <div class="input-group full-width">
                <label>Bio</label>
                <textarea name="bio">{{ old('bio', $user->bio ?? 'Passionate traveler exploring cultures, adventures, and unforgettable experiences around the world.') }}</textarea>
              </div>
            </div>
          </div>

          <!-- PREFERENCES -->
          <div class="settings-card">
            <h2>Preferences</h2>
            
            <div class="toggle-section">
              <!-- TOGGLE -->
              <div class="toggle-item">
                <div class="toggle-info">
                  <h3>Public Profile</h3>
                  <p>Allow others to view your profile</p>
                </div>
                <label class="switch">
                  <input type="checkbox" name="public_profile" value="1" {{ old('public_profile', $user->public_profile ?? true) ? 'checked' : '' }}>
                  <span class="slider"></span>
                </label>
              </div>

              <!-- TOGGLE -->
              <div class="toggle-item">
                <div class="toggle-info">
                  <h3>Email Notifications</h3>
                  <p>Receive updates and trip reminders</p>
                </div>
                <label class="switch">
                  <input type="checkbox" name="email_notifications" value="1" {{ old('email_notifications', $user->email_notifications ?? true) ? 'checked' : '' }}>
                  <span class="slider"></span>
                </label>
              </div>

              <!-- TOGGLE -->
              <div class="toggle-item">
                <div class="toggle-info">
                  <h3>Dark Mode</h3>
                  <p>Enable dark theme appearance</p>
                </div>
                <label class="switch">
                  <input type="checkbox" name="dark_mode" value="1" {{ old('dark_mode', $user->dark_mode ?? false) ? 'checked' : '' }}>
                  <span class="slider"></span>
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
    <!-- END PROFILE UPDATE FORM -->

    <!-- DANGER ZONE -->
    <form action="{{ url('/profile/delete') }}" method="POST" class="settings-card danger-zone" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
      @csrf
      @method('DELETE')

      <h2>Danger Zone ⚠</h2>
      <p style="color:#7f1d1d;line-height:1.8;">
        Deleting your account will permanently remove all trips, itineraries, activities, and travel history.
      </p>

      <button type="submit" class="delete-btn">
        Delete Account
      </button>
    </form>

  </div>
</body>
</html>