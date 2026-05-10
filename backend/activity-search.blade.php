<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Activity Search - Traveloop</title>

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

    /* HEADER */
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

    .view-trip-btn{
      background:#2563eb;
      color:white;
      border:none;
      padding:15px 25px;
      border-radius:12px;
      font-size:16px;
      font-weight:bold;
      cursor:pointer;
      transition:0.3s;
      text-decoration: none;
    }

    .view-trip-btn:hover{
      background:#1d4ed8;
    }

    /* SEARCH FILTER */
    .search-section{
      background:white;
      padding:30px;
      border-radius:25px;
      margin-bottom:35px;
      box-shadow:0 8px 20px rgba(0,0,0,0.08);
    }

    .search-grid{
      display:grid;
      grid-template-columns:2fr 1fr 1fr 1fr;
      gap:20px;
    }

    .search-grid input,
    .search-grid select{
      padding:16px;
      border:1px solid #d1d5db;
      border-radius:12px;
      font-size:15px;
    }

    .search-btn{
      background:#2563eb;
      color:white;
      border:none;
      padding:16px;
      border-radius:12px;
      font-size:16px;
      font-weight:bold;
      cursor:pointer;
    }

    /* CATEGORY TAGS */
    .categories{
      display:flex;
      flex-wrap:wrap;
      gap:12px;
      margin-top:20px;
    }

    .category{
      background:#dbeafe;
      color:#2563eb;
      padding:10px 18px;
      border-radius:25px;
      font-weight:bold;
      cursor:pointer;
      transition:0.3s;
      text-decoration: none;
      display: inline-block;
    }

    .category:hover{
      background:#2563eb;
      color:white;
    }

    /* ACTIVITY GRID */
    .activity-grid{
      display:grid;
      grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
      gap:30px;
    }

    /* CARD */
    .activity-card{
      background:white;
      border-radius:25px;
      overflow:hidden;
      box-shadow:0 8px 20px rgba(0,0,0,0.08);
      transition:0.3s;
    }

    .activity-card:hover{
      transform:translateY(-6px);
    }

    .activity-image{
      position:relative;
    }

    .activity-image img{
      width:100%;
      height:240px;
      object-fit:cover;
    }

    .activity-type{
      position:absolute;
      top:15px;
      left:15px;
      background:white;
      color:#111827;
      padding:8px 14px;
      border-radius:20px;
      font-weight:bold;
      font-size:14px;
    }

    /* CONTENT */
    .activity-content{
      padding:25px;
    }

    .activity-content h2{
      color:#111827;
      margin-bottom:10px;
    }

    .activity-content p{
      color:#6b7280;
      line-height:1.7;
      margin-bottom:20px;
    }

    /* INFO */
    .activity-info{
      display:grid;
      grid-template-columns:1fr 1fr;
      gap:15px;
      margin-bottom:25px;
    }

    .info-box{
      background:#eff6ff;
      padding:15px;
      border-radius:12px;
    }

    .info-box h4{
      color:#2563eb;
      margin-bottom:5px;
      font-size:14px;
    }

    .info-box span{
      font-weight:bold;
      color:#111827;
    }

    /* BUTTONS */
    .btn-group{
      display:flex;
      gap:12px;
    }

    .btn{
      flex:1;
      border:none;
      padding:14px;
      border-radius:12px;
      font-size:15px;
      font-weight:bold;
      cursor:pointer;
      transition:0.3s;
      text-align: center;
      text-decoration: none;
    }

    .details-btn{
      background:#e5e7eb;
      color:#111827;
    }

    .add-btn{
      background:#059669;
      color:white;
    }

    .btn:hover{
      opacity:0.9;
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
      .search-grid{
        grid-template-columns:1fr;
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

    <!-- TOPBAR -->
    <div class="topbar">
      <div>
        <h1>Discover Activities 🎯</h1>
        <p>Explore experiences and add them to your trip</p>
      </div>
      <a href="{{ url('/itinerary-view') }}" class="view-trip-btn">
        View Itinerary
      </a>
    </div>

    <!-- SEARCH -->
    <div class="search-section">
      <form action="{{ url('/activity-search') }}" method="GET" class="search-grid">
        <input 
          type="text" 
          name="q" 
          placeholder="Search activities..." 
          value="{{ request('q') }}"
        >

        <select name="category">
          <option value="">All Categories</option>
          <option value="Adventure" {{ request('category') == 'Adventure' ? 'selected' : '' }}>Adventure</option>
          <option value="Food" {{ request('category') == 'Food' ? 'selected' : '' }}>Food</option>
          <option value="Nature" {{ request('category') == 'Nature' ? 'selected' : '' }}>Nature</option>
          <option value="Culture" {{ request('category') == 'Culture' ? 'selected' : '' }}>Culture</option>
          <option value="Nightlife" {{ request('category') == 'Nightlife' ? 'selected' : '' }}>Nightlife</option>
        </select>

        <select name="budget">
          <option value="">Any Budget</option>
          <option value="Low Cost" {{ request('budget') == 'Low Cost' ? 'selected' : '' }}>Low Cost</option>
          <option value="Medium" {{ request('budget') == 'Medium' ? 'selected' : '' }}>Medium</option>
          <option value="Luxury" {{ request('budget') == 'Luxury' ? 'selected' : '' }}>Luxury</option>
        </select>

        <button type="submit" class="search-btn">
          Search
        </button>
      </form>

      <!-- TAGS (Optional quick filters) -->
      <div class="categories">
        <a href="{{ url('/activity-search?category=Beach') }}" class="category">Beach</a>
        <a href="{{ url('/activity-search?category=Hiking') }}" class="category">Hiking</a>
        <a href="{{ url('/activity-search?category=Food Tour') }}" class="category">Food Tour</a>
        <a href="{{ url('/activity-search?category=Museum') }}" class="category">Museum</a>
        <a href="{{ url('/activity-search?category=Shopping') }}" class="category">Shopping</a>
        <a href="{{ url('/activity-search?category=Nightlife') }}" class="category">Nightlife</a>
      </div>
    </div>

    <!-- ACTIVITIES -->
    <div class="activity-grid">

      @forelse($activities ?? [] as $activity)
        <div class="activity-card">
          <div class="activity-image">
            <img src="{{ $activity->image_url ?? 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e' }}" alt="{{ $activity->name }}">
            <div class="activity-type">
              {{ $activity->category ?? 'General' }}
            </div>
          </div>

          <div class="activity-content">
            <h2>{{ $activity->name }}</h2>
            <p>{{ Str::limit($activity->description, 80) }}</p>

            <div class="activity-info">
              <div class="info-box">
                <h4>Duration</h4>
                <span>{{ $activity->duration ?? 'N/A' }} Hours</span>
              </div>
              <div class="info-box">
                <h4>Cost</h4>
                <span>${{ number_format($activity->cost ?? 0, 2) }}</span>
              </div>
              <div class="info-box">
                <h4>Rating</h4>
                <span>{{ $activity->rating ?? 'New' }} ⭐</span>
              </div>
              <div class="info-box">
                <h4>City</h4>
                <span>{{ $activity->location ?? 'Unknown' }}</span>
              </div>
            </div>

            <div class="btn-group">
              <a href="{{ url('/activities/' . $activity->id) }}" class="btn details-btn">Details</a>
              <button type="button" class="btn add-btn" onclick="addActivity('{{ addslashes($activity->name) }}', {{ $activity->id }})">
                Add Activity
              </button>
            </div>
          </div>
        </div>
      @empty
        <!-- STATIC FALLBACK / EMPTY STATE -->
        <div class="activity-card">
          <div class="activity-image">
            <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e" alt="Bali Beach">
            <div class="activity-type">Beach</div>
          </div>
          <div class="activity-content">
            <h2>Bali Beach Adventure</h2>
            <p>Relax on tropical beaches and enjoy water sports with guided tours.</p>
            <div class="activity-info">
              <div class="info-box"><h4>Duration</h4><span>3 Hours</span></div>
              <div class="info-box"><h4>Cost</h4><span>$80</span></div>
              <div class="info-box"><h4>Rating</h4><span>4.8 ⭐</span></div>
              <div class="info-box"><h4>City</h4><span>Bali</span></div>
            </div>
            <div class="btn-group">
              <button class="btn details-btn">Details</button>
              <button class="btn add-btn" onclick="addActivity('Bali Beach Adventure', 1)">Add Activity</button>
            </div>
          </div>
        </div>
      @endforelse

    </div>
  </div>

  <!-- JAVASCRIPT -->
  <script>
    function addActivity(activityName, activityId) {
      // You can replace this with a Javascript fetch()/axios call to add it to the itinerary
      alert(activityName + " added to your itinerary!");
    }
  </script>

</body>
</html>